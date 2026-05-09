<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Costumers;
use App\Models\Products;
use App\Models\Products_Details;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Products::count();
        $categoriesCount = Category::count();
        $detailsCount = Products_Details::count();
        $customersCount = Costumers::count();
        $invoicesCount = DB::table('invioces')->count();

        $totalRevenue = (float) DB::table('invioces')->sum('total');
        $totalSoldQuantity = (int) DB::table('invioces')->sum('qty');
        $latestInvoiceTotal = (float) (DB::table('invioces')->latest()->value('total') ?? 0);

        $revenueToday = (float) DB::table('invioces')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');

        $revenueThisMonth = (float) DB::table('invioces')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $lowStockProducts = DB::table('products')
            ->leftJoin('products__details', 'products.id', '=', 'products__details.id_products')
            ->leftJoin('categories', 'products.category', '=', 'categories.slug')
            ->select(
                'products.id',
                'products.name',
                'products.category',
                'categories.name as category_name',
                'products__details.qty',
                'products__details.price'
            )
            ->whereIn('products__details.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('products__details')
                    ->groupBy('id_products');
            })
            ->where('products__details.qty', '<=', 5)
            ->orderBy('products__details.qty')
            ->limit(5)
            ->get();

        $latestInvoices = DB::table('invioces')
            ->leftJoin('costumers', 'invioces.costumer_id', '=', 'costumers.id')
            ->leftJoin('products', 'invioces.products_id', '=', 'products.id')
            ->select(
                'invioces.id',
                'invioces.qty',
                'invioces.total',
                'invioces.created_at',
                'costumers.name as customer_name',
                'products.name as product_name'
            )
            ->orderByDesc('invioces.id')
            ->limit(5)
            ->get();

        $latestCustomers = DB::table('costumers')
            ->select('id', 'name', 'email', 'phone', 'created_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $topSellingProducts = DB::table('invioces')
            ->leftJoin('products', 'invioces.products_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(invioces.qty) as sold_qty'),
                DB::raw('SUM(invioces.total) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('sold_qty')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'productsCount',
            'categoriesCount',
            'detailsCount',
            'customersCount',
            'invoicesCount',
            'totalRevenue',
            'totalSoldQuantity',
            'latestInvoiceTotal',
            'revenueToday',
            'revenueThisMonth',
            'lowStockProducts',
            'latestInvoices',
            'latestCustomers',
            'topSellingProducts'
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

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.products', compact('prod', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'productname' => ['required', 'string', 'max:80'],
            'category' => ['required', 'string', 'exists:categories,slug'],
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
            'category' => ['required', 'string', 'exists:categories,slug'],
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

    public function categories()
    {
        $categories = Category::orderByDesc('id')->get();

        return view('dashboard.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:180'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $slug = $this->uniqueCategorySlug($validated['name']);
        $icon = $this->cleanCategoryIcon($validated['icon'] ?? null);

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'icon' => $icon,
            'is_active' => true,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:180'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $oldSlug = $category->slug;
        $newSlug = $this->uniqueCategorySlug($validated['name'], $category->id);
        $icon = $this->cleanCategoryIcon($validated['icon'] ?? null);

        $category->update([
            'name' => $validated['name'],
            'slug' => $newSlug,
            'description' => $validated['description'] ?? null,
            'icon' => $icon,
        ]);

        if ($oldSlug !== $newSlug) {
            Products::where('category', $oldSlug)->update([
                'category' => $newSlug,
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function toggleCategory($id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'is_active' => ! $category->is_active,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category status updated successfully.');
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

    public function showInvoice($id)
    {
        $invoice = DB::table('invioces')
            ->leftJoin('costumers', 'invioces.costumer_id', '=', 'costumers.id')
            ->leftJoin('products', 'invioces.products_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category', '=', 'categories.slug')
            ->select(
                'invioces.*',
                'costumers.name as customer_name',
                'costumers.email as customer_email',
                'costumers.phone as customer_phone',
                'costumers.address as customer_address',
                'products.name as product_name',
                'products.Description as product_description',
                'products.category as product_category',
                'categories.name as category_name'
            )
            ->where('invioces.id', $id)
            ->first();

        abort_unless($invoice, 404);

        return view('dashboard.invoice_show', compact('invoice'));
    }

    public function settings()
    {
        $settings = StoreSetting::current();

        return view('dashboard.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = StoreSetting::current();

        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:80'],
            'store_description' => ['nullable', 'string', 'max:180'],
            'business_name' => ['nullable', 'string', 'max:120'],
            'vat_number' => ['nullable', 'string', 'max:60'],
            'cr_number' => ['nullable', 'string', 'max:60'],
            'address' => ['nullable', 'string', 'max:180'],
            'city' => ['nullable', 'string', 'max:80'],
            'country' => ['nullable', 'string', 'max:80'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'vat_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'invoice_note' => ['nullable', 'string', 'max:500'],
            'theme_mode' => ['required', 'string', 'in:light,dark'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,ico', 'max:1024'],
        ]);

        $settingsData = [
            'store_name' => $validated['store_name'],
            'store_description' => $validated['store_description'] ?? null,
            'business_name' => $validated['business_name'] ?? null,
            'vat_number' => $validated['vat_number'] ?? null,
            'cr_number' => $validated['cr_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'vat_rate' => $validated['vat_rate'],
            'invoice_note' => $validated['invoice_note'] ?? null,
            'theme_mode' => $validated['theme_mode'],
        ];

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $settingsData['logo_path'] = $request->file('logo')->store('store', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }

            $settingsData['favicon_path'] = $request->file('favicon')->store('store', 'public');
        }

        $settings->update($settingsData);

        return redirect()->route('settings.index')->with('success', 'Store settings updated successfully.');
    }

    public function adminUsers()
    {
        $users = User::orderByDesc('id')->get();

        return view('dashboard.admin_users', compact('users'));
    }

    public function storeAdminUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('admin-users.index')->with('success', 'Admin user created successfully.');
    }

    public function updateAdminUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        $user->update($userData);

        return redirect()->route('admin-users.index')->with('success', 'Admin user updated successfully.');
    }

    public function deleteAdminUser($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->route('admin-users.index')->withErrors([
                'user' => 'You cannot delete your own admin account while signed in.',
            ]);
        }

        if (User::count() <= 1) {
            return redirect()->route('admin-users.index')->withErrors([
                'user' => 'You cannot delete the last admin user.',
            ]);
        }

        $user->delete();

        return redirect()->route('admin-users.index')->with('success', 'Admin user deleted successfully.');
    }

    private function uniqueCategorySlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'category';

        $slug = $baseSlug;
        $counter = 2;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function cleanCategoryIcon(?string $icon): string
    {
        $icon = trim((string) $icon);

        if ($icon === '') {
            return 'bi-tag';
        }

        if (! str_starts_with($icon, 'bi-')) {
            return 'bi-tag';
        }

        return $icon;
    }
}