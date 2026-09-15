<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'product_id',
        'sku',
        'stock',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Accessor / Mutator para formatar o preço de Reais (Float) para Centavos (Int) e vice-versa.
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100, // Do banco (ex: 9990) para a app (99.90)
            set: fn ($value) => (int) round($value * 100) // Da app (99.90) para o banco (9990)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    /**
     * Relacionamento: Esta variante pertence a um produto pai.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacionamento: A variante tem vários vínculos de atributos (ex: Cor -> Azul, Tamanho -> M).
     */
    public function variantAttributes(): HasMany
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }
    
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
