<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'total',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Encontra (ou cria) o carrinho identificado pelo token enviado
     * pelo cliente Angular (header X-Cart-Token). O token é armazenado
     * na coluna session_id, que aqui funciona como um identificador
     * de carrinho opaco em vez da sessão PHP (a API é stateless).
     */
    public static function forToken(string $token, bool $create = true): ?self
    {
        $cart = static::where('session_id', $token)->first();

        if (! $cart && $create) {
            $cart = static::create(['session_id' => $token, 'total' => 0]);
        }

        return $cart;
    }

    /**
     * Recalcula o total do carrinho a partir dos itens (em centavos).
     */
    public function recalculateTotal(): void
    {
        $this->update(['total' => (int) $this->items()->sum('total')]);
    }
}
