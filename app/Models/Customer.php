<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cnpjcpf',
        'ierg',
        'name',
        'phone',
        'email',
        'address',
        'postalcode',
        'number',
        'city',
        'ibge',
        'state',
        'country',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
