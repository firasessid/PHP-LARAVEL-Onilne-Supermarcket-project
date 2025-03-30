<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Models\Rays;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

use App\Models\Category;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

     public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Using a closure to bind data to the "header" view
        View::composer('layouts.header', function ($view) {

            $rays = Rays::all(); // Fetch your products here
            $categories = Category::with('subCategories')->get();
            $allRays  = Rays::with('products')->get();

            // Pass both variables to the view
            $view->with(compact('allRays','categories','rays'));
        });

        View::composer('layouts.headerback', function ($view) {

            $orders = Order::select('orders.*', 'users.name as userName', 'users.email as userEmail','users.avatar as Avatar')
            ->latest('id')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->get();

        $users = User::orderBy('id', 'desc')->get();



            $product = Product::select(
             'products.*',
             'users.name as userName' // Add this line to select the user's name
         )
             ->latest('products.id')
             ->leftJoin('users', 'users.id', 'products.user_id') // Add this left join for the user

             ->get();



        // Merge the collections and add a 'created_at' property for sorting

        // Sort the merged collection by 'created_at' in descending order (newest first)
         $view->with(compact('orders','users','product'));
        });

    }

}
