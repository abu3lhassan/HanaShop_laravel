<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'store_description',
        'business_name',
        'vat_number',
        'cr_number',
        'address',
        'city',
        'country',
        'email',
        'phone',
        'whatsapp',
        'vat_rate',
        'invoice_note',
        'logo_path',
        'favicon_path',
    ];

    public static function current(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'store_name' => 'HanaShop',
                'store_description' => 'Modern e-commerce platform.',
                'business_name' => 'HanaShop',
                'vat_number' => 'VAT-NUMBER-HERE',
                'cr_number' => 'CR-NUMBER-HERE',
                'address' => 'Riyadh',
                'city' => 'Riyadh',
                'country' => 'Saudi Arabia',
                'email' => 'info@hanashop.test',
                'phone' => '0500000000',
                'whatsapp' => '0500000000',
                'vat_rate' => 15.00,
                'invoice_note' => 'This invoice was generated from HanaShop checkout records.',
            ]
        );
    }
}