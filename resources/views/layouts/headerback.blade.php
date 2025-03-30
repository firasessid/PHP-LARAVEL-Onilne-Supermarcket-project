<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Nest Dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link href="{{url('assets/cs/main.css?v=1.1')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/css/switchery.css')}}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{csrf_token()}}">
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('dashboard') }}" class="brand-wrap">

                <img src="{{url('assets/imgs/theme/logosuper.png')}}" class="logo" alt="Nest Dashboard" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        @if (auth()->check())

        <nav>
            <ul class="menu-aside">

            @can('dashboard')

                <li class="menu-item active">
                    <a class="menu-link" href="{{ route('dashboard') }}">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

            @endcan
                @can('ray-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-sellers-cards.html">
                        <i class="icon material-icons md-store"></i>
                        <span class="text">Rays</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('rays_list') }}">Rays list</a>
                        <a href="{{ route('add_ray') }}">Create New</a>
                    </div>
                </li>
                @endcan

                @can('category-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-products-list.html">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Categories</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('categorie_list') }}">Category list</a>
                        <a href="{{ route('add_categorie') }}">Add category</a>
                    </div>
                </li>
                @endcan

                @can('subcategory-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-sellers-cards.html">
                        <i class="icon material-icons md-store"></i>
                        <span class="text">Sub category</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('subcategorie_list') }}">Sub Category list</a>
                        <a href="{{ route('add_subcategorie') }}">Create New</a>
                    </div>
                </li>
                @endcan

                @can('brand-list')

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('brand_list') }}"> <i class="icon material-icons md-stars"></i> <span class="text">Brands</span> </a>
                </li>
                @endcan
@php
    $canAccessDataAnalysis = auth()->user()->can('pridective-sales') || 
                             auth()->user()->can('sales-regression') || 
                             auth()->user()->can('products-statistics');
@endphp

@if ($canAccessDataAnalysis)
    <li class="menu-item has-submenu">
        <a class="menu-link" href="#">
            <i class="icon material-icons md-pie_chart align-middle" style="color:#adb5bd;"></i>
            <span class="text">Data analysis</span>
        </a>
        
        <div class="submenu">
            @can('pridective-sales')
                <a href="{{ route('analyse-predictive') }}">Pridective sales</a>
            @endcan

            @can('sales-regression')
                <a href="{{ route('sales-regression') }}">Sales regression</a>
            @endcan

            @can('products-statistics')
                <a href="{{ route('showProductStatistics') }}">Products statistics</a>
            @endcan
        </div>
    </li>
