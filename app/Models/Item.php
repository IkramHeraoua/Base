<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cart_id', 'meal_id', 'quantity', 'price', 'discount', 'tax', 'delivery_fee'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
