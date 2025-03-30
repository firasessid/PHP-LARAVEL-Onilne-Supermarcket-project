<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rays;
class RaysController extends Controller
{

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:ray-list|ray-create|ray-edit|ray-delete', ['only' => ['index']]);
         $this->middleware('permission:ray-create', ['only' => ['create','store']]);
         $this->middleware('permission:ray-edit', ['only' => ['edit','upload']]);
         $this->middleware('permission:ray-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // Récupérer les paramètres de la requête
        $perPage = $request->input('per_page', 10);
        $statusLabel = $request->input('status', 'all');
    
        // Mapping des libellés vers les valeurs numériques
        $statusMapping = [
            'all' => null,
            'Active' => 1,
            'Block' => 0,
        ];
    
        $statusValue = $statusMapping[$statusLabel] ?? null;
    
        // Requête avec filtrage par statut
        $query = Rays::query();
    
        if ($statusValue !== null) {
            $query->where('status', $statusValue);
        }
    
        // Paginer les résultats
        $rays = $query->paginate($perPage);
    
      
    
        // Sinon, charger la vue complète
        return view('Back-end.rays_list', compact('rays', 'statusLabel'));
    }
    public function create()
    {

        return view('Back-end.create_rays');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('images', $imageName, 'public');

        $rays = new Rays([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'status' => $request->get('status'),
            'image' => $imageName,
        ]);
        $rays->save();

        return redirect()->route('rays_list')->with('success', 'Ray created successfully.');
    }

    public function delete($id)
    {
        Rays::find($id)->delete();
        return back();
    }
}
