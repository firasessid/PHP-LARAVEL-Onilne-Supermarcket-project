<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rays;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','upload']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }








    public function index(Request $request)
    {
        // Récupérer les paramètres de la requête
        $perPage = $request->input('per_page', 10); // Nombre d'éléments par page (par défaut : 10)
        $statusLabel = $request->input('status', 'all'); // Filtre par statut (par défaut : "all")
        $rayId = $request->input('ray', 'all'); // Filtre par rayon (par défaut : "all")
    
        // Mapping des libellés de statut vers les valeurs numériques
        $statusMapping = [
            'all' => null,
            'Active' => 1,
            'Inactive' => 0,
        ];
    
        $statusValue = $statusMapping[$statusLabel] ?? null;
    
        // Requête principale avec jointure entre categories et rays
        $query = Category::select('categories.*', 'rays.name as rayName')
            ->leftJoin('rays', 'rays.id', '=', 'categories.ray_id');
    
        // Ajouter le filtre par statut si spécifié
        if ($statusValue !== null) {
            $query->where('categories.status', $statusValue);
        }
    
        // Ajouter le filtre par rayon si spécifié
        if ($rayId !== 'all') {
            $query->where('categories.ray_id', $rayId);
        }
    
        // Paginer les résultats
        $categories = $query->latest('categories.id')->paginate($perPage);
    
        // Récupérer tous les rays pour le filtre
        $rays = Rays::all();
    
        // Retourner la vue avec les données paginées et les filtres actuels
        return view('Back-end.category_list', compact('categories', 'rays', 'statusLabel', 'rayId'));
    }





    
    public function create()
    {
        $rays= Rays::orderBy('name','ASC')->get();

        return view('Back-end.create_categorie',compact('rays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'rays'=>'required|numeric',

        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('images', $imageName, 'public');

        $category = new Category([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'status' => $request->get('status'),
            'image' => $imageName,
            'ray_id' => $request->get('rays'),

        ]);
        $category->save();

        return redirect()->route('categorie_list')->with('success', 'Category created successfully.');

    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $rays = Rays::orderBy('name', 'ASC')->get();
        return view('Back-end.create_categorie', compact('category', 'rays'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $id,
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp',
            'rays' => 'required|numeric',
        ]);
    
        // Find the category
        $category = Category::findOrFail($id);
    
        // Update fields
        $category->name = $request->get('name');
        $category->slug = $request->get('slug');
        $category->status = $request->get('status');
        $category->ray_id = $request->get('rays');
    
        // Check if a new image was uploaded
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageName, 'public');
            $category->image = $imageName;
        }
    
        // Save the updated category
        $category->save();
    
        return redirect()->route('categorie_list')->with('success', 'Category updated successfully.');
    }
    

    public function delete($id)
    {
        Category::find($id)->delete();
        return back();
    }


}

