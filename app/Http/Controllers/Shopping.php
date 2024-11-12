<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopping extends Controller
{
    public function index()
    {
        return view('shopping.landingpage');
    }

    public function electric()
    {
        $products = DB::table('products')->get();
        return view('shopping.electric', ['products' => $products]);
    }

    public function zena()
    {
        $products = DB::table('zena')->get();
        return view('shopping.zena', ['products' => $products]);
    }

    public function kitchenTools()
    {
        $products = DB::table('kitchen_tools')->get();
        return view('shopping.kitchenTools', ['products' => $products]);
    }

    public function productdetails($id)
    {
        $productDetails = DB::table('products')
            ->join('products__details', 'products.id', '=', 'products__details.id_products')
            ->where('products.id', '=', $id)
            ->select('products.name', 'products.Description', 'products__details.price', 'products__details.qty', 'products__details.image', 'products__details.color')
            ->first();

        return view('shopping.product_details', ['prod' => $productDetails]);
    }
}
