<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rays;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deal;
use App\Models\Brand;
use App\Events\ProductClicked;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache; // Ajoutez cette ligne

use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class HomeController extends Controller
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
    public function search(Request $request)
    {
        $query = strtolower(trim($request->input('query')));
    
        if (empty($query)) {
            return response()->json(['message' => 'Veuillez entrer un terme de recherche.']);
        }
    
        // Récupérer les produits de la base de données
        $products = Product::all();
        $filteredProducts = [];
    
        // Normaliser la requête (supprimer les répétitions de lettres)
        $normalizedQuery = preg_replace('/(.)\\1+/', '$1', $query);
    
        foreach ($products as $product) {
            $productName = strtolower($product->name);
    
            // Normaliser le nom du produit
            $normalizedName = preg_replace('/(.)\\1+/', '$1', $productName);
    
            // Correspondance stricte par inclusion
            if (strpos($productName, $query) !== false || strpos($normalizedName, $normalizedQuery) !== false) {
                $filteredProducts[] = $product;
                continue;
            }
    
            // Correspondance phonétique (Soundex)
            if (soundex($query) == soundex($productName)) {
                $filteredProducts[] = $product;
                continue;
            }
    
            // Correspondance avec une tolérance de faute de frappe (Levenshtein)
            if (levenshtein($query, $productName) <= 2 || levenshtein($normalizedQuery, $normalizedName) <= 2) {
                $filteredProducts[] = $product;
            }
        }
    
            // Retourner les produits trouvés ou un message d'erreur
        if (empty($filteredProducts)) {
            return response()->json(['message' => 'Aucun produit trouvé']);
        }
       
        
    
        return response()->json($filteredProducts);
    }
    public function index()
{
    $now = Carbon::now()->setTimezone('Africa/Tunis');
    
    // Optimisation des requêtes avec eager loading et sélection de colonnes
    $products = Product::where('status', 1)
        ->where('is_approved', 1)
        ->with(['images', 'ray' => fn($q) => $q->select('id', 'name', 'slug'), 
               'category' => fn($q) => $q->select('id', 'name'), 
               'subCategory' => fn($q) => $q->select('id', 'name'), 
               'brand' => fn($q) => $q->select('id', 'name')])
        ->take(15)
        ->get(['id', 'name', 'description', 'sale_price', 'quantity', 'short_description']);

    // Cache des données fréquemment utilisées
    $rays = Cache::remember('rays_data', 3600, function() {
        return Rays::with(['categories.subCategories' => fn($q) => $q->select('id', 'name', 'slug', 'image', 'category_id')])
            ->get(['id', 'name', 'slug']);
    });
    $categories = Cache::remember('categories_data', 3600, function() {
        return Category::with(['subCategories' => fn($q) => $q->select('id', 'name', 'slug', 'image', 'category_id')])
            ->get(['id', 'name']);
    });
    $featured = Product::where('is_featured', 'YES')
    ->where('status', 1)
    ->where('is_approved', 1)
    ->with(['images'])
    ->take(6)
    ->get(['id', 'name', 'sale_price', 'quantity', 'description', 'short_description']);

    $topSelling = Product::where('status', 1)
    ->where('is_approved', 1)
    ->with(['images', 'orderItems']) // Charger la relation
    ->withSum('orderItems as total_sold', 'qty')
    ->orderByDesc('total_sold')
    ->take(6)
    ->get();
$newProducts = Product::where('status', 1)
    ->where('is_approved', 1)
    ->latest()
    ->with(['images'])
    ->take(6)
    ->get(['id', 'name', 'sale_price', 'quantity', 'description', 'short_description']);

    $lasts = Product::latest()
        ->where('status', 1)
        ->take(3)
        ->get(['id', 'name', 'sale_price', 'quantity']);

    $activeDeal = Deal::where('ends_at', '>', $now)
        ->with(['product' => fn($q) => $q->with(['images'])])
        ->get();

        return view('Front-end.home', compact('activeDeal', 'rays', 'featured', 'topSelling', 'newProducts', 'categories','products'));
    }
    

     public function branddetail()
     {
        $brand=Brand::with('products')->where('status',1)->take(20)->get();

        return view('Front-end.branddetail',compact('brand'));

     }







     public function brands()
     {
        $brand=Brand::with('products')->where('status',1)->take(20)->get();

        return view('Front-end.brands',compact('brand'));

     }

     public function getActiveDeal($productId)
     {
         // Find the product by ID
         $product = Product::find($productId);

         if (!$product) {
             return response()->json(['message' => 'Product not found'], 404);
         }

         // Get the active deal for the product
         $activeDeal = $product->activeDeal;

         if ($activeDeal) {
             // Do something with the active deal
             return response()->json(['activeDeal' => $activeDeal]);
         } else {
             return response()->json(['message' => 'No active deal found for this product']);
         }

         // Pass $activeDeal to the view (if needed)
     }



   
}
