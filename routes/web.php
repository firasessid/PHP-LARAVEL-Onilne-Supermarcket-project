<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SubCategorieController;
use App\Http\Controllers\RaysController;
use App\Http\Controllers\testController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RecommendationController;
use App\Models\Product;
use App\Http\Controllers\DealController;

use App\Http\Controllers\Api\UserSessionController;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use OpenAI\Client;


use Illuminate\Http\Request;
use OpenAI\Factory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();




Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/sales-regression', [App\Http\Controllers\AdminController::class, 'getSalesRegressionResults'])->name('sales-regression')->middleware('auth');

Route::get('/recommendations', [RecommendationController::class, 'recommend'])->name('recommendations');

Route::get('/coupons-perfermance', [AdminController::class, 'index'])->name('coupons.analytics');

Route::get('/analyse-predictive', [App\Http\Controllers\AdminController::class, 'showForecast'])->name('analyse-predictive');

Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/setup', [AccountController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/enable', [AccountController::class, 'enable'])->name('2fa.enable');
    Route::get('/2fa/verify', [AccountController::class, 'showVerifyForm'])->name('2fa.verify.form');
    Route::post('/2fa/verify', [AccountController::class, 'verify'])->name('2fa.verify');
});
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/add_ray', [RaysController::class, 'create'])->name('add_ray');
Route::post('ray/create', [RaysController::class, 'store'])->name('store4');
Route::get('/rays_list', [RaysController::class, 'index'])->name('rays_list');
Route::delete('ray/{id}', [RaysController::class, 'delete'])->name('deleteray');

Route::middleware(['auth', '2fa'])->group(function () {

      
   });// Add this route inside the auth middleware group
Route::post('/2fa/generate-secret', [AccountController::class, 'generateSecret'])
    ->name('2fa.generate.secret');
// Après désactivation, rediriger vers login
Route::post('/2fa/disable', [AccountController::class, 'disable'])
    ->name('2fa.disable');

// Page de setup accessible SANS middleware 2FA
Route::get('/setting', [AccountController::class, 'setup'])
    ->name('2fa.setup')
    ->withoutMiddleware(['2fa']);

// In routes/web.php or routes/api.php
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::middleware(['auth'])->get('/user/{userId}/sessions', [UserSessionController::class, 'getSessions']);

Route::get('/product/request/{id}', [App\Http\Controllers\ProductController::class, 'accept'])->name('request');

Route::get('/products/view/{id}', [App\Http\Controllers\ShopController::class, 'productview'])
    ->middleware('log.product.view')
    ->name('products_view');
Route::delete('/cart/remove/{productId}', [App\Http\Controllers\CartController::class,'removeFromCart'])->name('cart.remove');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index']);

Route::get('/shop/{raySlug?}/{categorySlug?}/{subCategorySlug?}', [App\Http\Controllers\ShopController::class, 'index'])->name('shoplist');
Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'getWishlistCount']);


Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'wishlist'])->name('wishlist');
Route::get('add/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'Addwishlist'])->name('add.wishlist');

Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::get('/add-to-cart/{id}', [ShopController::class, 'addToCart'])->name('add_to_cart');
Route::patch('/update-cart', [ShopController::class, 'update'])->name('update_cart');
Route::delete('/remove-from-cart', [ShopController::class, 'remove'])->name('remove_from_cart');

Route::post('/session', [StripeController::class, 'session'])->name('session');
Route::get('/thanks', [StripeController::class, 'success'])->name('thanks');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/process-checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}', [App\Http\Controllers\CartController::class, 'thankyou'])->name('thankyou');
Route::post('/getOrder', [CartController::class, 'getOrder'])->name('getOrder');
Route::post('apply-discount', [CartController::class, 'applyDiscount'])->name('applyDiscount');
Route::post('remove-discount', [CartController::class, 'removeDiscount'])->name('removeDiscount');

Route::group(['middleware'=>'auth'], function(){

    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

});
Route::post('/filter-products', [ShopController::class, 'filterProducts'])->name('filter-products');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/filter-by-brand', [ShopController::class, 'filterByBrand'])->name('filter.by.brand');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/account', [AccountController::class, 'order'])->name('accountdetails');
    Route::get('/account/{orderID}', [AccountController::class, 'Account'])->name('accountdet');
    Route::get('/add_coupon', [AdminController::class, 'createcoupon'])->name('add_coupon');


    Route::get('/order_list', [AdminController::class, 'orderadmin'])->name('orderadmin');
    Route::get('/order_details/{OrderID}', [AdminController::class, 'orderDetails'])->name('orderDetails');
    Route::post('/update-order/{orderId}',[AdminController::class, 'update'])->name('updateOrder');


// Initial route to load the dashboard

Route::post('/update-profile', [AdminController::class,'updateProfile'])->name('update.profile');

Route::post('/update-password',[AdminController::class,'updatePassword'] )->name('update.password');


// Route to catch /chat/{id} without explicitly defining it in web.php

Route::get('/some-protected-route', [AdminController::class,'indexroute'])->middleware('CheckPermission:create-product');

