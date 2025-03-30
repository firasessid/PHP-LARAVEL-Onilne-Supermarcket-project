<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Session ;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Coupon;

use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart; // Import the shopping cart facade
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{

    public function session(Request $request)
    {
        //$user         = auth()->user();
        $productItems = [];

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        foreach (session('cart') as $id => $details) {

            $product_name = $details['name'];
            $total = $details['sale_price'];
            $quantity = $details['quantity'];

            $two0 = "00";
            $unit_amount = round($total * 100); // Convert to cents

            $productItems[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $product_name,
                    ],
                    'currency'     => 'USD',
                    'unit_amount'  => $unit_amount,
                ],
                'quantity' => $quantity
            ];
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'line_items'            => $productItems, // Remove the outer array
            'mode'                  => 'payment',
            'allow_promotion_codes' => true,
            'metadata'              => [
                'user_id' => "0001"
            ],
            'customer_email' => "essidfiras5@gmail.com", //$user->email,
            'success_url' => route('thanks'),
            'cancel_url'  => route('cancel'),

        ]);

        $this->processCheckout($request);

        return redirect()->away($checkoutSession->url);
    }

    public function processCheckout(Request $request)
    {
//2 save user adresse
$user = Auth::user();
CustomerAddress::updateOrCreate(
['user_id'=>$user->id],
['adresse'=>$request->adresse,
'adresse2'=>$request->adresse2,
'phone'=>$request->phone,
'zip'=>$request->zip,
'country_id'=>$request->country,
]);

$discountCodeId =NULL;
$promoCode='';

$totalqty = 0;
$cart = Session::get('cart', []);
$total = 0;

foreach ($cart as $item) {
    $total += $item['sale_price'] * $item['quantity'];
    $totalqty += $item['quantity'];
}

$shippingInfo = Shipping::where('country_id', $request->country)->first();
if ($shippingInfo != null) {
    $shippingCharge = $totalqty * $shippingInfo->amount;
} else {
    $shippingCharge = 0;
}

$discount = 0; // Initialize $discount

if (session()->has('code')) {
    $code = session()->get('code');
    if ($code->type == 'percent') {
        $discount = ($code->discount_amount / 100) * $total;
    } else {
        $discount = $code->discount_amount;
    }

    $discountCodeId= $code->id;
    $promoCode = $code->code;
}

$grandTotal = $total + $shippingCharge - $discount;


$order = new Order ;
$order->subtotal = $total ;
$order->shipping = $shippingCharge ;
$order->discount = $discount ;
$order->coupon_code = $promoCode ;
$order->payment_status = 'paid ' ;
$order->status = 'pending' ;

$order->coupon_code_id = $discountCodeId ;
$order->grand_total = $grandTotal ;
$order->user_id = $user->id ;
$order->country_id = $request ->country ;
$order->adresse = $request ->adresse ;
$order->adresse2 = $request ->adresse2 ;
$order->phone = $request ->phone ;
$order->zip = $request ->zip ;
$order->payment_method = $request ->payment_method ;

$order-> save() ;




$cart = session()->get('cart', []);

foreach ($cart as $productId => $item) {
    $orderItem = new OrderItem;
    $orderItem->order_id = $order->id;
    $orderItem->product_id = $productId; // Assuming you store product IDs in the cart
    $orderItem->name = $item['name'];
    $orderItem->qty = $item['quantity'];
    $orderItem->price = $item['sale_price'];
    $orderItem->total = $item['sale_price'] * $item['quantity'];
    $orderItem->save();
}

session()->forget('cart');
session()->forget('code');

session()->flash('success','You have successfully placed your order ');

// Session::forget('cart');

return response ()->json([
    'message'=>'order saved successfully',
    'status'=>true ,
    'orderId'=>$order->id,
   ]);



}



    public function success()
    {
        return view('Front-end.thankyou');
    }

    public function cancel()
    {
        return view('cancel');
    }
}
