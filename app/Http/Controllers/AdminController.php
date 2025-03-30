<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rays;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\CarbonPeriod; // Import spécifique de CarbonPeriod

use App\Models\OrderItem;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\UserInteraction;
use App\Models\CouponDistribution;
use App\Models\UserBehavior;
use App\Models\Deal;
use App\Services\AiServiceClient;
class AdminController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:transaction', ['only' => ['transactions']]);
        $this->middleware('permission:order-list', ['only' => ['orderadmin']]);
        $this->middleware('permission:order-delete', ['only' => ['orderdelete']]);
        $this->middleware('permission:shippings', ['only' => ['create']]);
        $this->middleware('permission:sales-regression', ['only' => ['getSalesRegressionResults']]);
        $this->middleware('permission:products-statistics', ['only' => ['productStatistics']]);
        $this->middleware('permission:pridective-sales', ['only' => ['showForecast']]);
        $this->middleware('permission:dashboard', ['only' => ['dashboard']]);

        
         $this->middleware('permission:coupon-list|coupon-create|coupon-edit|coupon-delete', ['only' => ['indexcoupon']]);
         $this->middleware('permission:coupon-create', ['only' => ['createcoupon','storecoupon']]);
         $this->middleware('permission:coupon-edit', ['only' => ['editcoupon','uploadcoupon']]);
         $this->middleware('permission:coupon-delete', ['only' => ['deletecoupon']]);
    }

    
public function productStatistics()
{
    $productViews = DB::table('user_interactions')
        ->select('product_id', DB::raw('COUNT(DISTINCT id) as views'))
        ->where('action_type', '=', 'view')
        ->groupBy('product_id')
        ->get()
        ->keyBy('product_id'); 
    $productSales = DB::table('order_items')
        ->select('product_id', 
                 DB::raw('SUM(qty) as quantity_sold'),
                 DB::raw('COUNT(DISTINCT order_id) as total_orders'))
        ->groupBy('product_id')
        ->get()
        ->keyBy('product_id'); 
    $rankedProducts = DB::table('products')
        ->select('id', 'name', 'image')
        ->get()
        ->map(function ($product) use ($productViews, $productSales) {
            $product->views = $productViews->get($product->id)->views ?? 0;

            $salesData = $productSales->get($product->id);
            $product->quantity_sold = $salesData->quantity_sold ?? 0;
            $product->total_orders = $salesData->total_orders ?? 0;

            return $product;
        });

    $rankedProducts = $rankedProducts->sortByDesc('views');

    $rankedProducts = $rankedProducts->values()->map(function ($product, $index) {
        $product->rank = $index + 1;
        return $product;
    });

    return view('Back-end.product-statistics', compact('rankedProducts'));
}






