<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table="order_items";

    use HasFactory;
    protected $fillable = ['product_id', 'order_id', 'name', 'qty', 'price', 'total'];
   
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
