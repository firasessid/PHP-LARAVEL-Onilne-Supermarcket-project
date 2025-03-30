<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductClicked;

class DealController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:deal-list|deal-create|deal-edit|deal-delete', ['only' => ['index']]);
         $this->middleware('permission:deal-create', ['only' => ['create','store']]);
         $this->middleware('permission:deal-edit', ['only' => ['edit','upload']]);
         $this->middleware('permission:deal-delete', ['only' => ['destroy']]);
    }

    public function create()
    {
        $products = Product::all();
        return view('Back-end.deal', compact('products'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric',
            'starts_at' => 'required|date|after_or_equal:now',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5048',
        ], [
            // Validation messages
        ]);

        if ($validator->passes()) {
            $imageName = null; // Default value if no image is provided

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('images', $imageName, 'public');
            }

            $deal = new Deal;
            $deal->product_id = $request->product_id;
            $deal->starts_at = $request->starts_at;
            $deal->ends_at = $request->ends_at;
            $deal->discount_percentage = $request->discount_percentage;
            $deal->image = $imageName;

            $deal->save();
            event(new ProductClicked($deal->product_id));  // Assuming the product ID is stored in the deal

            return response()->json([
                'status' => true,
                'message' => 'Product deal added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function edit(Deal $deal)
    {
        $products = Product::all();
        return view('deals.edit', compact('deal', 'products'));
    }

    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'discount_percentage' => 'required|integer|between:1,100',
        ]);

        $deal->update([
            'product_id' => $request->product_id,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'discount_percentage' => $request->discount_percentage,
        ]);

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully');
    }

    public function index()
    {
        $deals = Deal::with('product')->get();
        return view('Back-end.deal_list', compact('deals'));
    }
}
