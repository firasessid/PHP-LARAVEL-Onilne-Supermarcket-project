<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['category_id','name', 'slug', 'status', 'image'];

    use HasFactory;


    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
}
