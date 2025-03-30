<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Session ;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Coupon;
use App\Services\{CouponDistributionService, SmsService};
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart; // Import the shopping cart facade
use Illuminate\Support\Facades\Auth;
use App\Models\UserBehavior;
class CartController extends Controller
{

    public function applyDiscount(Request $request)
    {
        $code = Coupon::where('code', $request->code)->first();

        if ($code == null) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid discount coupon',
            ]);
        }
        $couponUsed = Order::where('coupon_code_id', $code->id)->count();

        if($couponUsed>= $code->max_uses)
         {

             return response()->json([
                 'status' => false,
                 'message' => 'Coupon has been used as maximum',
             ]);
         }


         $couponUsedByUser = Order::where(['coupon_code_id'=> $code->id ,'user_id'=>Auth::user()->id])->count();
         if($couponUsedByUser>= $code->max_uses_user)
         {
             return response()->json([
                 'status' => false,
                 'message' => 'You already used this coupon',
             ]);
         }
         $cart = Session::get('cart', []);

         $total = 0;

         foreach ($cart as $item) {
             $total += $item['sale_price'] * $item['quantity'];
         }
         if($total< $code->min_amount)
         {
             return response()->json([
                 'status' => false,
                 'message' => 'Your min amount must be $'.$code->min_amount.'.',
             ]);
         }


        session()->put('code', $code);

        // Get the shipping charge based on the selected country
        $shippingCharge = $this->calculateShippingCharge($request);

        // Calculate the updated grand total with the discount
        $grandTotal = $this->calculateGrandTotal($request, $shippingCharge);

        return response()->json([
            'status' => true,
            'discount' => $code->discount_amount,
            'grandTotal' => $grandTotal,
            'shippingCharge' => $shippingCharge,
        ]);
    }

    private function calculateShippingCharge(Request $request)
    {
        $totalqty = 0;
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['sale_price'] * $item['quantity'];
            $totalqty += $item['quantity'];
        }

        $shippingInfo = Shipping::where('country_id', $request->country_id)->first();

        if ($shippingInfo != null) {
            return $totalqty * $shippingInfo->amount;
        } else {
            return 0;
        }
    }

    private function calculateGrandTotal(Request $request, $shippingCharge)
    {
        $discount = 0; // Initialize $discount

        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $shippingCharge;
            } else {
                $discount = $code->discount_amount;
            }
        }

        $total = $shippingCharge + $discount;

        return $total;
    }
    public function removeDiscount(Request $request)
    {
        session()->forget('code');
        $response = $this->getOrder($request); // Recalculate order details including shipping charge

        // Include the updated shipping charge in the response

        return response()->json($response);
    }



    public function getOrder(Request $request)
    {
        $totalqty = 0;
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['sale_price'] * $item['quantity'];
            $totalqty += $item['quantity'];
        }

        $shippingInfo = Shipping::where('country_id', $request->country_id)->first();

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
        }

        $grandTotal = $total + $shippingCharge - $discount;

        return response()->json([
            'status' => true,
            'discount' => $discount,
            'grandTotal' => $grandTotal,
            'shippingCharge' => $shippingCharge,
        ]);
    }




    public function checkout()
    {
        $firas = Country::orderBy('name', 'ASC')->get();
        $cart = Session::get('cart', []);
        $customerAddress = CustomerAddress::where( 'user_id', Auth::user()->id)->first();

        return view('Front-end.checkout', compact('cart','firas','customerAddress'));

    }

    public function processCheckout(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'adresse' => 'required',
            'adresse2' => 'required',
            'phone' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'payment_method' => 'required|string|max:50' // Ajouté
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    
      // Sauvegarde de l'adresse utilisateur
$user = Auth::user();
$user = Auth::user();
$user->update([
    'phone' => $request->phone,
    'age' => 30
]);

CustomerAddress::updateOrCreate(
    ['user_id' => $user->id],
    [
        'adresse' => $request->adresse,
        'adresse2' => $request->adresse2,
        'phone' => $request->phone, // Stockage dans l'adresse
        'zip' => $request->zip,
        'country_id' => $request->country,
    ]
);
    
        // Calcul du total du panier
        $cart = Session::get('cart', []);
        $total = 0;
        $totalQty = 0;
    
        foreach ($cart as $productId => $item) {
            $total += $item['sale_price'] * $item['quantity'];
            $totalQty += $item['quantity'];
        }
    
        // Calcul des frais de livraison
        $shippingInfo = Shipping::where('country_id', $request->country)->first();
        $shippingCharge = $shippingInfo ? $totalQty * $shippingInfo->amount : 0;
    
        // Application des réductions
        $discount = 0;
        $discountCodeId = null;
        $promoCode = '';
    
        if (session()->has('code')) {
            $code = session()->get('code');
    
            // Utilisation des méthodes publiques pour accéder aux propriétés
            $discount = $code->type === 'percent'
                ? ($total * $code->discount_amount / 100)
                : $code->discount_amount;
    
            $discountCodeId = $code->getId(); // Utilisation de getId()
            $promoCode = $code->getCode();    // Utilisation de getCode()
        }
    
        // Création de la commande
        $order = new Order;
        $order->subtotal = $total;
        $order->shipping = $shippingCharge;
        $order->discount = $discount;
        $order->grand_total = $total + $shippingCharge - $discount;
        $order->coupon_code = $promoCode;
        $order->coupon_code_id = $discountCodeId;
        $order->user_id = $user->id;
        $order->country_id = $request->country;
        $order->adresse = $request->adresse;
        $order->adresse2 = $request->adresse2;
        $order->phone = $request->phone;
        $order->zip = $request->zip;
        $order->payment_method = $request->payment_method; // Champ requis
        $order->payment_status = 'not paid';
        $order->status = 'pending';
        $order->save();
    
        // Création des articles de commande
        foreach ($cart as $productId => $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $productId;
            $orderItem->name = $item['name'];
            $orderItem->qty = $item['quantity'];
            $orderItem->price = $item['sale_price'];
            $orderItem->total = $item['sale_price'] * $item['quantity'];
            $orderItem->save();
        }
    
        // Mise à jour des statistiques utilisateur
        $user->update([
            'purchase_frequency' => $user->purchase_frequency + 1,
            'loyalty_points' => $user->loyalty_points + ($order->grand_total / 10),
            'avg_spending' => (
                ($user->avg_spending * $user->purchase_frequency) + 
                $order->grand_total
            ) / ($user->purchase_frequency + 1),
            'segment' => $this->calculateSegment($user) // Mise à jour du segment
        ]);
    
        // Enregistrement du comportement utilisateur
        UserBehavior::updateOrCreate(
            ['user_id' => $user->id],
            [
                'engagement_score' => $this->calculateEngagementScore($user, count($cart)),
                'preferences' => $this->getProductCategories($cart),
                'interaction_history' => [
                    'last_purchase' => now()->toIso8601String(),
                    'order_id' => $order->id,
                    'items_count' => count($cart)
                ]
            ]
        );
    
        // Distribution des coupons
        (new CouponDistributionService(new SmsService()))
            ->distributeCouponsForUser($user, $order->grand_total);
    
        // Nettoyage de la session
        session()->forget(['cart', 'code']);
    
        return response()->json([
            'message' => 'Order saved successfully',
            'status' => true,
            'orderId' => $order->id,
        ]);
    }
    
    // Fonctions helper
    private function calculateEngagementScore(User $user, int $cartItemsCount): float
    {
        return ($user->purchase_frequency * 0.7) + ($cartItemsCount * 0.3);
    }
    
    private function getProductCategories(array $cart): array
    {
        return array_unique(
            array_map(
                fn($productId) => Product::find($productId)->category_id, 
                array_keys($cart)
            )
        );
    }
    
    // Nouvelle méthode pour calculer le segment
    private function calculateSegment(User $user): string
    {
        $segments = Coupon::query()
            ->active()
            ->select('target_segment')
            ->selectRaw('MIN(points_required) as min_points')
            ->groupBy('target_segment')
            ->orderByDesc('min_points')
            ->get();
    
        foreach ($segments as $segment) {
            if ($user->loyalty_points >= $segment->min_points) {
                return $segment->target_segment;
            }
        }
    
        return 'regular'; // Segment par défaut
    }





public function thankyou()
{
    return view('Front-end.thankyou');

}

    public function removeFromCart($productId)
    {
        Cart::remove($productId);
        return back();
    }



    public function index()
    {
        $cartItems = Cart::content(); // Get cart items
        return view('Front-end.shop-cart', compact('cartItems'));
    }


}
