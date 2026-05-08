<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopping extends Controller
{
    public function index()
    {
        $electronics = $this->productsByCategory('electronics')->limit(3)->get();
        $decor = $this->productsByCategory('decor')->limit(3)->get();
        $kitchenTools = $this->productsByCategory('kitchen')->limit(3)->get();

        return view('shopping.landingpage', compact('electronics', 'decor', 'kitchenTools'));
    }

    public function electric()
    {
        $products = $this->productsByCategory('electronics')->get();
        return view('shopping.electric', compact('products'));
    }

    public function zena()
    {
        $products = $this->productsByCategory('decor')->get();
        return view('shopping.zena', compact('products'));
    }

    public function kitchenTools()
    {
        $products = $this->productsByCategory('kitchen')->get();
        return view('shopping.kitchenTools', compact('products'));
    }

    public function productdetails($category, $id)
    {
        $allowedCategories = [
            'electronics',
            'decor',
            'kitchen',
        ];

        abort_unless(in_array($category, $allowedCategories, true), 404);

        $product = $this->productsByCategory($category)
            ->where('products.id', $id)
            ->first();

        abort_unless($product, 404);

        return view('shopping.product_details', [
            'prod' => $product,
            'category' => $category,
        ]);
    }

    public function addToCart(Request $request)
    {
        return redirect()->back()->with('success', 'Product added to cart.');
    }

    private function productsByCategory(string $category)
    {
        $latestDetails = DB::table('products__details')
            ->select('id_products', DB::raw('MAX(id) as latest_detail_id'))
            ->groupBy('id_products');

        return DB::table('products')
            ->leftJoinSub($latestDetails, 'latest_details', function ($join) {
                $join->on('products.id', '=', 'latest_details.id_products');
            })
            ->leftJoin('products__details', 'products__details.id', '=', 'latest_details.latest_detail_id')
            ->where('products.category', $category)
            ->select(
                'products.id',
                'products.name',
                'products.Description',
                'products.category',
                DB::raw('COALESCE(products__details.price, 0) as price'),
                DB::raw('COALESCE(products__details.qty, 0) as qty'),
                DB::raw("COALESCE(products__details.color, 'Premium') as color"),
                DB::raw("COALESCE(products__details.image, 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=900&q=80') as image")
            )
            ->orderByDesc('products.id');
    }
}