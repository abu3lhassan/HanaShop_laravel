<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_Details extends Model
{
    protected $table = 'products__details';

    protected $fillable = [
        'id_products',
        'price',
        'qty',
        'image',
        'color',
    ];
}
