<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costumers extends Model
{
    protected $table = 'costumers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}
