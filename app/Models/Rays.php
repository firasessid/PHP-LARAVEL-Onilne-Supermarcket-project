<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rays extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'status', 'image'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'ray_id');
    }



    public function products()
    {
        return $this->hasMany(Product::class, 'ray_id');
    }
}
