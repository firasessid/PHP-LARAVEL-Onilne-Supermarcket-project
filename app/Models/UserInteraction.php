<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInteraction extends Model
{
    use HasFactory;
    protected $table = 'user_interactions'; // Specify the table name

    protected $fillable = [
        'user_id',
        'product_id',
        'action_type',
        'interaction_time',
        'cluster_id',
    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}

}
