<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopping extends Controller
{
    private array $decorPrices = [
        1 => 49,
        2 => 35,
        3 => 29,
    ];

    private array $kitchenPrices = [
        1 => 79,
        2 => 25,
        3 => 39,
    ];

    public function index()
    {
        $electronics = $this->electronicsQuery()->limit(3)->get();
        $decor = $this->withCategoryPrices(DB::table('zena')->limit(3)->get(), $this->decorPrices);
        $kitchenTools = $this->withCategoryPrices(DB::table('kitchen_tools')->limit(3)->get(), $this->kitchenPrices);

        return view('shopping.landingpage', compact('electronics', 'decor', 'kitchenTools'));
    }

    public function electric()
    {
        $products = $this->electronicsQuery()->get();
        return view('shopping.electric', compact('products'));
    }

    public function zena()
    {
        $products = $this->withCategoryPrices(DB::table('zena')->get(), $this->decorPrices);
        return view('shopping.zena', compact('products'));
    }

    public function kitchenTools()
    {
        $products = $this->withCategoryPrices(DB::table('kitchen_tools')->get(), $this->kitchenPrices);
        return view('shopping.kitchenTools', compact('products'));
    }

    public function productdetails($category, $id)
    {
        $allowed = [
            'electronics' => 'products',
            'decor' => 'zena',
            'kitchen' => 'kitchen_tools',
        ];

        abort_unless(isset($allowed[$category]), 404);

        if ($category === 'electronics') {
            $product = $this->electronicsQuery()->where('products.id', $id)->first();
        } else {
            $product = DB::table($allowed[$category])->where('id', $id)->first();
            if ($product) {
                $prices = $category === 'decor' ? $this->decorPrices : $this->kitchenPrices;
                $product->price = $prices[$product->id] ?? ($category === 'decor' ? 49 : 79);
                $product->qty = 12;
                $product->color = 'Premium';
                $product->image = $product->image ?: ($category === 'decor'
                    ? 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=900&q=80'
                    : 'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=900&q=80');
            }
        }

        abort_unless($product, 404);

        return view('shopping.product_details', ['prod' => $product, 'category' => $category]);
    }

    public function addToCart(Request $request)
    {
        return redirect()->back()->with('success', 'Product added to cart.');
    }

    private function electronicsQuery()
    {
        return DB::table('products')
            ->leftJoin('products__details', 'products.id', '=', 'products__details.id_products')
            ->select(
                'products.id',
                'products.name',
                'products.Description',
                DB::raw('COALESCE(products__details.price, 0) as price'),
                DB::raw('COALESCE(products__details.qty, 0) as qty'),
                DB::raw("COALESCE(products__details.color, 'Premium') as color"),
                DB::raw("COALESCE(products__details.image, 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=900&q=80') as image")
            );
    }

    private function withCategoryPrices($products, array $prices)
    {
        return $products->map(function ($product) use ($prices) {
            $product->price = $prices[$product->id] ?? 0;
            return $product;
        });
    }
}
