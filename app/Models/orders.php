<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'id_products',
        'costumer_id',
        'products_id',
        'status',
    ];
}
