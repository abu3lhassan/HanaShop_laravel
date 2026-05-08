<?php

namespace App\Http\Controllers;

use App\Models\Costumers;
use App\Models\Products;
use App\Models\Products_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Products::count();
        $detailsCount = Products_Details::count();
        $customersCount = Costumers::count();
        $invoicesCount = DB::table('invioces')->count();

        return view('dashboard.index', compact('productsCount', 'detailsCount', 'customersCount', 'invoicesCount'));
    }

    public function products()
    {
        $prod = Products::latest()->get();
        return view('dashboard.products', compact('prod'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'productname' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:180'],
        ]);

        Products::create([
            'name' => $validated['productname'],
            'Description' => $validated['description'],
        ]);

        return redirect()->route('products')->with('success', 'Product added successfully.');
    }

    public function editProduct($id)
    {
        $products = Products::findOrFail($id);
        return view('dashboard.edit', compact('products'));
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:180'],
        ]);

        Products::where('id', $id)->update([
            'name' => $validated['name'],
            'Description' => $validated['description'],
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        Products_Details::where('id_products', $id)->delete();
        Products::findOrFail($id)->delete();
        return redirect()->route('products')->with('success', 'Product deleted successfully.');
    }

    public function productDetails()
    {
        $prod = Products::orderBy('name')->get();
        $producdetails = DB::table('products')
            ->join('products__details', 'products.id', '=', 'products__details.id_products')
            ->select('products__details.*', 'products.name')
            ->orderByDesc('products__details.id')
            ->get();

        return view('dashboard.product_details', compact('prod', 'producdetails'));
    }

    public function storeProductDetails(Request $request)
    {
        $validated = $request->validate([
            'product_no' => ['required', 'exists:products,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'qty' => ['required', 'integer', 'min:0'],
            'color' => ['required', 'string', 'max:40'],
            'img' => ['nullable', 'string', 'max:500'],
        ]);

        Products_Details::create([
            'id_products' => $validated['product_no'],
            'price' => $validated['price'],
            'qty' => $validated['qty'],
            'color' => $validated['color'],
            'image' => $validated['img'] ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
        ]);

        return redirect()->route('product-details.index')->with('success', 'Product details saved successfully.');
    }

    public function customers()
    {
        $customers = Costumers::latest()->get();
        return view('dashboard.customers', compact('customers'));
    }

    public function invoices()
    {
        $invoices = DB::table('invioces')->latest()->get();
        return view('dashboard.invoices', compact('invoices'));
    }
}
