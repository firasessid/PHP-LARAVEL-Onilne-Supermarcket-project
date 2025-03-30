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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/css/main.css?v=' . filemtime(public_path('assets/css/main.css'))) }}" />
</head>

@php
    $lastDeal = $activeDeal->last(); // Get the last deal from the $activeDeal array
@endphp

<!-- Modal -->
@if ($lastDeal)

    <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-labelledby="onloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal" style="background-image: url('{{ asset('storage/images/' . $lastDeal->image) }}')">


                        <div class="deal-top">
                            <h6 class="mb-10 text-brand-2">Deal of the Day</h6>
                        </div>

                        <div class="deal-content detail-info">
                            <h4 class="product-title"><a href="shop-product-right.html"
                                    class="text-heading">{{ $lastDeal->product->name }}</a></h4>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    @if ($lastDeal)
                                        <span
                                            class="current-price text-brand">€{{ $lastDeal->product->sale_price - $lastDeal->discount_percentage }}</span>
                                        <span>
                                            <span class="save-price font-md color3 ml-15">
                                                {{ number_format(($lastDeal->discount_percentage / $lastDeal->product->sale_price) * 100) }}%
                                                Off
                                            </span>
                                            <span class="old-price font-md ml-15">€{{ $lastDeal->product->sale_price }}</span>
                                        </span>
                                    @else
                                        <span class="current-price text-brand">€{{ $lastDeal->product->sale_price }}</span>
                                    @endif




                                </div>
                            </div>
                        </div>
                        <div class="deal-bottom">
                            <p class="mb-20">Hurry Up! Offer End In:</p>

                            <div class="deals-countdown pl-5" data-countdown="{{ $lastDeal->ends_at }}">
                                <span class="countdown-section"><span class="countdown-amount hover-up">03</span><span
                                        class="countdown-period"> days </span></span><span class="countdown-section"><span
                                        class="countdown-amount hover-up">02</span><span class="countdown-period"> hours
                                    </span></span><span class="countdown-section"><span
                                        class="countdown-amount hover-up">43</span><span class="countdown-period"> mins
                                    </span></span><span class="countdown-section"><span
                                        class="countdown-amount hover-up">29</span><span class="countdown-period"> sec
                                    </span></span>
                            </div>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 rates)</span>
                                </div>
                            </div>
                            <a href="{{ route('shoplist') }}" class="btn hover-up">Shop Now <i
                                    class="fi-rs-arrow-right"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

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
                                @if ($p->quantity >= 1 && $p->quantity <= 10)
                                    <span class="stock-status out-stock">Limited </span>

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
                                        <span class="current-price text-brand">€{{$p->sale_price}}</span>
                                        <span>
                                            <span class="save-price font-md color3 ml-15">26% Off</span>
                                            <span class="old-price font-md ml-15">€{{$p->sale_price}}</span>
                                        </span>
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
                                        <li class="mb-5">Ray : <span class="text-brand">{{$p->rayName}}</span></li>
                                        <li class="mb-5">Category : <span class="text-brand">{{$p->categoryName}}</span>
                                        </li>
                                        <li class="mb-5">Sub category : <span
                                                class="text-brand">{{$p->subcategoryName}}</span></li>
                                        <li class="mb-5">Brand : <span class="text-brand">
                                                @if ($p->brandName == null)
                                                    <span class="badge rounded-pill alert-warning">No brand given</span>
                                                @else
                                                    {{$p->brandName}}
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

