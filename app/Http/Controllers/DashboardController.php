<?php

namespace App\Http\Controllers;

use App\Models\Costumers;
use App\Models\Products;
use App\Models\Products_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private array $allowedCategories = [
        'electronics',
        'decor',
        'kitchen',
    ];

    public function index()
    {
        $productsCount = Products::count();
        $detailsCount = Products_Details::count();
        $customersCount = Costumers::count();
        $invoicesCount = DB::table('invioces')->count();

        $totalRevenue = (float) DB::table('invioces')->sum('total');
        $totalSoldQuantity = (int) DB::table('invioces')->sum('qty');
        $latestInvoiceTotal = (float) (DB::table('invioces')->latest()->value('total') ?? 0);

        return view('dashboard.index', compact(
            'productsCount',
            'detailsCount',
            'customersCount',
            'invoicesCount',
            'totalRevenue',
            'totalSoldQuantity',
            'latestInvoiceTotal'
        ));
    }

    public function products()
    {
        $latestDetails = DB::table('products__details')
            ->select('id_products', DB::raw('MAX(id) as latest_detail_id'))
            ->groupBy('id_products');

        $prod = DB::table('products')
            ->leftJoinSub($latestDetails, 'latest_details', function ($join) {
                $join->on('products.id', '=', 'latest_details.id_products');
            })
            ->leftJoin('products__details', 'products__details.id', '=', 'latest_details.latest_detail_id')
            ->select(
                'products.id',
                'products.name',
                'products.Description',
                'products.category',
                'products.created_at',
                'products.updated_at',
                'products__details.id as detail_id',
                'products__details.price',
                'products__details.qty',
                'products__details.color',
                'products__details.image'
            )
            ->orderByDesc('products.id')
            ->get();

        return view('dashboard.products', compact('prod'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'productname' => ['required', 'string', 'max:80'],
            'category' => ['required', 'string', 'in:' . implode(',', $this->allowedCategories)],
            'description' => ['required', 'string', 'max:180'],
        ]);

        Products::create([
            'name' => $validated['productname'],
            'category' => $validated['category'],
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
            'category' => ['required', 'string', 'in:' . implode(',', $this->allowedCategories)],
            'description' => ['required', 'string', 'max:180'],
        ]);

        Products::where('id', $id)->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
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
            ->select('products__details.*', 'products.name', 'products.category')
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
            'img' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $product = Products::findOrFail($validated['product_no']);

        $latestDetail = Products_Details::where('id_products', $product->id)
            ->orderByDesc('id')
            ->first();

        $imagePath = $latestDetail->image
            ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80';

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('products', 'public');
        }

        if ($latestDetail) {
            $latestDetail->update([
                'price' => $validated['price'],
                'qty' => $validated['qty'],
                'color' => $validated['color'],
                'image' => $imagePath,
            ]);
        } else {
            Products_Details::create([
                'id_products' => $product->id,
                'price' => $validated['price'],
                'qty' => $validated['qty'],
                'color' => $validated['color'],
                'image' => $imagePath,
            ]);
        }

        return redirect()->back()->with('success', 'Product details saved successfully.');
    }

    public function customers()
    {
        $customers = Costumers::latest()->get();
        return view('dashboard.customers', compact('customers'));
    }

    public function invoices()
    {
        $invoices = DB::table('invioces')
            ->leftJoin('costumers', 'invioces.costumer_id', '=', 'costumers.id')
            ->leftJoin('products', 'invioces.products_id', '=', 'products.id')
            ->select(
                'invioces.*',
                'costumers.name as customer_name',
                'costumers.email as customer_email',
                'costumers.phone as customer_phone',
                'products.name as product_name',
                'products.category as product_category'
            )
            ->orderByDesc('invioces.id')
            ->get();

        return view('dashboard.invoices', compact('invoices'));
    }
}