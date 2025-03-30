<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{


    
   public function getWishlistCount()
   {
       $count = Auth::check() ? Wishlist::where('user_id', Auth::id())->count() : 0;
       return response()->json(['count' => $count]);
   }
   
   public function wishlist() {
      if (Auth::check()) {
          $wishlist = DB::table('wishlists')
              ->leftJoin('products', 'wishlists.product_id', '=', 'products.id')
              ->select('products.name', 'products.sale_price', 'products.image', 'products.quantity', 'wishlists.*')
              ->where('wishlists.user_id', Auth::id())
              ->get();
          
          return view('Front-end.shop-wishlist', compact('wishlist'));
      }
  
      $notification = array('message' => 'At first login your account', 'alert-type' => 'error');
      return redirect()->back()->with($notification);
  }
  

public function Addwishlist($id)
{
    if (Auth::check()){
     $check=DB::table('wishlists')->where('product_id',$id)->where('user_id',Auth::id())->first();
     if($check){
        $notification = array('message'=>'Already have it on yr wishlist','alert-type'=>'error');
        return redirect()->back()->with($notification);

     }
    else {

       $data=array();
       $data['product_id']=$id;
       $data['user_id']=Auth::id();
       DB::table('wishlists')->insert($data);
       $notification=array('message'=>'produit ajoutee','alert-type'=>'success');
       return redirect()->back()->with($notification);

}


    }


    $notification=array('message'=>'login to your account','alert-type'=>'error');

    return redirect()->back()->with($notification);


}




    


}
