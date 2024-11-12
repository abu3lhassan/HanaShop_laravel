<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Add items for the Electronics category in the `products` table
        DB::table('products')->insert([
            ['name' => 'Smartphone', 'Description' => 'Latest smartphone model'],
            ['name' => 'Laptop', 'Description' => 'High-performance laptop'],
            ['name' => 'Headphones', 'Description' => 'Noise-cancelling headphones'],
        ]);

        // Add items for the Decor category in the `zena` table
        DB::table('zena')->insert([
            ['name' => 'Decorative Vase', 'Description' => 'Elegant glass vase', 'image' => 'vase_image_url_here'],
            ['name' => 'Wall Art', 'Description' => 'Modern wall art piece', 'image' => 'wall_art_image_url_here'],
            ['name' => 'Candle Holder', 'Description' => 'Vintage candle holder', 'image' => 'candle_holder_image_url_here'],
        ]);

        // Add items for the Kitchen Tools category in the `kitchen_tools` table
        DB::table('kitchen_tools')->insert([
            ['name' => 'Chef Knife', 'Description' => 'Sharp stainless steel knife', 'image' => 'knife_image_url_here'],
            ['name' => 'Cutting Board', 'Description' => 'Durable bamboo board', 'image' => 'cutting_board_image_url_here'],
            ['name' => 'Spatula Set', 'Description' => 'Heat-resistant spatulas', 'image' => 'spatula_set_image_url_here'],
        ]);
    }
}
