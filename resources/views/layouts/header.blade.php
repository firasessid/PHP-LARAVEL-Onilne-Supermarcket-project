

<!DOCTYPE html>
<html class="no-js" lang="en">

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
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/imgs/theme/favicon.svg') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css?v=5.6')}}" />
      <link rel="stylesheet" href="{{ asset('assets/cs/style.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <script src="{{asset('assets/js/script.js')}}" defer></script>

</head>
<body>







    <header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="/home"><img src="{{ asset('assets/imgs/theme/logosuper.png') }}" alt="logo" /></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">

                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    

                        <style>
  #autocomplete-container {
    position: relative;
    width: 100%;
  }

  #autocomplete-list {
    position: absolute;
    background-color: white;
    border: 1px solid #3BB77E;
    z-index: 99;
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden; /* Remove bottom scrollbar */
    width: 100%;
    display: none;
  }

  #autocomplete-list.active {
    display: block;
  }

  #autocomplete-list::-webkit-scrollbar {
    width: 8px;
  }

  #autocomplete-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 5px;
  }

  #autocomplete-list::-webkit-scrollbar-thumb {
    background: #3BB77E; /* Green scrollbar */
    border-radius: 5px;
  }

  #autocomplete-list::-webkit-scrollbar-thumb:hover {
    background: #2d9c63; /* Darker green on hover */
  }

  #autocomplete-list .row {
    display: flex;
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
  }

  #autocomplete-list .row:hover {
    background-color: transparent;
  }

  #autocomplete-list img {
    object-fit: cover;
    margin-right: 10px;
    width: 100px;
    height: 100px;
  }

  #autocomplete-list h6 {
    font-size: 14px;
    margin: 0;
    flex-grow: 1;
  }

  #autocomplete-list .product-price {
    font-size: 12px;
    white-space: nowrap;
  }

  #autocomplete-list .old-price {
    text-decoration: line-through;
    color: #999;
    margin-left: 5px;
  }

  .custom-search-input {
    width: 100%;
    height: 40px;
    border: 1px solid #3BB77E;
    border-radius: 5px;
    padding: 0 10px;
    font-size: 14px;
    box-sizing: border-box;
  }

  .search-container {
    position: absolute;
    top: 38px;
    left: 250px;
    width: 700px;
    max-width: none;
  }

  #autocomplete-list .no-results {
    text-align: center;
    color: #999;
    padding: 10px;
  }
</style>

<div class="search-container">
  <input type="text" class="custom-search-input" id="search" placeholder="Search for a product..." />
  <div id="autocomplete-list"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");
  const autocompleteList = document.getElementById("autocomplete-list");

  let debounceTimer;

  searchInput.addEventListener("input", function () {
    clearTimeout(debounceTimer);

    const query = this.value.trim().toLowerCase();
    autocompleteList.innerHTML = "";

    if (query.length > 0) {
      debounceTimer = setTimeout(() => {
        fetch(`/search?query=${query}`)
          .then((response) => response.json())
          .then((products) => {
            if (products.length > 0) {
              autocompleteList.classList.add("active");
              products.forEach((product) => {
                const item = document.createElement("div");
                item.classList.add("row", "align-items-center");

                item.innerHTML = `
                  <img src="storage/images/${product.image}" alt="${product.name}" style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;" />
                  <div class="col-md-8 mb-0">
                    <h6>${product.name}</h6>
                    <div class="product-rate-cover">
                      <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                      </div>
                      <span class="font-small ml-5 text-muted"> (4.0)</span>
                    </div>
                    <div class="product-price">
                      <h6><span>$${product.sale_price}</span></h6>
                    </div>
                  </div>
                `;

                item.addEventListener("click", function () {
                  window.location.href = `/products/view/${product.id}`;
                });

                autocompleteList.appendChild(item);
              });
            } else {
              autocompleteList.classList.add("active");
              autocompleteList.innerHTML = `<div class="no-results">Aucun produit trouvé</div>`;
            }
          })
          .catch((error) => console.error("Error fetching products:", error));
      }, 300); // Debounce delay of 300ms
    } else {
      autocompleteList.classList.remove("active");
    }
  });

  document.addEventListener("click", function (e) {
    if (!autocompleteList.contains(e.target) && e.target !== searchInput) {
      autocompleteList.classList.remove("active");
    }
  });
});

