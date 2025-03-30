<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Rays;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     public function index(Request $request)
     {
         // Récupérer les paramètres de la requête
         $perPage = $request->input('per_page', 10); // Nombre d'éléments par page (par défaut : 10)
         $category_id = $request->input('category', 'all'); // Filtre par catégorie (par défaut : "all")
         $subcategory_id = $request->input('subcategory', 'all'); // Filtre par sous-catégorie (par défaut : "all")
         $brand_id = $request->input('brand', 'all'); // Filtre par marque (par défaut : "all")
         $statusLabel = $request->input('status', 'all'); // Filtre par statut (par défaut : "all")
     
         // Mapping des libellés de statut vers les valeurs numériques
         $statusMapping = [
             'all' => null,
             'Active' => 1,
             'Inactive' => 0,
         ];
     
         $statusValue = $statusMapping[$statusLabel] ?? null;
     
         // Requête principale avec jointures entre products, categories, sub_categories, brands, rays et users
         $query = Product::select(
             'products.*',
             'rays.name as rayName',
             'categories.name as categoryName',
             'sub_categories.name as subcategoryName',
             'brands.name as brandName',
             'users.name as userName'
         )
             ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
             ->leftJoin('rays', 'rays.id', '=', 'products.ray_id')
             ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
             ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
             ->leftJoin('users', 'users.id', '=', 'products.user_id');
     
         // Ajouter le filtre par statut si spécifié
         if ($statusValue !== null) {
             $query->where('products.status', $statusValue);
         }
     
         // Ajouter le filtre par catégorie si spécifié
         if ($category_id !== 'all') {
             $query->where('products.category_id', $category_id);
         }
     
         // Ajouter le filtre par sous-catégorie si spécifié
         if ($subcategory_id !== 'all') {
             $query->where('products.sub_category_id', $subcategory_id);
         }
     
         // Ajouter le filtre par marque si spécifié
         if ($brand_id !== 'all') {
             $query->where('products.brand_id', $brand_id);
         }
     
         // Paginer les résultats
         $products = $query->latest('products.id')->paginate($perPage);
     
         // Récupérer toutes les catégories, sous-catégories et marques pour les filtres
         $categories = Category::all();
         $subcategories = SubCategory::all();
         $brands = Brand::all();
     
         // Retourner la vue avec les données paginées et les filtres actuels
         return view('Back-end.product-list', compact('products', 'categories', 'subcategories', 'brands', 'statusLabel'));
     }
    public function create()
    {
        $data= [];
        $subcategory= SubCategory::orderBy('name','ASC')->get();
        $categories= Category::orderBy('name','ASC')->get();
        $brands= Brand::orderBy('name','ASC')->get();

        $rays = Rays::with('categories.subCategories')->get();


        $data['categories']=$categories ;
        $data['brands']=$brands;
        $data['rays']=$rays;
        $data['subcategories']=$subcategory;
        return view('Back-end.create',$data);
    }


    public function reject(Product $product)
    {
        $product->update(['is_approved' => 0]);
        // You can also send notifications to the customer here
        return redirect()->route('product_list')->with('success', 'Product rejected successfully.');
    }


    public function approve(Product $product)
    {
        $product->update(['is_approved' => 1]);
        // You can also send notifications to the customer here
        return redirect()->route('product_list')->with('success', 'Product approved successfully.');
    }


    public function accept($id)
    {
        // Retrieve the product along with the creator's name
        $product = Product::select('products.*', 'users.name as userName')
            ->leftJoin('users', 'users.id', '=', 'products.user_id') // Join to fetch the user
            ->where('products.id', $id) // Filter by product ID
            ->first(); // Retrieve a single product record
    
        // Fetch additional data for the view
        $subcategory = SubCategory::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $rays = Rays::with('categories.subCategories')->get();
    
        // Prepare data for the view
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'rays' => $rays,
            'subcategories' => $subcategory,
        ];
    
        return view('Back-end.acceptproduct', compact('product', 'data'));
    }
    
    public function store(Request $request)
{
    $user = Auth::user();

    $valid = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'short_description' => 'required|string|max:500',
        'regular_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'sale_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'quantity' => 'required',
        'image' => 'required|array', // Change 'image' to an array
        'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp', // Validate each image in the array
        'slug' => 'required|unique:products',
        'sku' => 'required|string|max:255',
    ]);

    $product = new Product([
        'short_description' => $request->get('short_description'),
        'description' => $request->get('description'),
        'regular_price' => $request->get('regular_price'),
        'sale_price' => $request->get('sale_price'),
        'quantity' => $request->get('quantity'),
        'name' => $request->get('name'),
        'sku' => $request->get('sku'),
        'slug' => $request->get('slug'),
        'status' => $request->get('status'),
        'is_featured' => $request->get('is_featured'),
        'category_id' => $request->get('category'),
        'brand_id' => $request->input('brand'), // Keep 'brand_id' as it is
        'ray_id' => $request->get('rays'),
        'sub_category_id' => $request->get('subcategory'),
    ]);

    $hasBrand = $request->has('has_brand'); // Keep 'hasBrand' as it is
    $brandId = $hasBrand ? $request->input('brand') : null;
    $product->brand_id = $brandId;

    if (auth()->user()->hasRole('admin')) {
        $product['is_approved'] = $request->get('is_approved', 1); // Approved by default for admin users
    } else {
        $product['is_approved'] = 2; // Set it to 0 for non-admin users
    }

    $product->user_id = $user->id;
    $product->save();
