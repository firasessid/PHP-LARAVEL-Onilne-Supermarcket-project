<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
class BrandController extends Controller
{

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:brand-list|brand-create|brand-edit|brand-delete', ['only' => ['index']]);
         $this->middleware('permission:brand-create', ['only' => ['create','store']]);
         $this->middleware('permission:brand-edit', ['only' => ['edit','upload']]);
         $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }




    public function index(Request $request)
    {
        // Récupérer les paramètres de la requête
        $perPage = $request->input('per_page', 10); // Nombre d'éléments par page (par défaut : 10)
        $statusLabel = $request->input('status', 'all'); // Filtre par statut (par défaut : "all")
    
        // Mapping des libellés de statut vers les valeurs numériques
        $statusMapping = [
            'all' => null,
            'Active' => 1,
            'Inactive' => 0,
        ];
    
        $statusValue = $statusMapping[$statusLabel] ?? null;
    
        // Requête principale avec filtrage par statut
        $query = Brand::query();
    
        if ($statusValue !== null) {
            $query->where('status', $statusValue);
        }
    
        // Paginer les résultats
        $brands = $query->latest('id')->paginate($perPage);
    
        // Retourner la vue avec les données paginées et le filtre actuel
        return view('Back-end.brand_list', compact('brands', 'statusLabel'));
    }

    public function create()
    {

        return view('Back-end.create_brand');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('images', $imageName, 'public');

        $brand = new Brand([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'status' => $request->get('status'),
            'image' => $imageName,
        ]);
        $brand->save();

        return redirect()->route('brand_list')->with('success', 'Brand created successfully.');
    }

    public function delete($id)
    {
        Brand::find($id)->delete();
        return back();
    }
}
