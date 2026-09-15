<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'measure_unit',
        'group',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Consultas de Cadastro
    |--------------------------------------------------------------------------
    */

    /**
     * Scope para filtrar produtos por tipo informado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search, ?string $type)
    {
        if (empty($search)) {
            return $query;
        }

        $allowedTypes = [
            'name'  => 'name',
            'id' => 'id',
        ];

        $column = $allowedTypes[$type] ?? 'name';

        return $query->where($column, 'LIKE', "%{$search}%");
    }

    /**
     * Scope para filtrar produtos por tipo informado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchVariants(Builder $query, ?string $product_id)
    {
        if (empty($product_id)) {
            return $query;
        }

        return $query->where('id', '=', $product_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Consultas de Vendas
    |--------------------------------------------------------------------------
    */

    /**
     * Scope para filtrar produtos por tipo informado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query)
    {
        return  $query->where('is_active', '=' ,true);
    }

    /**
     * Scope para filtrar produtos por tipo informado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured(Builder $query)
    {
        return  $query->where('is_featured', '=' ,true);
    }


    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relacionamento: O produt tem vários vínculos de variante.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
