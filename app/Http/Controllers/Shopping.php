<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopping extends Controller
{
    public function index()
    {
        $categories = $this->activeCategories();

        $featuredProducts = DB::table('products')
            ->leftJoinSub($this->latestDetailsQuery(), 'latest_details', function ($join) {
                $join->on('products.id', '=', 'latest_details.id_products');
            })
            ->leftJoin('products__details', 'products__details.id', '=', 'latest_details.latest_detail_id')
            ->join('categories', 'products.category', '=', 'categories.slug')
            ->where('categories.is_active', true)
            ->select(
                'products.id',
                'products.name',
                'products.Description',
                'products.category',
                'categories.name as category_name',
                DB::raw('COALESCE(products__details.price, 0) as price'),
                DB::raw('COALESCE(products__details.qty, 0) as qty'),
                DB::raw("COALESCE(products__details.color, 'Premium') as color"),
                DB::raw("COALESCE(products__details.image, 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=900&q=80') as image")
            )
            ->orderByDesc('products.id')
            ->limit(9)
            ->get();

        return view('shopping.landingpage', compact('categories', 'featuredProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $this->productsByCategory($category->slug)->get();

        return view('shopping.category', [
            'categoryRecord' => $category,
            'category' => $category->slug,
            'products' => $products,
        ]);
    }

    public function electric()
    {
        return redirect()->route('category.show', ['slug' => 'electronics']);
    }

    public function zena()
    {
        return redirect()->route('category.show', ['slug' => 'decor']);
    }

    public function kitchenTools()
    {
        return redirect()->route('category.show', ['slug' => 'kitchen']);
    }

    public function productdetails($category, $id)
    {
        $categoryRecord = Category::where('slug', $category)
            ->where('is_active', true)
            ->firstOrFail();

        $product = $this->productsByCategory($categoryRecord->slug)
            ->where('products.id', $id)
            ->first();

        abort_unless($product, 404);

        return view('shopping.product_details', [
            'prod' => $product,
            'category' => $categoryRecord->slug,
            'categoryRecord' => $categoryRecord,
        ]);
    }

    public function cart()
    {
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return ((float) $item['price']) * ((int) $item['quantity']);
        });

        return view('shopping.cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
        ]);
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'category' => ['required', 'string', 'exists:categories,slug'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $category = Category::where('slug', $validated['category'])
            ->where('is_active', true)
            ->firstOrFail();

        $product = $this->productsByCategory($category->slug)
            ->where('products.id', $validated['product_id'])
            ->first();

        abort_unless($product, 404);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cart = session()->get('cart', []);

        $cartKey = $category->slug . '_' . $product->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'category' => $category->slug,
                'category_name' => $category->name,
                'name' => $product->name,
                'description' => $product->Description,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'color' => $product->color,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Product added to cart.');
    }

    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'cart_key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$validated['cart_key']])) {
            $cart[$validated['cart_key']]['quantity'] = (int) $validated['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Cart updated successfully.');
    }

    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'cart_key' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$validated['cart_key']])) {
            unset($cart[$validated['cart_key']]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Product removed from cart.');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->route('cart')->with('success', 'Cart cleared successfully.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart')->with('success', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:30'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:30'],
        ]);

        DB::transaction(function () use ($cart, $validated) {
            $customerId = DB::table('costumers')->insertGetId([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cart as $item) {
                $price = (float) $item['price'];
                $quantity = (int) $item['quantity'];

                DB::table('invioces')->insert([
                    'costumer_id' => $customerId,
                    'products_id' => (int) $item['id'],
                    'qty' => $quantity,
                    'price' => $price,
                    'total' => $price * $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('index')->with('success', 'Order completed successfully. Invoice records were created.');
    }

    private function productsByCategory(string $category)
    {
        return DB::table('products')
            ->leftJoinSub($this->latestDetailsQuery(), 'latest_details', function ($join) {
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

    private function latestDetailsQuery()
    {
        return DB::table('products__details')
            ->select('id_products', DB::raw('MAX(id) as latest_detail_id'))
            ->groupBy('id_products');
    }

    private function activeCategories()
    {
        return Category::where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}