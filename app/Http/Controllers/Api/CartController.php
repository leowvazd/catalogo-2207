<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->header('X-Cart-Token');
        $cart = $token ? Cart::forToken($token, create: false) : null;

        return response()->json($this->present($cart));
    }

    public function add(Request $request, ProductVariant $variant)
    {
        abort_unless($variant->is_active, 404);

        $quantity = max(1, (int) $request->input('quantity', 1));
        $token = $request->header('X-Cart-Token') ?: (string) Str::uuid();

        $cart = Cart::forToken($token);

        $item = $cart->items()->where('product_variant_id', $variant->id)->first();
        $desiredQuantity = min($variant->stock, ($item->quantity ?? 0) + $quantity);

        if ($desiredQuantity < 1) {
            return response()->json(['message' => 'Produto sem estoque disponível.'], 422);
        }

        $unitPrice = (int) $variant->getRawOriginal('price');

        if ($item) {
            $item->update([
                'quantity' => $desiredQuantity,
                'unit_price' => $unitPrice,
                'total' => $unitPrice * $desiredQuantity,
            ]);
        } else {
            $cart->items()->create([
                'product_variant_id' => $variant->id,
                'quantity' => $desiredQuantity,
                'unit_price' => $unitPrice,
                'total' => $unitPrice * $desiredQuantity,
            ]);
        }

        $cart->recalculateTotal();

        return response()->json($this->present($cart));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $token = $request->header('X-Cart-Token');
        $cart = $token ? Cart::forToken($token, create: false) : null;

        if (! $cart) {
            return response()->json(['message' => 'Carrinho não encontrado.'], 404);
        }

        $item = $cart->items()->where('product_variant_id', $variant->id)->first();

        if ($item) {
            $quantity = (int) $request->input('quantity', 1);

            if ($quantity < 1) {
                $item->delete();
            } else {
                $quantity = min($quantity, $variant->stock);
                $item->update([
                    'quantity' => $quantity,
                    'total' => $item->unit_price * $quantity,
                ]);
            }

            $cart->recalculateTotal();
        }

        return response()->json($this->present($cart));
    }

    public function remove(Request $request, ProductVariant $variant)
    {
        $token = $request->header('X-Cart-Token');
        $cart = $token ? Cart::forToken($token, create: false) : null;

        if ($cart) {
            $cart->items()->where('product_variant_id', $variant->id)->delete();
            $cart->recalculateTotal();
        }

        return response()->json($this->present($cart));
    }

    public function clear(Request $request)
    {
        $token = $request->header('X-Cart-Token');
        $cart = $token ? Cart::forToken($token, create: false) : null;

        if ($cart) {
            $cart->items()->delete();
            $cart->recalculateTotal();
        }

        return response()->json($this->present($cart));
    }

    private function present(?Cart $cart): array
    {
        if (! $cart) {
            return ['cart_token' => null, 'items' => [], 'total' => 0.0];
        }

        $items = $cart->items()->with(['productVariant.product', 'productVariant.images'])->get();

        return [
            'cart_token' => $cart->session_id,
            'items' => $items->map(function ($item) {
                $variant = $item->productVariant;
                $image = $variant->images->first()?->filename;

                return [
                    'variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'sku' => $variant->sku,
                    'quantity' => $item->quantity,
                    'stock' => $variant->stock,
                    'unit_price' => $item->unit_price / 100,
                    'total' => $item->total / 100,
                    'image' => $image ? Storage::url('products/variants/' . $image) : null,
                ];
            }),
            'total' => $cart->total / 100,
        ];
    }
}