public function getSalesRegressionResults()
{
    $pythonScriptPath = base_path('app/scripts/sales_analysis.py');

    // Verify Python script exists
    if (!file_exists($pythonScriptPath)) {
        Log::error("Python script not found at: $pythonScriptPath");
        return view('Back-end.sales_regression')->with('message', 'Analysis script not found');
    }

    // Execute Python script
    $command = escapeshellcmd("python $pythonScriptPath");
    $output = shell_exec($command . " 2>&1");

    Log::info('Python script output: ' . $output);

    if (!$output) {
        return view('Back-end.sales_regression')->with('message', 'No data returned from analysis');
    }

    $data = json_decode($output, true);

    // Handle JSON errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        Log::error('JSON decode error: ' . json_last_error_msg());
        return view('Back-end.sales_regression')->with('message', 'Data format error');
    }

    // Format date ranges for display
    foreach ($data['regression_results'] as &$result) {
        $result['last_month_range'] = [
            date('d/m/Y', strtotime($result['last_month_range'][0])),
            date('d/m/Y', strtotime($result['last_month_range'][1]))
        ];
        
        $result['previous_month_range'] = [
            date('d/m/Y', strtotime($result['previous_month_range'][0])),
            date('d/m/Y', strtotime($result['previous_month_range'][1]))
        ];
    }

    return view('Back-end.sales_regression', [
        'data' => $data['regression_results'],
        'summaries' => $data['summaries'] ?? 'No summary available'
    ]);
}

    public function showForecast()
    {
        $response = Http::get('http://127.0.0.1:8000/forecast');
        
        if ($response->successful()) {
            $forecastData = $response->json(); 
        } else {
            $forecastData = [];
        }
        
        return view('Back-end.analysepredictive', ['forecastData' => $forecastData]);
    }
    
    

    
    

    public function indexroute()
    {
        return view('Front-end.page-404');
    }
    public function indexchat()
    {
        $user=User::all();
        return view('vendor.Chatify.layouts.info', compact('user'));
    }
    public function user()
    {
        $user=User::all();

            return view('Back-end.users', compact('user'));

    }
    public function transactions(Request $request)
{
    // Récupérer le nombre d'éléments par page (par défaut : 20)
    $perPage = $request->input('per_page', 20);

    // Construire la requête avec jointure et pagination
    $orders = Order::select('orders.*', 'users.name as userName', 'users.id as userID')
        ->latest('id')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->paginate($perPage);

    // Retourner la vue avec les données paginées
    return view('Back-end.transactions', compact('orders'));
}
    public function getPaymentMethodData(Request $request)
    {
        try {
            $request->validate([
                'month' => 'sometimes|date_format:Y-m'
            ]);
    
            $month = $request->input('month') ?? now()->format('Y-m');
            $startDate = Carbon::parse($month)->startOfMonth();
            $endDate = Carbon::parse($month)->endOfMonth();
    
            // Récupération des données
            $data = Order::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_method = "paypal" THEN grand_total END), 0) as paypal'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_method = "card" THEN grand_total END), 0) as card'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_method = "cod" THEN grand_total END), 0) as cod')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    
            // Remplissage des jours manquants
            $results = [];
            $period = CarbonPeriod::create($startDate, $endDate);
    
            foreach ($period as $date) {
                $day = $date->format('Y-m-d');
                $record = $data->firstWhere('day', $day) ?? [
                    'day' => $day,
                    'paypal' => 0,
                    'card' => 0,
                    'cod' => 0
                ];
                $results[] = $record;
            }
    
            return response()->json($results);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } 
    public function getPaymentStatusData(Request $request)
    {
        $paymentStatusData = Order::select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();


        return response()->json($paymentStatusData);
    }
    public function getSegmentDistributionData()
{
    // Récupérer les données pour la charte circulaire
    $segmentDistribution = CouponDistribution::selectRaw('
            coupons.target_segment as segment,
            COUNT(DISTINCT coupon_distributions.id) as sent_count
        ')
        ->join('coupons', 'coupon_distributions.coupon_id', '=', 'coupons.id')
        ->groupBy('coupons.target_segment')
        ->get()
        ->map(function ($item) {
            return [
                'segment' => $item->segment,
                'sent_count' => $item->sent_count
            ];
        });

    return response()->json([
        'labels' => $segmentDistribution->pluck('segment'),
        'data' => $segmentDistribution->pluck('sent_count')
    ]);
}
    public function chartuser(Request $request, $selectedDate = null)
    {
        try {
            $date = $selectedDate ?: now()->format('Y-m');
            
            // Validation du format de date
            if (!preg_match('/^\d{4}-\d{2}$/', $date)) {
                throw new \InvalidArgumentException('Format de date invalide');
            }
    
            list($year, $month) = explode('-', $date);
    
            // Requêtes optimisées
            $orderData = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');
    
            $userData = User::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');
    
            // Génération des dates complètes
            $startDate = "{$year}-{$month}-01";
            $endDate = \Carbon\Carbon::parse($startDate)->endOfMonth()->format('Y-m-d');
    
            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            
            $combinedData = [];
            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $combinedData[] = [
                    'date' => $dateStr,
                    'orders' => $orderData->get($dateStr, 0),
                    'users' => $userData->get($dateStr, 0),
                ];
            }
    
            return response()->json($combinedData);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the provided current password matches the user's actual password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided current password does not match your actual password.'],
            ]);
        }

        // Update the user's password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return back()->with('success', 'Password changed successfully');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('images', 'public');
            $user->avatar = 'images/' . basename($avatarPath);
        }

          $user->save();

        return back()->with('success', 'Profile updated successfully');

    }

    public function setting()
    {
        $user=User::all();

        return view('Back-end.settings');

    }
    public function dashboard()
{
    // Fonction utilitaire pour calculer les pourcentages
    $calculatePercentage = function($active, $total) {
        return $total > 0 ? round(($active / $total) * 100, 2) : 0;
    };

    // Récupération des données principales
    $orders = Order::with('user:id,name,email')
    ->latest('id') // Order by the latest ID (descending order)
    ->take(20)     // Limit the results to 20
    ->get();       // Fetch the results
    $usersCount = User::count();
    $ordersCount = Order::count();
    $totalEarnings = Order::sum('subtotal');
    $productsCount = Product::count();
    $categoriesCount = Category::count();

    // Calculs pour le mois en cours
    $currentMonth = now()->format('Y-m');
    $currentMonthEarnings = Order::where('created_at', 'like', "{$currentMonth}%")
                               ->sum('subtotal');

    // Calcul des pourcentages d'activation
    $statusData = [
        'rays' => [
            'active' => Rays::where('status', 1)->count(),
            'total' => Rays::count(),
        ],
        'categories' => [
            'active' => Category::where('status', 1)->count(),
            'total' => Category::count(),
        ],
        'subcategories' => [
            'active' => SubCategory::where('status', 1)->count(),
            'total' => SubCategory::count(),
        ],
        'products' => [
            'active' => Product::where('status', 1)->count(),
            'total' => Product::count(),
        ],
        'brands' => [
            'active' => Brand::where('status', 1)->count(),
            'total' => Brand::count(),
        ],
    ];

    // Statistiques supplémentaires
    $viewsCount = UserInteraction::count();
    $soldProducts = OrderItem::sum('qty');
    
    $paymentMethods = [
        'paypal' => Order::where('payment_method', 'paypal')->count(),
        'card' => Order::where('payment_method', 'card')->count(),
    ];
    $totalTransactions = array_sum($paymentMethods);

    return view('Back-end.dashboard', [
        'orders' => $orders,
        'usersCount' => $usersCount,
        'ordersCount' => $ordersCount,
        'totalEarnings' => $totalEarnings,
        'productsCount' => $productsCount,
        'categoriesCount' => $categoriesCount,
        'currentMonthEarnings' => $currentMonthEarnings,
        'viewsCount' => $viewsCount,
        'soldProducts' => $soldProducts,
        'totalTransactions' => $totalTransactions,
        'statusData' => $statusData, // Données de statut structurées
    ]);
}
public function orderadmin(Request $request)
{
    // Retrieve request parameters
    $search = $request->input('search', '');
    $status = $request->input('status', null);
    $perPage = $request->input('per_page', 50);

    // Build the query
    $query = Order::select('orders.*', 'users.name as userName', 'users.email as userEmail')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id');

    // Apply search filter if specified
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('orders.id', 'like', '%' . $search . '%')
              ->orWhere('users.name', 'like', '%' . $search . '%')
              ->orWhere('users.email', 'like', '%' . $search . '%');
        });
    }

    // Apply status filter if specified
    if ($status && $status !== 'all') {
        $query->where('orders.status', $status);
    }

    // Add pagination
    $orders = $query->latest('id')->paginate($perPage);

    // Return the view with paginated data
    return view('Back-end.orderadmin', compact('orders'));
}
    public function orderDetails($orderID)
    {

        $order = Order::select('orders.*','users.name as userName','users.email as userEmail')
        ->where('orders.id', $orderID)
        ->latest('id')
        ->leftJoin('users','users.id','orders.user_id')
        ->first();

        $orderItem=OrderItem::where('order_id', $orderID)->get();
        return view('Back-end.order_details',['order'=>$order,'orderItem'=>$orderItem]);

    }


    public function update(Request $request, $orderId)
    {
      
            // Validate incoming data
            $validatedData = $request->validate([
                'status' => 'required|in:pending,shipped,delivered',
                'shipped_date' => 'nullable|date',
                'payment_status' => 'required|in:paid,not paid',
            ]);
    
            // Find the order
            $order = Order::with('orderItems.product')->findOrFail($orderId);
    
            // Update order details
            $order->status = $validatedData['status'];
            $order->payment_status = $validatedData['payment_status'];
            if (!empty($validatedData['shipped_date'])) {
                $order->shipped_date = $validatedData['shipped_date'];
            }
            $order->save();
    
            // Handle stock decrement if conditions are met
            if ($order->status === 'delivered' && $order->payment_status === 'paid') {
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
    
                    if ($product) {
                        Log::info("Processing Product ID: {$product->id}, Current Qty: {$product->quantity}, Ordered Qty: {$item->qty}");
    
                        // Adjust product quantity
                        $product->quantity = max(0, $product->quantity - $item->qty);
                        $product->save();
    
                        Log::info("Updated Product ID: {$product->id}, New Qty: {$product->quantity}");
                    } else {
                        Log::error("Missing Product for OrderItem ID: {$item->id}");
                    }
                }
            }
    
            // Return success response

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Order status and shipped_date updated successfully');
     
        
    }
    
    

    
    public function createcoupon()
    {
        return view('Back-end.coupon');
    }
    public function storecoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
            'segment' => 'required', // Added validation for segment
            'points' => 'required|numeric', // Added validation for points
            'max_uses' => 'required',
            'max_uses_user' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'min_amount' => 'required',
            'status' => 'required',
            'starts_at' => 'required|date|after_or_equal:now',
            'expires_at' => 'required|date|after:starts_at',
        ], [
            'starts_at.required' => 'The Start Date field is required.',
            'starts_at.date' => 'The Start Date must be a valid date and time.',
            'starts_at.after_or_equal' => 'Start date cannot be less than the current date time.',
            'expires_at.required' => 'The Expiry Date field is required.',
            'expires_at.date' => 'The Expiry Date must be a valid date and time.',
            'expires_at.after' => 'Expiry date must be after the Start Date.',
        ]);
    
        if ($validator->passes()) {
            $coupon = new Coupon;
            $coupon->code = $request->code;
            $coupon->name = $request->name;
            $coupon->segment = $request->segment; // Save segment
            $coupon->points = $request->points; // Save points
            $coupon->max_uses = $request->max_uses;
            $coupon->max_uses_user = $request->max_uses_user;
            $coupon->type = $request->type;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->min_amount = $request->min_amount;
            $coupon->status = $request->status;
            $coupon->starts_at = $request->starts_at;
            $coupon->expires_at = $request->expires_at;
            $coupon->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon added successfully '
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function indexcoupon()
    {

         $coupon=Coupon::all();
         return view('Back-end.list_coupon',compact('coupon'));

    }
    public function deletecoupon()
    {

    }

    public function index()
    {
        // Métriques globales
        $globalMetrics = [
            'sent_count' => CouponDistribution::count(),
            'used_count' => CouponDistribution::whereNotNull('used_at')->count(),
            'conversion_rate' => CouponDistribution::conversionRate(),
            'total_revenue' => CouponDistribution::sum('revenue_impact'),
            'avg_revenue_per_coupon' => CouponDistribution::average('revenue_impact'),
            'avg_engagement' => UserBehavior::average('engagement_score'),
            'avg_confidence' => CouponDistribution::average('confidence')
        ];
    
        // Performance par segment (requête optimisée)
        $segmentPerformance = CouponDistribution::selectRaw('
                coupons.target_segment as segment,
                COUNT(DISTINCT coupon_distributions.id) as sent_count,
                SUM(IF(coupon_distributions.used_at IS NOT NULL, 1, 0)) as used_count,
                AVG(user_behaviors.engagement_score) as avg_engagement,
                AVG(coupon_distributions.confidence) as avg_confidence,
                IFNULL(SUM(coupon_distributions.revenue_impact), 0) as total_revenue
            ')
            ->join('coupons', 'coupon_distributions.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupon_distributions.user_id', '=', 'users.id')
            ->join('user_behaviors', 'users.id', '=', 'user_behaviors.user_id')
            ->groupBy('coupons.target_segment')
            ->get()
            ->map(function ($item) {
                $item->conversion_rate = $item->sent_count 
                    ? ($item->used_count / $item->sent_count * 100)
                    : 0;
                return $item;
            });
    
        // Tendance d'utilisation
        $usageTrend = CouponDistribution::whereNotNull('used_at')
            ->selectRaw('DATE(used_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');
    
        // Données détaillées des coupons (requête optimisée)
        $coupons = Coupon::withCount([
                'distributions as sent_count',
                'distributions as used_count' => fn($q) => $q->whereNotNull('used_at')
            ])
            ->withAvg('distributions', 'confidence')
            ->withSum(['distributions' => function($query) {
                $query->whereNotNull('used_at');
            }], 'revenue_impact')
            ->addSelect([
                'avg_redemption_time' => CouponDistribution::selectRaw('AVG(TIMESTAMPDIFF(DAY, sent_at, used_at))')
                    ->whereColumn('coupon_id', 'coupons.id')
                    ->whereNotNull('used_at'),
                'avg_engagement' => UserBehavior::selectRaw('AVG(engagement_score)')
                    ->whereIn('user_id', 
                        CouponDistribution::select('user_id')
                            ->whereColumn('coupon_id', 'coupons.id')
                    )
            ])
            ->get()
            ->each(function ($coupon) {
                $coupon->conversion_rate = $coupon->sent_count 
                    ? ($coupon->used_count / $coupon->sent_count * 100)
                    : 0;
                $coupon->status_label = $coupon->status ? 'Actif' : 'Inactif';
                $coupon->status_class = $coupon->status ? 'success' : 'secondary';
            });
    
        return view('Back-end.index', compact(
            'globalMetrics',
            'segmentPerformance',
            'usageTrend',
            'coupons'
        ));
    }
    public function deleteorder()
    {

    }
    public function create(Request $request)
{
    // Retrieve request parameters
    $perPage = $request->input('per_page', 10); // Default: 10 items per page
    $countryId = $request->input('country', 'all'); // Default: All countries

    // Base query with join
    $query = Shipping::select('shippings.*', 'countries.name as countryName')
        ->leftJoin('countries', 'countries.id', '=', 'shippings.country_id');

    // Apply country filter if specified
    if ($countryId !== 'all') {
        $query->where('shippings.country_id', $countryId);
    }

    // Paginate results
    $shipping = $query->latest('shippings.id')->paginate($perPage);

    // Fetch all countries for the filter dropdown
    $countries = Country::all();

    // Return the view with paginated data and filters
    return view('Back-end.shipping', compact('shipping', 'countries'));
}
public function store(Request $request)
{
    // Validate incoming data
    $validator = Validator::make($request->all(), [
        'country' => 'required|exists:countries,id',
        'amount' => 'required|numeric|min:0',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    // Create a new shipping record
    $shipping = new Shipping();
    $shipping->country_id = $request->input('country');
    $shipping->amount = $request->input('amount');
    $shipping->save();

    // Return success response
    return response()->json([
        'status' => true,
        'message' => 'Shipping cost added successfully.',
    ]);
}
    public function delete($id)
    {
        Shipping::find($id)->delete();
        return back();
    }


}