<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="row">

            <div class="col-lg-7">
                <div class="home-slide-cover mt-30">
                    <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                        <div class="single-hero-slider single-animation-wrap"
                            style="background-image: url(assets/imgs/slider/slider-7.png)">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40">
                                    Don’t miss amazing<br />
                                    grocery deals
                                </h1>
                                <p class="mb-65">Sign up for the daily newsletter</p>
                                <form class="form-subcriber d-flex">
                                    <input type="email" placeholder="Your emaill address" />
                                    <button class="btn" type="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                        <div class="single-hero-slider single-animation-wrap"
                            style="background-image: url(assets/imgs/slider/slider-8.png)">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40">
                                    Fresh Vegetables<br />
                                    Big discount
                                </h1>
                                <p class="mb-65">Save up to 50% off on your first order</p>
                                <form class="form-subcriber d-flex">
                                    <input type="email" placeholder="Your emaill address" />
                                    <button class="btn" type="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="slider-arrow hero-slider-1-arrow"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <div class="banner-img style-4 mt-30">
                            <img src="assets/imgs/banner/banner-14.png" alt="" />
                            <div class="banner-text">
                                <h4 class="mb-30">
                                    Everyday Fresh &amp; <br />Clean with Our<br />
                                    Products
                                </h4>
                                <a href="shop-grid-right.html" class="btn btn-xs mb-50">Shop Now <i
                                        class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12">
                        <div class="banner-img style-5 mt-5 mt-md-30">
                            <img src="assets/imgs/banner/banner-15.png" alt="" />
                            <div class="banner-text">
                                <h5 class="mb-20">
                                    The best Organic <br />
                                    Products Online
                                </h5>
                                <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                        class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Standard size for category cards */
    .card-1 {
        width: 200px;
        /* Fixed width for cards */
        height: 220px;
        /* Fixed height for cards */
        margin: 5px;
        padding: 10px;
        text-align: center;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Ensure images are scaled and centered */
    .card-1 img {
        width: 150px;
        /* Fixed image width */
        height: 100px;
        /* Fixed image height */
        object-fit: contain;
        /* Avoid stretching */
        margin: 0 auto;
    }

    /* Standardize heading size */
    .card-1 h6 {
        font-size: 14px;
        /* Smaller font size for titles */
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    /* Adjust the 'items' text */
    .card-1 span {
        font-size: 12px;
        color: #555;
        /* Slightly lighter color */
    }
</style>
<!--End hero slider-->
<section class="popular-categories section-padding">
    <div class="container">
        <div class="section-title">
            <div class="title">
                <h3>Find your needs</h3>

            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows">
            </div>
        </div>
        <div class="carausel-8-columns-cover position-relative">
            <div class="carausel-8-columns" id="carausel-8-columns">

                @foreach ($rays as $raysCategory)

                    @foreach ($raysCategory->categories as $c)
                        @foreach ($c->subCategories as $s)

                            <div class="card-1">
                                <figure class="img-hover-scale overflow-hidden">
                                    <a href="{{ route("shoplist", [$raysCategory->slug, $c->slug, $s->slug]) }}"> <img
                                            src="{{ asset('storage/images/' . $s->image) }}" alt=""
                                            style="width: 250%; height: 0%;" /></a>
                                </figure>
                                <h6>
                                    <a href="{{ route("shoplist", [$raysCategory->slug, $c->slug, $s->slug])}}">{{$s->name}}</a>
                                </h6>
                            </div>
                        @endforeach
                    @endforeach

                @endforeach
            </div>

        </div>
    </div>
</section>

<!--End category slider-->
<section class="banners mb-25">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <img src="assets/imgs/banner/banner-1.png" alt="" />
                    <div class="banner-text">
                        <h4>
                            Everyday Fresh & <br />Clean with Our<br />
                            Products
                        </h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <img src="assets/imgs/banner/banner-2.png" alt="" />
                    <div class="banner-text">
                        <h4>
                            Make your Breakfast<br />
                            Healthy and Easy
                        </h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-md-none d-lg-flex">
                <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                    <img src="assets/imgs/banner/banner-3.png" alt="" />
                    <div class="banner-text">
                        <h4>The best Organic <br />Products Online</h4>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style></style>
<!--End banners-->
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>Our products</h3>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach ($products as $p)
                        <!--end product card-->


                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('products_view', ['id' => $p->id]) }}">

                                            @foreach ($p->images->take(2) as $index => $image)
                                                @if ($index === 0)
                                                    <img class="default-img" src="{{ asset('storage/images/' . $image->image) }}"
                                                        alt="Default Image" />
                                                @elseif ($index === 1)
                                                    <img class="hover-img" src="{{ asset('storage/images/' . $image->image) }}"
                                                        alt="Hover Image" />
                                                @endif
                                            @endforeach </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
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
                                                    class="sale">{{ number_format(($product->discount_percentage / $p->sale_price) * 100) }}
                                                    %</span>
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
                                        <a href="{{ route('products_view', ['id' => $p->id]) }}">{{$p->name}}</a>
                                    </div>
                                    <h2><a href="{{ route('products_view', ['id' => $p->id]) }}">{{$p->description}}</a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.5)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted"> {{$p->quantity}}<a
                                                href="vendor-details-1.html">Item</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            @foreach ($activeDeal as $product)
                                                @if ($p->id == $product->product->id)
                                                    <span>€{{ $p->sale_price - $product->discount_percentage }}</span>
                                                    <span class="old-price">€{{ $p->sale_price }}</span>
                                                @endif
                                            @endforeach

                                            @if (!in_array($p->id, $activeDeal->pluck('product.id')->all()))
                                                <span>€{{ $p->sale_price }}</span>
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
                        <!--end product card-->
                    @endforeach
                </div>
                <!--End product-grid-4-->
            </div>




            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>

            </script>

            <!--En tab two-->

        </div>
        <!--End tab-content-->
    </div>
