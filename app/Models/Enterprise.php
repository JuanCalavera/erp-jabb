<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $fillable = [
        'name',
        'total',
        'total_cost'
    ];

    public function products(){
        return $this->hasMany(Products::class, 'enterprise', 'id')->get();
    }
}
