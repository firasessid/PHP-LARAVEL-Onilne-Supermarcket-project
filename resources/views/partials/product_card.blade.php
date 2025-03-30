<div class="product-cart-wrap">
    <div class="product-img-action-wrap">
        <div class="product-img product-img-zoom">
            <a href="{{ route('products_view', ['id' => $product->id]) }}">
                @foreach ($product->images->take(2) as $index => $image)
                    @if ($index === 0)
                        <img class="default-img" src="{{ asset('storage/images/' . $image->image) }}" alt="Default Image" />
                    @elseif ($index === 1)
                        <img class="hover-img" src="{{ asset('storage/images/' . $image->image) }}" alt="Hover Image" />
                    @endif
                @endforeach
            </a>
        </div>
        <div class="product-action-1">
            <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i class="fi-rs-eye"></i></a>
            <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
            <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
        </div>
        @if ($product->quantity == 0)
            <div class="product-badges product-badges-position product-badges-mrg">
                <span class="hot">Out of stock</span>
            </div>
        @endif
    </div>
    <div class="product-content-wrap">
        <div class="product-category">
            <a href="{{ route('products_view', ['id' => $product->id]) }}">{{ $product->short_description }}</a>
        </div>
        <h2><a href="{{ route('products_view', ['id' => $product->id]) }}">{{ $product->name }}</a></h2>
        <div class="product-price mt-10">
            @if ($activeDeal && $activeDeal->contains('product.id', $product->id))
                @php
                    $deal = $activeDeal->firstWhere('product.id', $product->id);
                @endphp
                <span>${{ $product->sale_price - $deal->discount_percentage }}</span>
                <span class="old-price">${{ $product->sale_price }}</span>
            @else
                <span>${{ $product->sale_price }}</span>
            @endif
        </div>
        <a class="btn w-100 hover-up" href="{{ route('add_to_cart', $product->id) }}">
            <i class="fi-rs-shopping-cart mr-5"></i>Add
        </a>
    </div>
</div>
