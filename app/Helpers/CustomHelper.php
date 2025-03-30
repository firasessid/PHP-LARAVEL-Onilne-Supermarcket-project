<?php
use App\Models\Product;



function getImage($productID)
{
    $product = Product::find($productID);

        // Assuming 'image' is the field where the image path or URL is stored
        return $product;


    // Return a default image URL or handle missing images as needed
}
?>
