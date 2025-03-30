<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
        'name', 'slug', 'status', 'image', 'short_description', 'description',
        'sale_price', 'regular_price', 'quantity', 'brand_id', 'ray_id',
        'category_id', 'sub_category_id', 'sku', 'is_featured', 'is_approved'
    ];

    use HasFactory;

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relation avec Deal
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    // Relation avec Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation avec SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Relation avec OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relation avec Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relation avec Ray
    public function ray()
    {
        return $this->belongsTo(Rays::class);
    }

    // Relation avec UserInteraction
    public function userInteractions()
    {
        return $this->hasMany(UserInteraction::class);
    }

    // Accesseur pour obtenir le nom du Ray
    public function getRayNameAttribute()
    {
        return optional($this->ray)->name ?? 'N/A'; // Retourne 'N/A' si le Ray est null
    }

    // Accesseur pour obtenir le nom de la Category
    public function getCategoryNameAttribute()
    {
        return optional($this->category)->name ?? 'N/A'; // Retourne 'N/A' si la Category est null
    }

    // Accesseur pour obtenir le nom de la SubCategory
    public function getSubcategoryNameAttribute()
    {
        return optional($this->subCategory)->name ?? 'N/A'; // Retourne 'N/A' si la SubCategory est null
    }

    // Accesseur pour obtenir le nom de la Brand
    public function getBrandNameAttribute()
    {
        return optional($this->brand)->name ?? 'No brand given'; // Retourne 'No brand given' si la Brand est null
    }
}