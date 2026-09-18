<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    /**
     * Envia os dados do pedido recém-criado para o Telegram do lojista.
     * Falhas aqui nunca devem impedir a finalização do pedido.
     */
    public function notifyNewOrder(Order $order): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $token || ! $chatId) {
            return;
        }

        $order->loadMissing('items', 'customer');
        $customer = $order->customer;

        $lines = [
            "🛍 <b>Novo pedido #{$order->id}</b>",
            '',
            '<b>Cliente:</b> ' . e($customer->name),
            '<b>Telefone:</b> ' . e($customer->phone),
        ];

        if ($customer->email) {
            $lines[] = '<b>E-mail:</b> ' . e($customer->email);
        }

        if ($customer->cnpjcpf) {
            $lines[] = '<b>CPF/CNPJ:</b> ' . e($customer->cnpjcpf);
        }

        $address = implode(', ', array_filter([
            $customer->address,
            $customer->number,
            $customer->city,
            $customer->state,
            $customer->postalcode,
        ]));

        if ($address) {
            $lines[] = '<b>Endereço:</b> ' . e($address);
        }

        $lines[] = '';
        $lines[] = '<b>Itens:</b>';

        foreach ($order->items as $item) {
            $lines[] = sprintf(
                '• %s (%s) x%d — R$ %s',
                e($item->product_name),
                e($item->variant_description),
                $item->quantity,
                number_format($item->total / 100, 2, ',', '.')
            );
        }

        $lines[] = '';
        $lines[] = sprintf('<b>Total: R$ %s</b>', number_format($order->total / 100, 2, ',', '.'));

        try {
            Http::timeout(5)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => implode("\n", $lines),
                'parse_mode' => 'HTML',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Falha ao notificar pedido no Telegram: ' . $e->getMessage());
        }
    }
}
