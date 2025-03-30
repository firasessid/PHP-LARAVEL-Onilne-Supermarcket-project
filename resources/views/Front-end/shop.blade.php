@section('content')
@extends('layouts.main')
@section('main-container')


<head>
    <meta charset="utf-8" />
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css?v=5.6') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/slider-range.css') }}">


</head>






<!-- Quick view -->
<!-- Quick view -->
@foreach ($products as $p)
    <div class="modal fade custom-modal" id="quickViewModal_{{ $p->id }}" tabindex="-1"
        aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    @foreach ($p->images as $image)

                                        <figure class="border-radius-10">
                                            <img src="{{ asset('storage/images/' . $image->image) }}" alt="product image" />
                                        </figure>
                                    @endforeach


                                </div>
                                <!-- THUMBNAILS -->
                                <div class="slider-nav-thumbnails">
                                    @foreach ($p->images as $image)

                                        <div><img src="{{ asset('storage/images/' . $image->image) }}" alt="product image" />
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                            <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                @if ($p->quantity == 0)
                                    <span class="stock-status out-stock">Out of stock </span>
                                @endif

                                @if ($p->quantity > 10)
                                    <span class="stock-status in-stock">In stock </span>

                                @endif
                                @if ($p->quantity >= 1 && $p->quantity <= 10) <span class="stock-status out-stock">Limited
                                    </span>

                                @endif


                                <h3 class="title-detail"><a href="shop-product-right.html"
                                        class="text-heading">{{$p->description}}</a></h3>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        @foreach ($activeDeal as $product)
                                            @if ($p->id == $product->product->id)
                                                <span
                                                    class="current-price text-brand">€{{ $p->sale_price - $product->discount_percentage }}</span>
                                                <span>
                                                    <span class="save-price font-md color3 ml-15">
                                                        {{ number_format(($product->discount_percentage / $p->sale_price) * 100) }}%
                                                        Off
                                                    </span>
                                                    <span class="old-price font-md ml-15">€{{ $p->sale_price }}</span>
                                                </span>
                                            @endif
                                        @endforeach

                                        @if (!in_array($p->id, $activeDeal->pluck('product.id')->all()))
                                            <span class="current-price text-brand">€{{ $p->sale_price }}</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <span class="qty-val">1</span>
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>





                                    <div class="product-extra-link2">
                                        <form action="{{ route('add_to_cart', $p->id) }}">

                                            <button type="submit" class="button button-add-to-cart add"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add to cart</button>
                                        </form>

                                    </div>

                                </div>
                                <div class="font-xs">
                                    <ul>
                                        <li class="mb-5">Ray : <span class="text-brand">{{ $p->rayName }}</span></li>
                                        <li class="mb-5">Category : <span class="text-brand">{{ $p->categoryName }}</span>
                                        </li>
                                        <li class="mb-5">Sub category : <span
                                                class="text-brand">{{ $p->subcategoryName }}</span></li>
                                        <li class="mb-5">Brand : <span class="text-brand">
                                                @if ($p->brandName == 'No brand given')
                                                    <span class="badge rounded-pill alert-warning">{{ $p->brandName }}</span>
                                                @else
                                                    {{ $p->brandName }}
                                                @endif
                                            </span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!--End header-->
