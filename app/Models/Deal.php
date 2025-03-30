<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['product_id','image', 'starts_at', 'ends_at', 'discount_percentage'];

    use HasFactory;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
