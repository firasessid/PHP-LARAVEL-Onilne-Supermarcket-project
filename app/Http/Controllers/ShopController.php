<?php

namespace App\Http\Controllers;
use App\Models\Rays;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Session ;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Shipping;
use App\Models\Deal;
use Carbon\Carbon;
use App\Events\ProductClicked;
use Illuminate\Support\Facades\DB;

use App\Models\UserInteraction;
use Illuminate\Support\Facades\Auth;
use Rubix\ML\Clusterers\KMeans;
use Rubix\ML\Datasets\Unlabeled;
use App\Utils\MinMaxScaler;
use App\Models\User;
class ShopController extends Controller
{

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function filterProducts(Request $request)
     {
         $minPrice = $request->input('minPrice');
         $maxPrice = $request->input('maxPrice');

         // Query your products table to filter by price range
         $filteredProducts = Product::whereBetween('sale_price', [$minPrice, $maxPrice])->get();

         return response()->json($filteredProducts);
     }


     public function fetchProductImages($productId)
     {
         $product = Product::find($productId);
         return response()->json([
             'product' => $product,
             'images' => $product->images->take(2),
         ]);
     }



     public function cart()
     {

         $cart = Session::get('cart', []);
         return view('Front-end.shop-cart', compact('cart'));

     }

     public function addToCart($id)
     {
         $product = Product::findOrFail($id);
         $deal = Deal::where('product_id', $id)->first(); // Find the deal for the given product

         $cart = session()->get('cart', []);

         if (isset($cart[$id])) {
             $cart[$id]['quantity']++;
         } else {
             $cart[$id] = [
                 "name" => $product->name,
                 "image" => $product->image,
                 "sale_price" => $product->sale_price,
                 "quantity" => 1
             ];

             // Check if there's a deal for this product and set the price accordingly
             if ($deal) {
                 $cart[$id]['sale_price'] = $product->sale_price - $deal->discount_percentage;
             }
         }
         event(new ProductClicked($product->id));

         session()->put('cart', $cart);
         return back();
     }

     public function update(Request $request)
     {
         if($request->id && $request->quantity){
             $cart = session()->get('cart');
             $cart[$request->id]["quantity"] = $request->quantity;
             session()->put('cart', $cart);
         }
     }

     public function remove(Request $request)
     {
         if($request->id) {
             $cart = session()->get('cart');
             if(isset($cart[$request->id])) {
                 unset($cart[$request->id]);
                 session()->put('cart', $cart);
             }
         }
     }public function index(Request $request, $raySlug = null, $categorySlug = null, $subCategorySlug = null)
     {
         // Initialize variables
         $ray = null;
         $category = null;
         $subCategory = null;
     
         // Base product query
         $products = Product::where('status', 1)->where('is_approved', 1)
             ->with(['ray', 'category', 'subCategory', 'brand']);
     
         // Filter by Ray if slug is provided
         if ($raySlug) {
             $ray = Rays::with(['categories.subCategories.products'])->where('slug', $raySlug)->first();
             if (!$ray) abort(404); // Return 404 if ray doesn't exist
             $products = $products->where('ray_id', $ray->id);
         }
     
         // Filter by Category if slug is provided
         if ($categorySlug) {
             $category = Category::with('subCategories.products')->where('slug', $categorySlug)->first();
             if (!$category) abort(404); // Return 404 if category doesn't exist
             $products = $products->where('category_id', $category->id);
         }
     
         // Filter by Subcategory if slug is provided
         if ($subCategorySlug) {
             $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
             if (!$subCategory) abort(404); // Return 404 if subcategory doesn't exist
             $products = $products->where('sub_category_id', $subCategory->id);
         }
     
         // Filter by Brands if selected
         if ($request->has('brands') && !empty($request->brands)) {
             $brandIds = explode(',', $request->brands);
             $products = $products->whereIn('brand_id', $brandIds);
         }
     
         // Apply sorting
         $sort = $request->input('sort', 'featured'); // Default: 'featured'
         switch ($sort) {
             case 'low-to-high':
                 $products = $products->orderBy('sale_price', 'ASC');
                 break;
             case 'high-to-low':
                 $products = $products->orderBy('sale_price', 'DESC');
                 break;
             case 'featured':
                 $products = $products->where('is_featured', 'YES');
                 break;
             default:
                 $products = $products->orderBy('id', 'DESC');
                 break;
         }
     
         // Paginate results
         $perPage = $request->input('per_page', 50); // Default: 50 items per page
         $products = $products->paginate($perPage);
     
         // Load other necessary data
         $rays = Rays::all();
         $brands = Brand::all();
         $now = Carbon::now()->setTimezone('Africa/Tunis');
         $activeDeal = Deal::where('ends_at', '>', $now)->get();
     
         // Return view with data
         return view('Front-end.shop', compact('activeDeal', 'rays', 'products', 'ray', 'category', 'subCategory', 'brands', 'sort', 'perPage'));
     }
  
     public function productview($id)
{
    // Récupérer les détails du produit
    $product = Product::findOrFail($id);
    $ray = Rays::find($product->ray_id);
    $category = Category::find($product->category_id);
    $brand = Brand::find($product->brand_id);
    $subcategory = SubCategory::find($product->sub_category_id);

    // Récupérer les deals liés au produit
    $deal = Deal::where('product_id', $id)->first();
    $activeDeal = Deal::where('ends_at', '>', now())->get();

    // Enregistrer l'interaction utilisateur (événement)
    event(new ProductClicked($product->id));

    // Initialiser les produits recommandés
    $recommendedProducts = collect([]);

    if (Auth::check()) {
        $user = Auth::user();

        // Récupérer toutes les interactions utilisateur-produit avec interaction_score
        $interactions = DB::table('user_interactions')
            ->select('user_id', 'product_id', 'interaction_score')
            ->get()
            ->toArray();

        // Créer un fichier temporaire pour les interactions
        $tempFile = tempnam(sys_get_temp_dir(), 'interactions_');
        file_put_contents($tempFile, json_encode($interactions));

        // Chemin vers le script Python
        $scriptPath = base_path('app/scripts/recommend.py');

        // Exécuter le script Python
        $command = "python " . escapeshellarg($scriptPath) . " {$user->id} " . escapeshellarg($tempFile);
        $output = shell_exec($command);

        // Supprimer le fichier temporaire
        unlink($tempFile);

        // Convertir la sortie JSON en tableau
        $recommendedIds = json_decode($output, true);

        // Récupérer les produits recommandés
        if (is_array($recommendedIds) && count($recommendedIds) > 0) {
            $recommendedProducts = Product::whereIn('id', $recommendedIds)->where('quantity', '>', 0)->get();
        }

        // Si aucune recommandation, afficher des produits alternatifs
        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = Product::where('quantity', '>', 0)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
    }

    return view('Front-end.productview', compact(
        'deal',
        'subcategory',
        'brand',
        'category',
        'ray',
        'product',
        'recommendedProducts',
        'activeDeal'
    ));
}    
 
     
 
  
   
}
