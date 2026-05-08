@extends('layouts.appuserui')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Electronics</h2>
            <p>Browse HanaShop electronics products in balanced premium cards.</p>
        </div>
        <div class="grid-3">
            @forelse($products as $product)
                @include('shopping.partials.product-card', ['product' => $product, 'category' => 'electronics', 'fallbackClass' => 'slate'])
            @empty
                <div class="glass-card feature"><h3>No products yet</h3><p>Add products from the dashboard.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
