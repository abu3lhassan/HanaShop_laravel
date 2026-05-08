<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hanashop.test'],
            ['name' => 'HanaShop Admin', 'password' => Hash::make('password')]
        );

        $now = now();

        DB::table('products')->upsert([
            ['id' => 1, 'name' => 'Smartphone', 'Description' => 'Clean design and smooth everyday performance.', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Modern Laptop', 'Description' => 'High-performance laptop for work and productivity.', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Headphones', 'Description' => 'Comfortable headphones with clear sound.', 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['name', 'Description', 'updated_at']);

        DB::table('products__details')->upsert([
            ['id' => 1, 'id_products' => 1, 'price' => 699, 'qty' => 15, 'color' => 'Black', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'id_products' => 2, 'price' => 899, 'qty' => 8, 'color' => 'Silver', 'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'id_products' => 3, 'price' => 129, 'qty' => 20, 'color' => 'White', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['id_products', 'price', 'qty', 'color', 'image', 'updated_at']);

        DB::table('zena')->upsert([
            ['id' => 1, 'name' => 'Decorative Vase', 'Description' => 'Elegant vase with a premium home style.', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Wall Art', 'Description' => 'Modern wall art for a polished atmosphere.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Candle Holder', 'Description' => 'Warm decorative piece for modern rooms.', 'image' => 'https://images.unsplash.com/photo-1602874801007-bd7e78ca4d14?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['name', 'Description', 'image', 'updated_at']);

        DB::table('kitchen_tools')->upsert([
            ['id' => 1, 'name' => 'Chef Knife Set', 'Description' => 'Durable knife set for daily cooking.', 'image' => 'https://images.unsplash.com/photo-1593618998160-e34014e67546?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Cutting Board', 'Description' => 'Clean bamboo board for meal preparation.', 'image' => 'https://images.unsplash.com/photo-1543352634-a1c51d9f1fa7?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Spatula Set', 'Description' => 'Heat-resistant tools for comfortable cooking.', 'image' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=900&q=80', 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['name', 'Description', 'image', 'updated_at']);

        DB::table('costumers')->upsert([
            ['id' => 1, 'name' => 'Sara Ahmed', 'email' => 'sara@example.com', 'phone' => '0500000001', 'address' => 'Riyadh', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Omar Ali', 'email' => 'omar@example.com', 'phone' => '0500000002', 'address' => 'Jeddah', 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['name', 'email', 'phone', 'address', 'updated_at']);

        DB::table('invioces')->upsert([
            ['id' => 1, 'costumer_id' => 1, 'products_id' => 1, 'qty' => 1, 'price' => 699, 'total' => 699, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'costumer_id' => 2, 'products_id' => 2, 'qty' => 1, 'price' => 899, 'total' => 899, 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['costumer_id', 'products_id', 'qty', 'price', 'total', 'updated_at']);
    }
}