// Route to update chart data with an optional date parameter
Route::get('/dashboard/{selectedDate?}', [AdminController::class, 'chartuser']);

Route::get('/payment-status', [AdminController::class, 'getPaymentStatusData']);
Route::get('/payment-method', [AdminController::class, 'getPaymentmethodData']);
Route::get('/get-segment-distribution-data', [AdminController::class, 'getSegmentDistributionData']);

    Route::get('/product_list', [ProductController::class, 'index'])->name('product_list');

    Route::get('/add_product', [ProductController::class, 'create'])->name('add_product');
    Route::post('/product/create', [ProductController::class, 'store'])->name('store');
    Route::delete('/product/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('update');
    Route::get('/products_views', [AdminController::class, 'productStatistics'])->name('showProductStatistics');


    Route::get('/shippings', [AdminController::class, 'create'])->name('shipping.create');
    Route::post('/shipping', [AdminController::class, 'store'])->name('shipping.store');
    Route::delete('/shipping/{id}', [AdminController::class, 'delete'])->name('deleteshipping');

    Route::get('/add_coupon', [AdminController::class, 'createcoupon'])->name('add_coupon');
    Route::post('coupon/create', [AdminController::class, 'storecoupon'])->name('coupon_create');
    Route::get('/coupon_list', [AdminController::class, 'indexcoupon'])->name('coupon_list');
    Route::delete('coupon/{id}', [AdminController::class, 'deletecoupon'])->name('deletecoupon');





Route::get('/add_brand', [BrandController::class, 'create'])->name('add_brand');
Route::post('brand/create', [BrandController::class, 'store'])->name('store2');
Route::get('/brand_list', [BrandController::class, 'index'])->name('brand_list');
Route::delete('brand/{id}', [BrandController::class, 'delete'])->name('deletebrand');

Route::get('/fetch-product-images/{productId}',  [ShopController::class, 'fetchProductImages']);



Route::get('/add_subcategorie', [SubCategorieController::class, 'create'])->name('add_subcategorie');
Route::post('subcategorie/create', [SubCategorieController::class, 'store'])->name('store3');
Route::get('/subcategorie_list', [SubCategorieController::class, 'index'])->name('subcategorie_list');
Route::delete('subcategorie/{id}', [SubCategorieController::class, 'delete'])->name('deletesubcateg');



Route::get('/add_categorie', [CategoryController::class, 'create'])->name('add_categorie');
Route::post('categorie/create', [CategoryController::class, 'store'])->name('store1');
Route::get('/categorie_list', [CategoryController::class, 'index'])->name('categorie_list');
Route::delete('categories/{id}', [CategoryController::class, 'delete'])->name('deletecateg');
Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('category.update');


Route::get('/get-categories/{rayId}', [ProductController::class, 'getCategories']);
Route::get('/get-subcategories/{categoryId}',  [ProductController::class, 'getSubcategories']);


Route::patch('products/{product}/approve', [ProductController::class, 'approve'])->name('admin.products.approve');
Route::patch('products/{product}/reject', [ProductController::class, 'reject'])->name('admin.products.reject');

Route::get('/deals/create',  [DealController::class, 'create'])->name('deals.create');
Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
Route::get('/deals/{deal}/edit', [DealController::class, 'edit'])->name('deals.edit');
Route::put('/deals/{deal}', [DealController::class, 'update'])->name('deals.update');
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

Route::get('/products/{productId}/active-deal', [HomeController::class, 'getActiveDeal'])->name('products.active-deal');
Route::get('/brands', [HomeController::class, 'brands'])->name('brands');
Route::get('/brand_detail', [HomeController::class, 'branddetail'])->name('branddetail');


Route::get('/test-email', function() {
    $geoService = new App\Services\GeolocationService();
    $location = $geoService->getLocation('154.160.20.150');
    
    Mail::to(env('SECURITY_EMAIL'))->send(new \App\Mail\SuspiciousLoginAlert([
        'userId' => 123,
        'ipAddress' => '154.160.20.150',
        'riskScore' => 85,
        'location' => $location // Envoyer directement l'objet location
    ]));
    
    return "Email de test envoyé avec les données : " . json_encode($location);
});

Route::get('/test-service', function() {
    $geoService = new App\Services\GeolocationService();
    $location = $geoService->getLocation('154.160.20.150');
    dd($location); // Devrait afficher Accra, Greater Accra, Ghana
});


Route::get('/test-geolocation', function() {
    $ip = '154.160.20.150';
    $response = Http::get("http://api.ipstack.com/$ip", [
        'access_key' => env('IPSTACK_KEY'),
        'fields' => 'city,region_name,country_name,latitude,longitude'
    ]);
    return $response->json();
});


Route::get('/getSlug', function(Request $request ){
    $slug='';
    if(!empty($request->title)){
        $slug= Str::slug($request->title);
    }
    return response()->json([
        'status'=>true,
        'slug'=>$slug
    ]);
})->name('getSlug');

});

//Account for user
// 3BB77E green