</script>



                        
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">

                            
                            <div class="header-action-icon-2">
    <a href="/wishlist">
        <img class="svgInject" alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}" />
        <span class="pro-count blue" id="wishlist-count">0</span> <!-- Remplace le 5 par un ID -->
    </a>
    <a href="/wishlist"><span class="lable">Wishlist</span></a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateWishlistCount() {
            $.ajax({
                url: "/wishlist/count",
                method: "GET",
                success: function (response) {
                    $("#wishlist-count").text(response.count);
                }
            });
        }

        updateWishlistCount(); // Charger la valeur au chargement de la page
    });
</script>


                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="/cart">
                                        <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}" />
                                        <span class="pro-count blue">{{ count((array) session('cart')) }}</span>
                                    </a>
                                    <a href="/cart"><span class="lable">Cart</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>

                                        @php $total = 0 @endphp
                                            @foreach((array) session('cart') as $id => $details)
                                            @php $total += $details['sale_price'] * $details['quantity'] @endphp
                                        @endforeach

                                         @if(session('cart'))
                                         @foreach(session('cart') as $id => $details)


                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('storage/images/' . $details['image']) }}"  /></a>
                                                </div>

                                                <div class="shopping-cart-title">

                                                    <h4><a href="shop-product-right.html">{{ $details['name'] }}</a></h4>
                                                    <h4><span>{{ $details['quantity'] }} × </span>${{ $details['sale_price'] }}</h4>
                                                </div>


                                            </li>

                                             @endforeach
                                            @endif
                                        </ul>

                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                            <h4>Total price : <a href="shop-product-right.html">$ {{ $total }}</a></h4>

                                        </div>


                                            <div class="shopping-cart-button">
                                            <a href="{{ route('cart') }}" class="btn mb-20 w-100">Check your card<i class="fi-rs-sign-out ml-15"></i></a>

                                        </div>

                                        </div>
                                    </div>
                                </div>



                                 @yield('content')

                                @yield('scripts')
                                <div class="header-action-icon-2">
                                    <a href="page-account.html">
                                        <img class="svgInject" alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-user.svg') }}" />
                                    </a>



                                    @guest

                                                @if (Route::has('login'))
                                                  <a href="page-account.html"><span class="lable ml-0">Account</span></a>
                                                  <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                                @endif

                                    @else

                                    <a href="page-account.html"><span class="lable ml-0">{{ Auth::user()->name }}</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">

                                    @endguest

                                    <ul>

                                            @guest
                                                @if (Route::has('login'))
                                                <li> <a href="{{ route('login') }}"> <i class="fi fi-rs-user mr-10"></i>Login</a></li>

                                                @endif
                                            <li>
                                            @if (Route::has('register'))
                                            <li> <a href="{{ route('register') }}"> <i class="fi fi-rs-user mr-10"></i>Register</a></li>
                                            @endif
                                            @else
                                            <li id="myaccount-tab-item"><a href="{{ route('2fa.setup') }}" data-hash="#myaccount" ><i class="fi fi-rs-user mr-10"></i>My account</a></li>
                                            <li id="orders-tab-item"><a href="{{ route('orderadmin') }}" data-hash="#orders" ><i class="fi fi-rs-label mr-10"></i>Orders</a></li>

                                            


      <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fi fi-rs-sign-out mr-10"    > {{ __('Logout') }} </i>

     </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                   @csrf
                                               </form>
                                         @endguest

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
            <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="/home"><img src="{{ asset('assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span> All Rays
                                <i class="fi-rs-angle-down"></i>
                            </a>



                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                @php
        $categoriesCount = count($rays);
        $half = ceil($categoriesCount / 2);
    @endphp    <ul>

        @foreach($allRays->slice(0, $half) as $c)

               <li>
                <a href="{{ route("shoplist",$c->slug)}}"><img src="{{ asset('storage/images/' . $c->image) }}" alt="" />{{$c->name}}</a>
                </li>

        @endforeach
    </ul>

    <ul class="end">
    @foreach($allRays->slice($half) as $c)

                <li>
                    <a href="{{ route("shoplist",$c->slug)}}"><img src="{{ asset('storage/images/' . $c->image) }}" alt="" />{{$c->name}}</a>
                </li>

       @endforeach
    </ul>



                                </div>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                         <ul>
                        <li class="hot-deals"><img src="{{ asset('assets/imgs/theme/icons/icon-hot.svg') }}" alt="hot deals" /><a href="{{ route('shoplist') }}">Shop</a></li>
                                        <a class="active" href="">Home </a>

                                    <li>
                                        <a href="page-about.html">About</a>
                                    </li>
  <li>
                                        <a href="{{ route('brands') }}">Brands </a>



                                  


                                    <style>

                                        /* Hide the category and subcategory menus by default */
