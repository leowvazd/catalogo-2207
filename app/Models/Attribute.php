<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Consultas
    |--------------------------------------------------------------------------
    */

    /**
     * Scope para filtrar produtos por tipo informado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search)
    {
        if (empty($search)) {
            return $query;
        }
        return $query->where('name', 'LIKE', "%{$search}%");
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    /**
     * Relacionamento: Um atributo possui muitas opções.
     */
    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}