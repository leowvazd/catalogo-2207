<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Services\TelegramNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request, TelegramNotifier $telegram)
    {
        $token = $request->header('X-Cart-Token');
        $cart = $token ? Cart::forToken($token, create: false) : null;
        $items = $cart ? $cart->items()->with('productVariant.product')->get() : collect();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'Carrinho vazio.'], 422);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'cnpjcpf' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postalcode' => ['nullable', 'string', 'max:30'],
        ]);

        foreach ($items as $item) {
            if ($item->quantity > $item->productVariant->stock) {
                return response()->json([
                    'message' => "Estoque insuficiente para {$item->productVariant->product->name}.",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($data, $items, $cart) {
            $customer = Customer::create(array_merge($data, [
                'email' => $data['email'] ?? '',
                'cnpjcpf' => $data['cnpjcpf'] ?? '',
                'address' => $data['address'] ?? '',
                'number' => $data['number'] ?? '',
                'city' => $data['city'] ?? '',
                'state' => $data['state'] ?? '',
                'postalcode' => $data['postalcode'] ?? '',
            ]));

            $order = Order::create([
                'session_id' => $cart->session_id,
                'customer_id' => $customer->id,
                'status' => Order::STATUS_PENDING,
                'total' => $items->sum('total'),
            ]);

            foreach ($items as $item) {
                $variant = $item->productVariant;

                $order->items()->create([
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_description' => $variant->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total,
                ]);

                $variant->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
            $cart->recalculateTotal();

            return $order;
        });

        $telegram->notifyNewOrder($order);

        return response()->json($this->present($order), 201);
    }

    public function show(Request $request, Order $order)
    {
        $token = $request->header('X-Cart-Token');

        abort_unless($token && $order->session_id === $token, 404);

        return response()->json($this->present($order));
    }

    private function present(Order $order): array
    {
        $order->load('items', 'customer');

        return [
            'id' => $order->id,
            'status' => $order->status,
            'total' => $order->total / 100,
            'customer' => [
                'name' => $order->customer->name,
                'phone' => $order->customer->phone,
            ],
            'items' => $order->items->map(fn ($item) => [
                'product_name' => $item->product_name,
                'variant_description' => $item->variant_description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price / 100,
                'total' => $item->total / 100,
            ]),
        ];
    }
}