.level-menu,
.level-menu-modify {
    display: none;
    position: absolute; /* Ensure submenus are positioned properly */
    left: 100%; /* Position the submenu to the right of the parent item */
    top: 0;
    z-index: 10;
}

/* Display the categories when hovering over the parent category */
li:hover > .level-menu,
.level-menu li:hover > .level-menu-modify {
    display: block;
}

/* Optional: Style the hover effect */


/* Make sure the parent menu and its children stay aligned */
.sub-menu {
    position: relative;
}

.sub-menu li {
    position: relative;
}

                                    </style>
                                    <li>
    <a href="{{ route('shoplist') }}">Shop menu <i class="fi-rs-angle-down"></i></a>
    <ul class="sub-menu">
        @foreach ($allRays as $raysCategory)
            <li>
                <a href="{{ route('shoplist', [$raysCategory->slug]) }}">{{ $raysCategory->name }}</a>
                @if ($raysCategory->categories->count() > 0)
                    <ul class="level-menu">
                        @foreach ($raysCategory->categories as $categoryItem)
                            <li>
                                <a href="{{ route('shoplist', [$raysCategory->slug, $categoryItem->slug]) }}">{{ $categoryItem->name }} <i class="fi-rs-angle-right"></i></a>
                                @if ($categoryItem->subCategories->count() > 0)
                                    <ul class="level-menu level-menu-modify">
                                        @foreach ($categoryItem->subCategories as $subcategory)
                                            <li>
                                                <a href="{{ route('shoplist', [$raysCategory->slug, $categoryItem->slug, $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</li>

                                    <li>
                                        <a href="page-contact.html">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-flex">
                        <img src="{{ asset('assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                        <p>20 7946 0958<span>24/7 Support Center</span></p>
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="shop-wishlist.html">
                                    <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="shop-cart.html">
                                    <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('assets/imgs/shop/thumbnail-3.jpg') }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('assets/imgs/shop/thumbnail-4.jpg') }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="index.html"><img src="{{asset('assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->

                    <nav>
                        <ul class="mobile-menu font-heading">
                            @foreach ($allRays as $raysCategory)
                            @if ($raysCategory->categories->count() > 0)

                            <li class="menu-item-has-children">

                                    <a href="{{ route("shoplist", [$raysCategory->slug]) }}">{{ $raysCategory->name }}</a>
                                    @endif
                                    @if ($raysCategory->categories->count() > 0)
                                        <ul class="dropdown">
                                            @foreach ($raysCategory->categories as $categoryItem)
                                                <li class="menu-item-has-children">
                                                    <a href="{{ route("shoplist",[$raysCategory->slug,$categoryItem->slug]) }}">{{ $categoryItem->name }}</a>

                                                    @if ($categoryItem->subCategories->count() > 0)
                                                        <ul class="dropdown">
                                                            @foreach ($categoryItem->subCategories as $subcategory)
                                                                <li>
                                                                    <a  href="{{ route("shoplist",[$raysCategory->slug,$categoryItem->slug,$subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                                                    <!-- Add the link to $subcategory->url -->
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach


                        </ul>
                    </nav>


                          <!-- mobile menu end -->
                </div>
               
                </div>
        </div>
    </div>