<main class="main">

    <div class="page-header mt-30 mb-50">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Rays List</h1>
                        <div class="breadcrumb">
                            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Shop <span></span> Rays
                        </div>
                    </div>
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        <ul class="tags-list">
                            @foreach($rays as $p)
                                <li class="hover-up mr-0" style="margin-bottom: 10px;"> <!-- Ajouter un espacement ici -->
                                    <a href="{{ route('shoplist', [$p->slug]) }}">{{ $p->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <h6>
                        <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Shop</a>
                        @if (isset($ray))
                            <span></span> <a href="{{ route('shoplist', [$ray->slug]) }}">{{ $ray->name }}</a>
                        @endif
                        @if (isset($category))
                            <span></span> <a
                                href="{{ route('shoplist', [$ray->slug ?? '', $category->slug]) }}">{{ $category->name }}</a>
                        @endif
                        @if (isset($subCategory))
                            <span></span> <a
                                href="{{ route('shoplist', [$ray->slug ?? '', $category->slug ?? '', $subCategory->slug]) }}">{{ $subCategory->name }}</a>
                        @endif
                    </h6>
                </div>

            </div>
        </div>

        <div class="row flex-row-reverse">
            <div class="col-lg-4-5">
                <div class="shop-product-fillter">

                    <div class="burger-icon burger-icon-white">

                        <a class="shop-filter-toogle" href="#">
                            <span class="fi-rs-filter mr-5"></span>
                            Filters
                            <i class="fi-rs-angle-small-down angle-down"></i>
                            <i class="fi-rs-angle-small-up angle-up"></i>
                        </a>
                    </div>



                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        // Remove all client-side sorting code and replace with:
                        $('.sort-by-dropdown a').on('click', function (e) {
                            e.preventDefault();
                            window.location.href = $(this).attr('href');
                        });
                    </script>




                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span id="per-page-selected">{{ request()->input('per_page', 50) }} <i
                                            class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a href="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}"
                                            data-per-page="50">50</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}"
                                            data-per-page="100">100</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['per_page' => 150]) }}"
                                            data-per-page="150">150</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['per_page' => 200]) }}"
                                            data-per-page="200">200</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['per_page' => $products->total()]) }}"
                                            data-per-page="all">All</a></li>
                                </ul>
                            </div>
                        </div>

                        <script>
                            document.querySelectorAll('.sort-by-dropdown ul li a').forEach(link => {
                                link.addEventListener('click', function (e) {
                                    e.preventDefault(); // Empêcher le comportement par défaut du lien
                                    const url = this.getAttribute('href'); // Récupérer l'URL depuis l'attribut href
                                    window.location.href = url; // Rediriger vers l'URL
                                });
                            });
                        </script>

                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span>{{ ucwords(request()->input('sort', 'Featured')) }} <i
                                            class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="{{ request('sort') === 'featured' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'featured', 'page' => null]) }}">Featured</a>
                                    </li>
                                    <li><a class="{{ request('sort') === 'low-to-high' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'low-to-high', 'page' => null]) }}">Price:
                                            Low to High</a></li>
                                    <li><a class="{{ request('sort') === 'high-to-low' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'high-to-low', 'page' => null]) }}">Price:
                                            High to Low</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>



                <script>






                    document.addEventListener("DOMContentLoaded", function () {
                        var priceSlider = document.getElementById("price-slider");
                        var priceRangeValue1 = document.getElementById("price-range-value1");
                        var priceRangeValue2 = document.getElementById("price-range-value2");
                        var productListContainer = document.getElementById('product-list-container'); // Get the product list container

                        noUiSlider.create(priceSlider, {
                            start: [0, 1000], // Initial values
                            connect: true,
                            step: 1,
                            range: {
                                'min': 0, // Minimum price
                                'max': 1000 // Maximum price
                            }
                        });

                        priceSlider.noUiSlider.on('update', function (values, handle) {
                            if (handle === 0) {
                                priceRangeValue1.innerHTML = Math.round(values[0]);
                            }
                            if (handle === 1) {
                                priceRangeValue2.innerHTML = Math.round(values[1]);
                            }
                        });

                        priceSlider.noUiSlider.on('change', function (values, handle) {
                            var minPrice = Math.round(values[0]);
                            var maxPrice = Math.round(values[1]);

                            // Send an Ajax request to filter products
                            $.ajax({
                                url: '{{ route("filter-products") }}',
                                type: 'POST',
                                data: {
                                    minPrice: minPrice,
                                    maxPrice: maxPrice
                                },
                                success: function (response) {
                                    try {
                                        console.log('Ajax request successful');
                                        console.log(response); // Log the entire response

                                        // Check if the response is an array and has a length
                                        if (Array.isArray(response) && response.length > 0) {
                                            updateProductList(response); // Update the product list
                                        } else {
                                            // Handle the case where no products are found
                                            productListContainer.innerHTML = 'No products found.';
                                        }
                                    } catch (error) {
                                        console.error('Error in success callback:', error);
                                    }
                                },
                                error: function (error) {
                                    console.log('Ajax request failed');
                                    console.log(error);
                                }
                            });
                        });
                    });
                    // Your JavaScript code for applying the filter
                    function applyFilter() {
                        var minPrice = getMinPrice(); // Implement this function to get the min price
                        var maxPrice = getMaxPrice(); // Implement this function to get the max price

                        if (minPrice !== null && maxPrice !== null && countProducts() > 0) {
                            // Perform the filter logic here
                            // ...
                        } else {
                            // Display a message or prevent filtering when there are no products
                            alert('No products to filter.');
                        }
                    }





                    function updateProductList(products) {
                        var productListContainer = document.getElementById('product-list-container');

                        // Clear the current product list content
                        productListContainer.innerHTML = '';

                        // Assuming that your application runs on http://127.0.0.1:8000
                        var baseUrl = window.location.origin;

                        // Loop through the filtered products and append them to the container

                        products.forEach(function (product) {
                            var productURL = `${baseUrl}/add-to-cart/${product.id}`;
                            var viewURL = `${baseUrl}/products/view/${product.id}`;

                            var productHTML = `
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 product-container">
                <div class="product-cart-wrap mb-30">
                    <div class="product-img-action-wrap">
                        <div class="product-img product-img-zoom">
                            <a href="shop-product-right.html">

                                <img class="default-img" src="/storage/images/${product.image}" alt="" />
                                <img class="default-img" src="/storage/images/${product.image}" alt="" />

                                </a>
                        </div>

                        <div class="product-action-1">
                            <a aria-label="Add To Wishlist" class="action-btn" href=""><i class="fi-rs-heart"></i></a>
                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal_${product.id}"><i class="fi-rs-eye"></i></a>
                        </div>

                        ${product.quantity == 0 ? '<div class="product-badges product-badges-position product-badges-mrg"><span class="hot">Out of stock</span></div>' :
                                    (product.quantity > 10 ? '<div class="product-badges product-badges-position product-badges-mrg"><span class="new">In stock</span></div>' :
                                        '<div class="product-badges product-badges-position product-badges-mrg"><span class="best">Limited</span></div>')}

                    </div>

                    <div class="product-content-wrap">
                        <div class="product-category">
                            <a href="shop-grid-right.html">${product.description}</a>
                        </div>
                        <h2><a href="${viewURL}">${product.name}</a></h2>
                        <div class="product-rate-cover">
                            <div class="product-rate d-inline-block">
                                <div class="product-rating" style="width: 90%"></div>
                            </div>
                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                        </div>
                        <div>
                            <span class="font-small text-muted">${product.quantity}<a href="vendor-details-1.html">Items left </a></span>
                        </div>
                        <div class="product-card-bottom">
                            <div class="product-price">
                                <span>${product.sale_price} €</span>
                                <span class="old-price">${product.sale_price} €</span>
                            </div>
                            <div class="add-cart">
                                <a class="add" href="${productURL}"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

                            productListContainer.innerHTML += productHTML;
                        });
                    }
                </script>



                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


                @if(count($products) > 0)
                    <div class="row product-grid" id="product-list-container">

                        @foreach ($products as $p)

                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 product-container"
                                data-original-order="{{ $loop->index }}" data-brand="{{ $p->brand_id }}">

                                <div class="product-cart-wrap mb-30 product-featured">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                @foreach ($p->images->take(2) as $index => $image)
                                                    @if ($index === 0)
                                                        <img class="default-img" src="{{ asset('storage/images/' . $image->image) }}"
                                                            alt="Default Image" />
                                                    @elseif ($index === 1)
                                                        <img class="hover-img" src="{{ asset('storage/images/' . $image->image) }}"
                                                            alt="Hover Image" />
                                                    @endif
                                                @endforeach
                                            </a>
                                        </div>

                                        <div class="product-action-1">


                                            <a aria-label="Add To Wishlist" class="action-btn"
                                                href="{{ route('add.wishlist', $p->id) }}"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                                data-bs-target="#quickViewModal_{{ $p->id }}"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        @if ($p->quantity == 0)
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Out of stock </span>
                                            </div>
                                        @endif
                                        @foreach ($activeDeal as $product)
                                            @if ($p->quantity > 10 && $p->id != $product->product->id)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="new">In stock</span>
                                                </div>
                                            @endif
                                        @endforeach

                                        @foreach ($activeDeal as $product)
                                            @if ($p->id == $product->product->id)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span
                                                        class="sale">{{ number_format(($product->discount_percentage / $p->sale_price) * 100) }}%</span>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if ($p->quantity >= 1 && $p->quantity <= 10)
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">Limited</span>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">{{$p->description}}</a>
                                        </div>
                                        <h2><a href="{{ route('products_view', ['id' => $p->id]) }}">{{ $p->name }}</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">{{$p->quantity}}<a
                                                    href="vendor-details-1.html">Items left </a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                @foreach ($activeDeal as $product)
                                                    @if ($p->id == $product->product->id)
                                                        <span
                                                            class="current-price text-brand">€{{ number_format($p->sale_price - $product->discount_percentage, 2) }}</span>
                                                        <span class="old-price">€{{ number_format($p->sale_price, 2) }}</span>
                                                    @endif
                                                @endforeach
                                                @if (!in_array($p->id, $activeDeal->pluck('product.id')->all()))
                                                    <span
                                                        class="current-price text-brand">€{{ number_format($p->sale_price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="{{ route('add_to_cart', $p->id) }}"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                @endif




                <style>
                    /* Center-align pagination links */
                    .pagination-area .text-center {
                        text-align: center;
                    }
                </style>
                <!--product grid-->
                <div class="pagination-area mt-20 mb-20">
                    <div class="text-center">
                    </div>
                </div>




<!-- Pagination Section -->
<div class="pagination-area mt-30 mb-50">
    @if ($products->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}&sort={{ request('sort') }}" rel="prev">
                            <i class="material-icons md-chevron_left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}&sort={{ request('sort') }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}&sort={{ request('sort') }}" rel="next">
                            <i class="material-icons md-chevron_right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>


                <section class="section-padding pb-5">
                    <div class="section-title">
                        <h3 class="">Deals Of The Day</h3>
                        <a class="show-all" href="shop-grid-right.html">
                            All Deals
                            <i class="fi-rs-angle-right"></i>
                        </a>
                    </div>
                    <div class="row">
                        @foreach ($activeDeal as $product)

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-cart-wrap style-2">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="shop-product-right.html">
                                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="deals-countdown-wrap">
                                            <div class="deals-countdown" data-countdown="{{ $product->ends_at }}"></div>
                                        </div>
                                        <div class="deals-content">
                                            <h2><a href="shop-product-right.html">{{ $product->product->name }}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="vendor-details-1.html">Old
                                                        El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>€{{ ($product->product->sale_price - $product->discount_percentage)}}</span>

                                                    <span class="old-price">€{{ $product->product->sale_price }}</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add"
                                                        href="{{ route('add_to_cart', $product->product->id) }}"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </section>

                <!--End Deals-->
            </div>



            <div class="col-lg-1-5 primary-sidebar sticky-sidebar">


                <div class="sidebar-widget widget-category-2 mb-30">
                    @if (!isset($ray) && !isset($category) && !isset($subCategory))
                        <h5 class="section-title style-1 mb-30">Rays</h5>
                        <ul>
                            @foreach ($rays as $raysCategory)
                                <li>
                                    <a href="{{ route('shoplist', [$raysCategory->slug]) }}">{{ $raysCategory->name }}</a>
                                    <span class="badge rounded-pill alert-success">{{ $raysCategory->products->count() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @elseif (isset($ray) && !isset($category))
                        <h5 class="section-title style-1 mb-30">Categories</h5>
                        <ul>
                            @foreach ($ray->categories as $category)
                                <li>
                                    <a href="{{ route('shoplist', [$ray->slug, $category->slug]) }}">{{ $category->name }}</a>
                                    <span class="count">{{ $category->products->count() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @elseif (isset($category) && isset($ray))
                        <h5 class="section-title style-1 mb-30">Subcategories</h5>
                        <ul>
                            @foreach ($category->subCategories as $subCategory)
                                <li>
                                    <a
                                        href="{{ route('shoplist', [$ray->slug, $category->slug, $subCategory->slug]) }}">{{ $subCategory->name }}</a>
                                    <span class="count">{{ $subCategory->products->count() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>




                <style>
                    /* Style the accordion container */
                    .margin {
                        margin-left: 13%;
                        /* Adjust the right margin to move the checkboxes and labels to the right */
                        margin-top: -14px;
                        /* This aligns the label to the top */
                    }


                    .accordion {
                        display: flex;
                        flex-direction: column;
                    }


                    /* Style the accordion item headers */
                    .accordion-item {
                        background-color: #ffffff;
                        padding: 10px;
                        margin: 5px;
                        cursor: pointer;
                    }

                    /* Style the accordion item content (hidden by default) */
                    .accordion-content {
                        display: none;
                        padding: 10px;
                    }

                    /* Style the active accordion item */
                    .active {
                        background-color: #ffffff;
                    }
                </style>

                <script>
                    // JavaScript to toggle accordion items
                    const accordionItems = document.querySelectorAll('.accordion-item');

                    accordionItems.forEach(item => {
                        item.addEventListener('click', () => {
                            item.classList.toggle('active');
                            const content = item.nextElementSibling;
                            if (content.style.display === 'block') {
                                content.style.display = 'none';
                            } else {
                                content.style.display = 'block';
                            }
                        });
                    });

                </script>
                </ul>





                <!-- Fillter By Price -->
                <div class="sidebar-widget price_range range mb-30">
                    <h5 class="section-title style-1 mb-30">Price filter</h5>


                    <div class="price-filter">
                        <div class="price-filter-inner">
                            <div id="price-slider" class="mb-20"></div>
                            <div class="d-flex justify-content-between">
                                <div class="caption"> <strong class="text-brand">From $</strong><strong
                                        id="price-range-value1" class="text-brand"></strong></div>
                                <div class="caption"><strong class="text-brand">To $</strong><strong
                                        id="price-range-value2" class="text-brand"></strong></div>
                            </div>
                        </div>
                    </div>


                   <!-- Add this script to handle brand filtering -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Handle brand checkbox changes
    $('.brand-checkbox').on('change', function () {
        var selectedBrands = [];
        $('.brand-checkbox:checked').each(function () {
            selectedBrands.push($(this).val());
        });

        // Get current URL and parameters
        var currentUrl = window.location.href.split('?')[0];
        var params = new URLSearchParams(window.location.search);

        // Update brands parameter
        if (selectedBrands.length > 0) {
            params.set('brands', selectedBrands.join(','));
        } else {
            params.delete('brands');
        }

        // Reload the page with updated filters
        window.location.href = currentUrl + '?' + params.toString();
    });
});
</script>

<!-- Brand Filter Section -->
<div class="container">
    <div class="list-group">
        <div class="list-group-item mb-10 mt-10">
            <label class="fw-900">Brands</label>
            <div class="custome-checkbox">
                @foreach($brands as $brand)
                    <input class="form-check-input brand-checkbox" type="checkbox" name="checkbox"
                        id="exampleCheckbox{{ $brand->id }}" value="{{ $brand->id }}"
                        {{ in_array($brand->id, explode(',', request('brands'))) ? 'checked' : '' }} />
                    <label class="form-check-label" for="exampleCheckbox{{ $brand->id }}">
                        <span>{{ $brand->name }} {{ $brand->products_count }}</span>
                    </label>
                    <br />
                @endforeach
            </div>
        </div>
    </div>
</div>

                    <a href="" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i>
                        Fillter</a>
                </div>


                <!-- Product sidebar Widget -->

                <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                    <img src="{{ asset('assets/imgs/banner/banner-11.png') }}" alt="" />
                    <div class="banner-text">
                        <span>Oganic</span>
                        <h4>
                            Save 17% <br />
                            on <span class="text-brand">Oganic</span><br />
                            Juice
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Vendor JS-->
<script src="{{ url('assets/js/plugins/slider-range.js') }}"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




@endsection