@endif


                @can('product-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-products-list.html">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Products</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('product_list') }}">Product list</a>
                        @can('product-list')

                        <a href="{{ route('add_product') }}">Add product</a>

                        @endcan
                    </div>
                </li>
                @endcan

                @can('shippings')

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('shipping.create') }}"><i class="icon material-icons md-monetization_on"></i>
                        <span class="text">Shipping management</span> </a>
                </li>
                @endcan

                @can('user-list')


                <li class="menu-item">
                    <a class="menu-link" href="{{ route('users.index') }}"> <i class="icon material-icons md-person"></i> <span class="text">Users list</span> </a>
                </li>
                @endcan
                @can('deal-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-orders-1.html">
                        <i class="icon material-icons md-stars"></i>
                        <span class="text">Deals</span>
                    </a>
                    <div class="submenu">

                        <a href="{{ route('deals.index') }}">Deal list </a>
                        @can('deal-create')

                        <a href="{{ route('deals.create') }}">add deal</a>
                        @endcan
                    </div>
                </li>
                @endcan



                @can('coupon-list')

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="page-orders-1.html">
                        <i class="icon material-icons md-add_box"></i>
                        <span class="text">Coupons</span>
                    </a>
                    <div class="submenu">

                        <a href="{{ route('coupons.analytics') }}">Coupon Perfermance </a>
                        @can('coupon-create')
                        <a href="{{ route('coupon_list') }}">Coupon list </a>

                        <a href="{{ route('add_coupon') }}">add coupon</a>
                        @endcan
                    </div>
                </li>

                @endcan

                



                <li class="menu-item">
                    <a class="menu-link" href="http://127.0.0.1:8000/chat/1">
                        <i class="icon material-icons md-chat"></i><span class="text">Messenger</span>
                    </a>
                </li>


                @can('order-list')

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('orderadmin') }}"><i class="icon material-icons md-shopping_cart"></i><span class="text">Orders</span> </a>
                </li>
                @endcan

                @can('transaction')

                <li class="menu-item">
                    <a class="menu-link" href="{{ route('transactions') }}"> <i class="icon material-icons md-monetization_on"></i> <span class="text">Transactions</span> </a>
                </li>
                @endcan



                @can('role-list')
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('roles.index') }}"> <i class="icon material-icons md-person"></i> <span class="text">Roles and Permissions</span> </a>
                </li>
                @endcan

                
            </ul>
            <hr />
            <ul class="menu-aside">
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('2fa.setup') }}"> <i class="icon material-icons md-settings"></i>
                        <span class="text">Settings</span> </a>
                </li>
                
            </ul>
            <br />
            <br />
        </nav>
        @endif

    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input list="search_terms" type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button"><i class="material-icons md-search"></i></button>
                    </div>
                    <datalist id="search_terms">
                        <option value="Products"></option>
                        <option value="New orders"></option>
                        <option value="Apple iphone"></option>
                        <option value="Ahmed Hassan"></option>
                    </datalist>
                </form>
            </div>
            <style>
                body {
                    background-color: #f0f2f5;
                    font-family: "Arial";
                }

                strong {
                    font-weight: 600;
                }

                .notification {
                    width: 360px;
                    padding: 15px;
                    background-color: white;
                    border-radius: 16px;
                    bottom: 15px;
                    left: 15px;

                }

                .notification-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 15px;
                }

                .notification-title {
                    font-size: 16px;
                    font-weight: 500;
                    text-transform: capitalize;
                }

                .notification-close {
                    cursor: pointer;
                    width: 30px;
                    height: 30px;
                    border-radius: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #f0f2f5;
                    font-size: 14px;
                }

                .notification-container {
                    display: flex;
                    align-items: flex-start;
                }

                .notification-media {
                    position: relative;
                }

                .notification-user-avatar {
                    width: 60px;
                    height: 60px;
                    border-radius: 60px;
                    -o-object-fit: cover;
                    object-fit: cover;
                }

                .notification-reaction {
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 30px;
                    color: white;
                    background-image: linear-gradient(45deg, #3BB77E, #3BB77E);
                    font-size: 14px;
                    position: absolute;
                    bottom: 0;
                    right: 0;
                }

                .notification-content {
                    width: calc(100% - 60px);
                    padding-left: 20px;
                    line-height: 1.2;
                }

                .notification-text {
                    margin-bottom: 5px;
                    display: -webkit-box;
                    -webkit-line-clamp: 3;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    padding-right: 50px;
                }

                .notification-timer {
                    color: #3BB77E;
                    font-weight: 600;
                    font-size: 14px;
                }

                .notification-status {
                    position: absolute;
                    right: 15px;
                    top: 50%;
                    /* transform: translateY(-50%); */
                    width: 15px;
                    height: 15px;
                    background-color: #3BB77E;
                    border-radius: 50%;
                }

                .notification-icon-container {
                    position: absolute;
                    bottom: -3px;
                    /* Increase the distance from the bottom */
                    right: -1px;
                    /* Increase the distance from the right */
                    width: 30px;
                    /* Adjust the size of the circle as needed */
                    height: 30px;
                    /* Adjust the size of the circle as needed */
                    background-color: #3BB77E;
                    /* Green color */
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .notification-icon-container1 {
                    position: absolute;
                    bottom: -3px;
                    /* Increase the distance from the bottom */
                    right: -1px;
                    /* Increase the distance from the right */
                    width: 30px;
                    /* Adjust the size of the circle as needed */
                    height: 30px;
                    /* Adjust the size of the circle as needed */
                    background-color: #19b4df;
                    /* Green color */
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .notification-icon-container2 {
                    position: absolute;
                    bottom: -3px;
                    /* Increase the distance from the bottom */
                    right: -1px;
                    /* Increase the distance from the right */
                    width: 30px;
                    /* Adjust the size of the circle as needed */
                    height: 30px;
                    /* Adjust the size of the circle as needed */
                    background-color: #da5858;
                    /* Green color */
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }


                .notification-facebook-icon {
                    font-size: 20px;
                    /* Adjust the font size as needed */
                    color: white;
                    position: absolute;
                    bottom: 6px;
                    /* Increase the distance from the bottom */
                }


                .notification-facebook-icon {
                    font-size: 20px;
                    /* Adjust the font size as needed */
                    color: white;
                    position: absolute;
                    bottom: 6px;
                    /* Increase the distance from the bottom */
                }

                .notification-facebook-icon {
                    font-size: 15px;
                    /* Adjust the font size as needed */
                    color: white;
                    position: absolute;
                    bottom: 6px;
                    /* Increase the distance from the bottom */
                }

                .notification-shopping-icon {
                    font-size: 20px;
                    /* Adjust the font size as needed */
                    color: white;
                    position: absolute;
                    bottom: 8px;
                    /* Increase the distance from the bottom */
                }

                .notification-user-icon {
                    font-size: 30px;
                    /* Adjust the font size as needed */
                    color: white;
                    position: absolute;
                    bottom: 8px;
                    /* Increase the distance from the bottom */
                }

                .notification-scrollable {
                    max-height: 600px;
                    /* Adjust the maximum height as needed */
                    overflow-y: auto;
                    /* Enable vertical scrollbar when content overflows */
                }

                /* Define the scrollbar styles */
                .notification-scrollable::-webkit-scrollbar {
                    width: 8px;
                    /* Width of the scrollbar */
                }

                /* Define the scrollbar track */
                .notification-scrollable::-webkit-scrollbar-track {
                    background: #f0f2f5;
                    /* Background color of the track */
                }

                /* Define the scrollbar thumb */
                .notification-scrollable::-webkit-scrollbar-thumb {
                    background: #3BB77E;
                    /* Color of the scrollbar thumb */
                    border-radius: 4px;
                    /* Rounded corners for the thumb */
                }

                /* Define the scrollbar thumb when hovering */
                .notification-scrollable::-webkit-scrollbar-thumb:hover {
                    background: #36A26D;
                    /* Color of the scrollbar thumb on hover */
                }

            </style>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>$(document).ready(function() {
    // Initialize arrays to store clicked notification IDs in localStorage
    var clickedProductIds = JSON.parse(localStorage.getItem('clickedProductIds')) || [];
    var clickedNotificationIds = JSON.parse(localStorage.getItem('clickedNotificationIds')) || [];
    var clickedUserNotificationIds = JSON.parse(localStorage.getItem('clickedUserNotificationIds')) || [];

    // Calculate the total count and subtract the clicked count
    var totalProductCount = $('a[data-product-id]').length;
    var totalOrderCount = $('a[data-order-id]').length;
    var totalUserNotificationCount = $('a[data-user-id]').length;

    var clickedProductCount = clickedProductIds.length;
    var clickedOrderCount = clickedNotificationIds.length;
    var clickedUserNotificationCount = clickedUserNotificationIds.length;

    // Calculate the remaining counts
    var remainingProductCount = totalProductCount - clickedProductCount;
    var remainingOrderCount = totalOrderCount - clickedOrderCount;
    var remainingUserNotificationCount = totalUserNotificationCount - clickedUserNotificationCount;

    // Calculate the total notification count (which excludes 0 counts)
    var totalNotificationCount = totalProductCount + totalOrderCount + totalUserNotificationCount;

    // Update the badge with the total count
    var badgeCount = totalNotificationCount - (clickedProductCount + clickedOrderCount + clickedUserNotificationCount);


    // Display the badge count in the specified element
    $('#notification-badge').text(badgeCount);
    if (badgeCount > 0) {
    // Display the badge count
    document.getElementById('notification-badge').textContent = badgeCount;
} else {
    // Hide the badge when count is 0
    document.getElementById('notification-badge').style.display = 'none';
}



});

</script>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
                <ul class="nav">
                @unless (Auth::user()->hasRole('client'))

                    <li class="dropdown nav-item">
                        <a class="nav-link btn-icon" data-bs-toggle="dropdown" href="#" id="dropdownLanguage" aria-expanded="false"><i class="material-icons md-notifications animation-shake"></i><span id="notification-badge" class="badge rounded-pill"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            <!-- Include the JavaScript code here -->

                            <nav>


                                <ul class="menu-aside notification-scrollable">


                                    <li>


                                        <div class="notification">
                                            <div class="notification-header">
                                                <h3 class="notification-title">New notification</h3>
                                            </div>

                                            @php
                                            // Merge and sort the collections by creation date in descending order
                                            $combined = $users->concat($orders)->concat($product)->sortByDesc('created_at');
                                            @endphp

                                            @foreach ($combined as $item)
                                            @if ($item->created_at <= now())

                                            @if ($item instanceof \App\Models\User)
                                            @can('user-list')
                                            @unless ($item->hasRole('admin') || ($item->id === auth()->user()->id))

                                            <div class="notification-container menu-link1">
                                                <a class="menu-link" href="{{ route('users.index', [$item->id]) }}" data-user-id="{{ $item->id }}">
                                                <div class="notification-media">
    <img 
        src="{{ asset('storage/' . ($item->avatar ?? 'images/avatar-4.png')) }}" 
        alt="" 
        class="notification-user-avatar"
    >
    <div class="notification-icon-container1 user-icon">
        <i class="fa fa-user notification-user-icon"></i>
    </div>
</div>
 <div class="notification-content">
                                                        <p class="notification-text">
                                                            <!-- Debugging statement to check if $item->name is accessible -->
                                                            <!-- {{ $item->name }} -->
                                                            <strong>{{ $item->name }}</strong> just created a new account </p>
                                                        <span class="notification-timer">{{ $item->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <span id="user-notification-status-{{ $item->id }}" class="notification-status"></span>
                                                </a>
                                            </div>
                                            @endunless
                                            @endcan
                                            @elseif ($item instanceof \App\Models\Order)


                                            <div class="notification-container menu-link1">
                                                <a class="menu-link" href="{{ route('orderDetails',[$item->id]) }}" data-order-id="{{ $item->id }}">
                                                    <div class="notification-media">
                                                        @if($item->Avatar)
                                                        <img src="{{ asset('storage/' . $item->Avatar) }}" alt="" class="notification-user-avatar">
                                                        @else
                                                        <img src="{{ asset('assets/imgs/people/avatar4.png') }}" class="img-sm img-avatar" alt="Userpic" />
                                                        @endif
                                                        <div class="notification-icon-container">
                                                            <i class="icon material-icons md-shopping_cart notification-facebook-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-content">
                                                        <p class="notification-text">
                                                            <!-- Debugging statement to check if $item->name is accessible -->
                                                            <!-- {{ $item->userName }} -->
                                                            <strong>{{ $item->userName }}</strong> just applyed a new order </p>
                                                        <span class="notification-timer">{{ $item->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <span id="notification-status-{{ $item->id }}" class="notification-status"></span>
                                                </a>
                                            </div>

                                            @elseif ($item instanceof \App\Models\Product)

                                            @if (auth()->check() && auth()->user()->hasRole('admin'))
                                            @unless ($item->user->hasRole('admin'))

                                            <div class="notification-container menu-link1">
                                                <a class="menu-link" href="{{ route('request',[$item->id]) }}" data-product-id="{{ $item->id }}">
                                                    <div class="notification-media">

                                                        <img src="{{ asset('storage/images/' . $item->image) }}" alt="" class="notification-user-avatar">
                                                        <div class="notification-icon-container2 product-icon">
                                                            <i class="fa fa-shopping-bag notification-shopping-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-content">
                                                        <p class="notification-text">
                                                            <!-- Debugging statement to check if $item->name is accessible -->
                                                            <!-- {{ $item->userName }} -->
                                                            <strong>{{ $item->userName }}</strong> just create a new product , he is waiting for your accept </p>
                                                        <span class="notification-timer">{{ $item->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <span class="notification-status"></span>
                                                </a>
                                            </div>
                                            @endunless

                                            @else

                                            @if ($item['is_approved'] == 1 && $item->user && !$item->user->hasRole('admin') && $item->user->id === auth()->user()->id)
                                            <div class="notification-container menu-link1">
                                                <a class="menu-link" href="{{ route('request',[$item->id]) }}" data-product-id="{{ $item->id }}">
                                                    <div class="notification-media">

                                                        <img src="{{ asset('storage/images/' . $item->image) }}" alt="" class="notification-user-avatar">
                                                        <div class="notification-icon-container2 product-icon">
                                                            <i class="fa fa-shopping-bag notification-shopping-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-content">
                                                        <p class="notification-text">
                                                            <!-- Debugging statement to check if $item->name is accessible -->
                                                            <!-- {{ $item->userName }} -->
                                                            <strong>the admin</strong> just accepted your product request , go check it </p>
                                                        <span class="notification-timer">{{ $item->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <span class="notification-status"></span>
                                                </a>
                                            </div>
                                            @elseif ($item['is_approved'] == 0 && $item->user && !$item->user->hasRole('admin') && $item->user->id === auth()->user()->id)
                                            <div class="notification-container menu-link1">
                                                <a class="menu-link" href="{{ route('request',[$item->id]) }}" data-product-id="{{ $item->id }}">
                                                    <div class="notification-media">

                                                        <img src="{{ asset('storage/images/' . $item->image) }}" alt="" class="notification-user-avatar">
                                                        <div class="notification-icon-container2 product-icon">
                                                            <i class="fa fa-shopping-bag notification-shopping-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-content">
                                                        <p class="notification-text">
                                                            <!-- Debugging statement to check if $item->name is accessible -->
                                                            <!-- {{ $item->userName }} -->
                                                            <strong>the admin</strong> reject your product request ,see why !! </p>
                                                        <span class="notification-timer">{{ $item->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <span class="notification-status"></span>
                                                </a>
                                            </div>



                                            @endif




                                            @endif

                                            @endif

                                            @endif

                                            @endforeach



                                        </div>

                                    </li>
                                </ul>

                            </nav>


                        </div>

                    </li>
                    @endunless


                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i class="material-icons md-cast"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownLanguage" aria-expanded="false"><i class="material-icons md-public"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            <a class="dropdown-item text-brand" href="#"><img src="assets/imgs/theme/flag-us.png" alt="English" />English</a>
                            <a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-fr.png" alt="Français" />Français</a>
                            <a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-jp.png" alt="Français" />日本語</a>
                            <a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-cn.png" alt="Français" />中国人</a>
                        </div>
                    </li>


                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false">



                            <img class="img-xs rounded-circle" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="User" />




                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href="{{ route('2fa.setup') }}"><i class="material-icons md-settings"></i>Account Settings</a>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="material-icons md-exit_to_app"> </i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>


                        </div>
                    </li>

                </ul>
            </div>

        </header>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() {
        // Initialize an array to store clicked product notification IDs in localStorage
        var clickedProductIds = JSON.parse(localStorage.getItem('clickedProductIds')) || [];

        // Add a click event handler for product notifications
        $('a[data-product-id]').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');

            // Check if this productId is in the clickedProductIds array
            if (!clickedProductIds.includes(productId)) {
                // If not in the array, add it and hide the status
                clickedProductIds.push(productId);
                localStorage.setItem('clickedProductIds', JSON.stringify(clickedProductIds));
                $(this).find('.notification-status').hide(); // Hide the notification status within the clicked product container
            }

            window.location.href = $(this).attr('href');
        });

        // Loop through clickedProductIds and hide corresponding product notifications
        clickedProductIds.forEach(function(productId) {
            $('a[data-product-id="' + productId + '"] .notification-status').hide();
        });
    });


    $(document).ready(function() {
var clickedNotificationIds = JSON.parse(localStorage.getItem('clickedNotificationIds')) || [];

$('a[data-order-id]').on('click', function(e) {
e.preventDefault();
var orderId = $(this).data('order-id');
console.log('Order Clicked: ' + orderId);

if (!clickedNotificationIds.includes(orderId)) {
clickedNotificationIds.push(orderId);
localStorage.setItem('clickedNotificationIds', JSON.stringify(clickedNotificationIds));
$('#notification-status-' + orderId).hide();
console.log('Order Status Hidden: ' + orderId);
}

window.location.href = $(this).attr('href');
});

clickedNotificationIds.forEach(function(orderId) {
$('#notification-status-' + orderId).hide();
});
});

$(document).ready(function() {
var clickedUserNotificationIds = JSON.parse(localStorage.getItem('clickedUserNotificationIds')) || [];

$('a[data-user-id]').on('click', function(e) {
e.preventDefault();
var userId = $(this).data('user-id');
console.log('User Clicked: ' + userId);

if (!clickedUserNotificationIds.includes(userId)) {
clickedUserNotificationIds.push(userId);
localStorage.setItem('clickedUserNotificationIds', JSON.stringify(clickedUserNotificationIds));
$('#user-notification-status-' + userId).hide();
console.log('User Status Hidden: ' + userId);
}

window.location.href = $(this).attr('href');
});

clickedUserNotificationIds.forEach(function(userId) {
$('#user-notification-status-' + userId).hide();
});
});

</script>




