<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            // You can save the image path to the database or perform other actions
            return redirect()->back()->with('success', 'Image uploaded successfully.');
        }

        return redirect()->back()->with('error', 'No image was uploaded.');
    }
}
