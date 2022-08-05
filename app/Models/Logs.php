<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{

    protected $fillable = [
        'status',
        'content',
        'created_at'
    ];

    use HasFactory;
}
