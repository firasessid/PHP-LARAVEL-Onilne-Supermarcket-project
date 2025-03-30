<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Rays;
use App\Models\Category;

use Illuminate\Http\Request;

class SubCategorieController extends Controller
{


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index']]);
         $this->middleware('permission:subcategory-create', ['only' => ['create','store']]);
         $this->middleware('permission:subcategory-edit', ['only' => ['edit','upload']]);
         $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }



    public function index(Request $request)
    {
        // Récupérer les paramètres de la requête
        $perPage = $request->input('per_page', 10); // Nombre d'éléments par page (par défaut : 10)
        $statusLabel = $request->input('status', 'all'); // Filtre par statut (par défaut : "all")
        $categoryId = $request->input('category', 'all'); // Filtre par catégorie (par défaut : "all")
        $rayId = $request->input('ray', 'all'); // Filtre par rayon (par défaut : "all")
    
        // Mapping des libellés de statut vers les valeurs numériques
        $statusMapping = [
            'all' => null,
            'Active' => 1,
            'Inactive' => 0,
        ];
    
        $statusValue = $statusMapping[$statusLabel] ?? null;
    
        // Requête principale avec jointures entre sub_categories, categories et rays
        $query = SubCategory::select(
            'sub_categories.*',
            'categories.name as categoryName',
            'rays.name as rayName'
        )
            ->leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->leftJoin('rays', 'rays.id', '=', 'categories.ray_id');
    
        // Ajouter le filtre par statut si spécifié
        if ($statusValue !== null) {
            $query->where('sub_categories.status', $statusValue);
        }
    
        // Ajouter le filtre par catégorie si spécifié
        if ($categoryId !== 'all') {
            $query->where('sub_categories.category_id', $categoryId);
        }
    
        // Ajouter le filtre par rayon si spécifié
        if ($rayId !== 'all') {
            $query->where('categories.ray_id', $rayId);
        }
    
        // Paginer les résultats
        $subcategories = $query->latest('sub_categories.id')->paginate($perPage);
    
        // Récupérer toutes les catégories et tous les rays pour les filtres
        $categories = Category::all();
        $rays = Rays::all();
    
        // Retourner la vue avec les données paginées et les filtres actuels
        return view('Back-end.subcategorie_list', compact('subcategories', 'categories', 'rays', 'statusLabel', 'categoryId', 'rayId'));
    }
    public function create()
    {
        $category= Category::orderBy('name','ASC')->get();

        return view('Back-end.create_subcategorie',compact('category'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'category'=>'required|numeric',


        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('images', $imageName, 'public');

        $subcategory = new SubCategory([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'status' => $request->get('status'),
            'image' => $imageName,
            'category_id' => $request->get('category'),


        ]);
        $subcategory->save();

        return redirect()->route('subcategorie_list')->with('success', 'Subcategory created successfully.');

    }

    public function delete($id)
    {
        SubCategory::find($id)->delete();
        return back();
    }

}
