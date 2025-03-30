<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="orders";

    use HasFactory;
    protected $fillable = [ 'user_id', 'country_id', 'subtotal', 'shipping', 'discount', 'grand_total','coupon_code','coupon_code_id','adresse','adresse2','phone','zip'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hasGreenPoint()
    {
        // You should implement the logic to check if an order has a green point.
        // For example, you might have a column like 'has_green_point' in your orders table.
        return $this->has_green_point === 1;
    }
    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
