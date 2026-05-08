@php
    $category = $category ?? 'electronics';
    $fallbackClass = $fallbackClass ?? 'slate';

    $rawImage = $product->image ?? $image ?? null;

    $imageUrl = null;

    if (!empty($rawImage)) {
        $imageUrl = str_starts_with($rawImage, 'http')
            ? $rawImage
            : asset('storage/' . $rawImage);
    }

    $price = $price ?? ($product->price ?? ($category === 'decor' ? 49 : ($category === 'kitchen' ? 79 : 0)));

    $categoryLabel = $category === 'kitchen'
        ? 'Kitchen'
        : ucfirst($category);
@endphp

<article class="glass-card product h-100">
    <div
        class="product-media {{ $fallbackClass }}"
        @if($imageUrl)
            style="background-image:linear-gradient(135deg,rgba(15,23,42,.55),rgba(15,23,42,.12)),url('{{ $imageUrl }}');background-size:cover;background-position:center;"
        @endif
    >
        @unless($imageUrl)
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="4" y="5" width="16" height="12" rx="2"/>
                <path d="M7 15l3-3 2 2 3-4 2 5"/>
            </svg>
        @endunless

        <span>{{ $categoryLabel }}</span>
    </div>

    <h3>{{ $product->name }}</h3>
    <p>{{ $product->Description }}</p>

    <div class="product-row">
        <span class="price">SAR {{ number_format((float) $price, 0) }}</span>
        <a class="pill" href="{{ route('proddet', ['category' => $category, 'id' => $product->id]) }}">
            Details
        </a>
    </div>
</article>