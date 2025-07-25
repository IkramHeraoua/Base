<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cart_id', 'user_id', 'restaurant_id', 'total_price', 'total_quantity', 'total_discount', 'total_tax', 'total_delivery_fee', 'total_amount', 'payment_method', 'payment_status', 'payment_id', 'payment_url', 'payment_response', 'payment_response_code', 'payment_response_message', 'payment_response_data', 'delivery_address', 'delivery_lat', 'delivery_lon', 'status'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

  
}
