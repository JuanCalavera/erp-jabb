<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'sku',
        'quantity',
        'enterprise',
        'cost',
        'total_cost'
    ];

    public function enterprise()
    {
        return $this->hasOne(Enterprise::class, 'id', 'enterprise')->first();
    }
}
