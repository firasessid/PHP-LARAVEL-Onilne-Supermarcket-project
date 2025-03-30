

@section('content')
@extends('layouts.main')
@section('main-container')

<main class="main pages mb-80">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Brands List
            </div>
        </div>
    </div>
    <div class="page-content pt-50">
        <div class="container">
            <div class="archive-header-2 text-center">
                <h1 class="display-2 mb-50">Brands List</h1>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">
                                <form action="#">
                                    <input type="text" placeholder="Search brands (by name)..." />
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-50">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We have <strong class="text-brand">7</strong> brands now</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
                                        <li><a href="#">All</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Mall</a></li>
                                        <li><a href="#">Featured</a></li>
                                        <li><a href="#">Preferred</a></li>
                                        <li><a href="#">Total items</a></li>
                                        <li><a href="#">Avg. Rating</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
            
            .vendor-img {
    height: 100px; /* Ajustez cette hauteur selon vos besoins */
    display: flex;
    overflow: hidden; /* Assure que les images restent dans cette hauteur */
}

.vendor-img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* Assure que l'image conserve ses proportions sans se déformer */
}

            .vendor-grid {

    flex-wrap: wrap;
}

.vendor-wrap {

    height: 90%; /* Uniformise la hauteur */
    border: 1px solid #e5e5e5; /* Exemple de bordure */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
<div class="row vendor-grid">
    @foreach($brand as $b)
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="vendor-wrap mb-40">
                <div class="vendor-img-action-wrap">
                    <div class="vendor-img">
                        <a href="vendor-details-1.html">
                            <img class="default-img" src="{{ asset('storage/images/' . $b->image) }}" alt="" />
                        </a>
                    </div>
                    <div class="product-badges product-badges-position product-badges-mrg">
                        <span class="hot">Mall</span>
                    </div>
                </div>
                <div class="vendor-content-wrap">
                    <div class="d-flex justify-content-between align-items-end mb-30">
                        <div>
                            <div class="product-category">
                                <span class="text-muted">Since 2012</span>
                            </div>
                            <h4 class="mb-5"><a href="vendor-details-1.html">{{ $b->name }}</a></h4>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                        </div>
                        <div class="mb-10">
                            <span class="font-small total-product">
                                @if ($b->products)
                                    {{ count($b->products) }} products
                                @else
                                    0 products
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="vendor-info mb-30">
                        <ul class="contact-infor text-muted">
                        <li><img src="assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>10 Downing Street, London, SW1A 2AA, United Kingdom</span></li>
<li><img src="assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Call Us:</strong><span>(+44) 20 7946 0958</span></li>
  
                    </ul>
                    </div>
                    <a href="vendor-details-1.html" class="btn btn-xs">Visit Store <i class="fi-rs-arrow-small-right"></i></a>
                </div>
            </div>
        </div>
    @endforeach
</div>




            <div class="pagination-area mt-20 mb-20">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>
@endsection