// ... Your code to save the product data ...

// Process and associate images
if ($request->hasFile('image')) {
    $productImages = [];

    foreach ($request->file('image') as $image) {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('images', $imageName, 'public');
        $productImages[] = ['image' => $imageName];
    }

    // Save the first image in the 'image' column of the 'products' table
    $product->image = $productImages[0]['image'];
    $product->save();

    // Save the rest of the images in the 'product_images' table
    $product->images()->createMany($productImages);
}

    return redirect()->route('product_list')
        ->with('success', 'Product created successfully.');
}


    public function edit($id)
    {
        $data= [];
        $subcategory= SubCategory::orderBy('name','ASC')->get();
        $categories= Category::orderBy('name','ASC')->get();
        $brands= Brand::orderBy('name','ASC')->get();

        $rays = Rays::with('categories.subCategories')->get();


        $data['categories']=$categories ;
        $data['brands']=$brands;
        $data['rays']=$rays;
        $data['subcategories']=$subcategory;

        $product = Product::find($id);
        return view('Back-end.edit',compact('product','data'));
    }
    public function update(Request $request, $id)
{
    $user = Auth::user();

    $valid = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'short_description' => 'required|string|max:500',
        'regular_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'sale_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'quantity' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image update
        'slug' => 'required|unique:products,slug,' . $id, // Unique except for the current product
        'sku' => 'required|string|max:255',
    ]);

    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('product_list')
            ->with('error', 'Product not found.');
    }

    $product->name = $request->get('name');
    $product->short_description = $request->get('short_description');
    $product->description = $request->get('description');
    $product->regular_price = $request->get('regular_price');
    $product->sale_price = $request->get('sale_price');
    $product->quantity = $request->get('quantity');
    $product->slug = $request->get('slug');
    $product->sku = $request->get('sku');
    $product->status = $request->get('status');
    $product->is_featured = $request->get('is_featured');
    $product->category_id = $request->get('category');
    $product->ray_id = $request->get('rays');
    $product->sub_category_id = $request->get('subcategory');

    // Check if an image file is uploaded and update it
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('images', $imageName, 'public');
        $product->image = $imageName;
    }

    // Update brand ID based on the "has_brand" checkbox and selected brand
    $hasBrand = $request->has('has_brand');
    $brandId = $hasBrand ? $request->input('brand') : $product->brand_id;
    $product->brand_id = $brandId;

    // Only allow non-admin users to request product approval

    $product->save();

    return redirect()->route('product_list')
        ->with('success', 'Product updated successfully.');
}

        public function delete($id)
    {
        Product::find($id)->delete();
  return back();
    }


    public function getCategories($rayId)
    {
        // Fetch categories based on the selected ray
        $categories = Category::where('ray_id', $rayId)->get();

        return response()->json(['categories' => $categories]);
    }

    public function getSubcategories($categoryId)
    {
        // Fetch subcategories based on the selected category
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        return response()->json(['subcategories' => $subcategories]);
    }


}