</section>
<style>
    /* Standard size for category cards */
    .card-2 {
        width: 200px;
        /* Fixed width for cards */
        height: 220px;
        /* Fixed height for cards */
        margin: 5px;
        padding: 10px;
        text-align: center;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Ensure images are scaled and centered */
    .card-2 img {
        width: 150px;
        /* Fixed image width */
        height: 100px;
        /* Fixed image height */
        object-fit: contain;
        /* Avoid stretching */
        margin: 0 auto;
    }

    /* Standardize heading size */
    .card-2 h6 {
        font-size: 14px;
        /* Smaller font size for titles */
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    /* Adjust the 'items' text */
    .card-2 span {
        font-size: 12px;
        color: #555;
        /* Slightly lighter color */
    }

    /* Background colors */
    .bg-9 {
        background-color: #f9f9f9;
    }

    .bg-10 {
        background-color: #ffe6e6;
    }

    .bg-11 {
        background-color: #e6ffe6;
    }

    .bg-12 {
        background-color: #e6f7ff;
    }

    .bg-13 {
        background-color: #fff7e6;
    }

    .bg-14 {
        background-color: #f3e6ff;
    }
</style>
<!--Products Tabs-->
<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Featured Categories</h3>

            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow"
                id="carausel-10-columns-arrows"></div>
        </div>




        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">
                @foreach ($rays as $raysCategory)
                            @foreach ($raysCategory->categories as $index => $c)
                                        @php
                                            $cssClasses = ['bg-9', 'bg-10', 'bg-11', 'bg-12', 'bg-13', 'bg-14'];
                                            $delay = ($index + 1) * 0.1;
                                            $cssClass = $cssClasses[$index % count($cssClasses)];
                                        @endphp
                                        <div class="card-2 {{ $cssClass }} wow animate__animated animate__fadeInUp"
                                            data-wow-delay="{{ $delay }}s">
                                            <figure class="img-hover-scale overflow-hidden">
                                                <a href="{{ route("shoplist", [$raysCategory->slug, $c->slug]) }}">
                                                    <img src="{{ asset('storage/images/' . $c->image) }}" alt="{{ $c->name }}" />
                                                </a>
                                            </figure>
                                            <h6>
                                                <a href="{{ route("shoplist", [$raysCategory->slug, $c->slug]) }}">{{ $c->name }}</a>
                                            </h6>
                                            <span></span>
                                        </div>
                            @endforeach
                @endforeach
            </div>
        </div>

</section>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="banner-img style-6 wow animate__animated animate__fadeInUp" data-wow-delay="0">
                    <img src="assets/imgs/banner/banner-16.png" alt="" />
                    <div class="banner-text">
                        <h6 class="mb-10 mt-30">Everyday Fresh with<br />Our Products</h6>
                        <p>Go to supplier</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="banner-img style-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                    <img src="assets/imgs/banner/banner-17.png" alt="" />
                    <div class="banner-text">
                        <h6 class="mb-10 mt-30">100% guaranteed all<br />Fresh items</h6>
                        <p>Go to supplier</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="banner-img style-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                    <img src="assets/imgs/banner/banner-18.png" alt="" />
                    <div class="banner-text">
                        <h6 class="mb-10 mt-30">Special grocery sale<br />off this month</h6>
                        <p>Go to supplier</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="banner-img style-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                    <img src="assets/imgs/banner/banner-19.png" alt="" />
                    <div class="banner-text">
                        <h6 class="mb-10 mt-30">
                            Enjoy 15% OFF for all<br />
                            vegetable and fruit
                        </h6>
                        <p>Go to supplier</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End 4 banners-->
<section class="section-padding pb-5">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3 class="">Daily Best Sells</h3>
            <ul class="nav nav-tabs links" id="myTab-2" role="tablist">
                <li class="nav-item" >
                    <button class="nav-link active" id="nav-tab-one-1" data-bs-toggle="tab" data-bs-target="#tab-one-1"
                        type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                </li>
                <li class="nav-item" >
                    <button class="nav-link" id="nav-tab-two-1" data-bs-toggle="tab" data-bs-target="#tab-two-1"
                        type="button" role="tab" aria-controls="tab-two" aria-selected="false">Top selling</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="nav-tab-three-1" data-bs-toggle="tab" data-bs-target="#tab-three-1"
                        type="button" role="tab" aria-controls="tab-three" aria-selected="false">New added</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                <div class="banner-img style-2">
                    <div class="banner-text">
                        <h2 class="mb-100">Bring nature into your home</h2>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                           
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">

                                @foreach ($featured as $f)

                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products_view', ['id' => $f->id]) }}">
                                                    @foreach ($f->images->take(2) as $index => $image)
                                                        @if ($index === 0)
                                                            <img class="default-img"
                                                                src="{{ asset('storage/images/' . $image->image) }}"
                                                                alt="Default Image" />
                                                        @elseif ($index === 1)
                                                            <img class="hover-img"
                                                                src="{{ asset('storage/images/' . $image->image) }}"
                                                                alt="Hover Image" />
                                                        @endif
                                                    @endforeach 
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i
                                                        class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            @if ($f->quantity == 0)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Out of stock </span>
                                                </div>
                                            @endif


                                            @foreach ($activeDeal as $product)
                                                @if ($f->quantity > 10 && $f->id != $product->product->id)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="new">In stock</span>
                                                    </div>
                                                @endif
                                            @endforeach


                                            @foreach ($activeDeal as $product)
                                                @if ($f->id == $product->product->id)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span
                                                            class="sale">{{ number_format(($product->discount_percentage / $f->sale_price) * 100) }}
                                                            %</span>
                                                    </div>
                                                @endif
                                            @endforeach


                                            @if ($f->quantity >= 1 && $f->quantity <= 10)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="best">Limited</span>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a
                                                    href="{{ route('products_view', ['id' => $f->id]) }}">{{ $p->short_description }}</a>
                                            </div>
                                            <h2><a href="{{ route('products_view', ['id' => $f->id]) }}">{{ $f->name }}</a>
                                            </h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                @foreach ($activeDeal as $product)
                                                    @if ($f->id == $product->product->id)
                                                        <span>€{{ $f->sale_price - $product->discount_percentage }}</span>
                                                        <span class="old-price">€{{ $f->sale_price }}</span>
                                                    @endif
                                                @endforeach

                                                @if (!in_array($f->id, $activeDeal->pluck('product.id')->all()))
                                                    <span>€{{ $f->sale_price }}</span>
                                                @endif
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 80%"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading">In stock </span>
                                            </div>

                                            <a class="btn w-100 hover-up" href="{{ route('add_to_cart', $p->id) }}"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add</a>


                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!--End tab-pane-->
                    <div class="tab-pane fade" id="tab-two-1" role="tabpanel" aria-labelledby="tab-two-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-2">

                                <!--End product Wrap-->
                                  @foreach ($topSelling as $ts)

                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('products_view', $ts->id) }}">
                                                        @foreach ($ts->images->take(2) as $index => $image)
                                                            @if($loop->first)
                                                                <img class="default-img"
                                                                    src="{{ asset('storage/images/' . $image->image) }}"
                                                                    alt="Default Image">
                                                            @else
                                                                <img class="hover-img"
                                                                    src="{{ asset('storage/images/' . $image->image) }}"
                                                                    alt="Hover Image">
                                                            @endif
                                                        @endforeach
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up"
                                                        data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                        <i class="fi-rs-eye"></i>
                                                    </a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                        href="shop-wishlist.html">
                                                        <i class="fi-rs-heart"></i>
                                                    </a>
                                                    <a aria-label="Compare" class="action-btn small hover-up"
                                                        href="shop-compare.html">
                                                        <i class="fi-rs-shuffle"></i>
                                                    </a>
                                                </div>
                                                @if($ts->quantity == 0)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="hot">Out of stock</span>
                                                    </div>
                                                @endif
                                                @foreach($activeDeal as $deal)
                                                    @if($ts->id == $deal->product->id)
                                                        <div class="product-badges product-badges-position product-badges-mrg">
                                                            <span
                                                                class="sale">{{ number_format(($deal->discount_percentage / $ts->sale_price) * 100) }}%</span>
                                                        </div>
                                                    @elseif($ts->quantity > 10)
                                                        <div class="product-badges product-badges-position product-badges-mrg">
                                                            <span class="new">In stock</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($ts->quantity >= 1 && $ts->quantity <= 10)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="best">Limited</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a
                                                        href="{{ route('products_view', $ts->id) }}">{{ $ts->short_description }}</a>
                                                </div>
                                                <h2><a href="{{ route('products_view', $ts->id) }}">{{ $ts->name }}</a></h2>
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <div class="product-price mt-10">
                                                    @php $hasDeal = false; @endphp
                                                    @foreach($activeDeal as $deal)
                                                        @if($ts->id == $deal->product->id)
                                                            <span>€{{ $ts->sale_price - $deal->discount_percentage }}</span>
                                                            <span class="old-price">€{{ $ts->sale_price }}</span>
                                                            @php $hasDeal = true; @endphp
                                                        @endif
                                                    @endforeach
                                                    @if(!$hasDeal)
                                                        <span>€{{ $ts->sale_price }}</span>
                                                    @endif
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading">Sold:
                                                        {{ $ts->total_sold ?? 0 }}</span>
                                                </div>
                                                <a class="btn w-100 hover-up" href="{{ route('add_to_cart', $ts->id) }}">
                                                    <i class="fi-rs-shopping-cart mr-5"></i>Add
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                <!--End product Wrap-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-three-1" role="tabpanel" aria-labelledby="tab-three-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                           
                                <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-3">
                                  @foreach ($newProducts as $f)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('products_view', ['id' => $f->id]) }}">

                                                    @foreach ($f->images->take(2) as $index => $image)
                                                        @if ($index === 0)
                                                            <img class="default-img"
                                                                src="{{ asset('storage/images/' . $image->image) }}"
                                                                alt="Default Image" />
                                                        @elseif ($index === 1)
                                                            <img class="hover-img"
                                                                src="{{ asset('storage/images/' . $image->image) }}"
                                                                alt="Hover Image" />
                                                        @endif
                                                    @endforeach </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i
                                                        class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            @if ($f->quantity == 0)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Out of stock </span>
                                                </div>
                                            @endif


                                            @foreach ($activeDeal as $product)
                                                @if ($f->quantity > 10 && $f->id != $product->product->id)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="new">In stock</span>
                                                    </div>
                                                @endif
                                            @endforeach


                                            @foreach ($activeDeal as $product)
                                                @if ($f->id == $product->product->id)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span
                                                            class="sale">{{ number_format(($product->discount_percentage / $f->sale_price) * 100) }}
                                                            %</span>
                                                    </div>
                                                @endif
                                            @endforeach


                                            @if ($f->quantity >= 1 && $f->quantity <= 10)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="best">Limited</span>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ route('products_view', ['id' => $f->id]) }}"">{{ $p->short_description }}</a>
                                                            </div>
                                                            <h2><a href=" {{ route('products_view', ['id' => $f->id]) }}">{{ $f->name }}</a></h2>
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <div class="product-price mt-10">
                                                    @foreach ($activeDeal as $product)
                                                        @if ($f->id == $product->product->id)
                                                            <span>€{{ $f->sale_price - $product->discount_percentage }}</span>
                                                            <span class="old-price">€{{ $f->sale_price }}</span>
                                                        @endif
                                                    @endforeach

                                                    @if (!in_array($f->id, $activeDeal->pluck('product.id')->all()))
                                                        <span>€{{ $f->sale_price }}</span>
                                                    @endif
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Sold: 90/120</span>
                                                </div>

                                                <a class="btn w-100 hover-up" href="{{ route('add_to_cart', $p->id) }}"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add</a>


                                            </div>
                                        </div>

                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End tab-content-->
                </div>
                <!--End Col-lg-9-->
            </div>
        </div>
</section>

<!--End Best Sales-->
@unless ($activeDeal != null)

    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="1s">
                <h3 class="">Deals Of The Day</h3>
                <a class="show-all" href="shop-grid-right.html">All Deals <i class="fi-rs-angle-right"></i></a>
            </div>

            <div class="row">
                @foreach ($activeDeal as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 d-none d-xl-block">
                        <div class="product-cart-wrap style-2 wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                            <div class="product-img-action-wrap">

                                <img class="default-img" src="{{ asset('storage/images/' . $product->image) }}"
                                    alt="Default Image" />


                                <div class="product-img">
                                    <a href="shop-product-right.html">

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
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">Yoplait</a></span>
                                    </div>


                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>€{{ ($product->product->sale_price - $product->discount_percentage)}}</span>

                                            <span class="old-price">€{{ $product->product->sale_price }}</span>
                                        </div>
                                        <div class="add-cart">

                                            <a class="add" href="{{ route('add_to_cart', $product->product->id) }}"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endunless
<!--End Deals-->

<!--End 4 columns-->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center">
                <img src="assets/imgs/theme/loading.gif" alt="" />
            </div>
        </div>
    </div>
</div>

@endsection