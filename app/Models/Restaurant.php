<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'user_id', 'address', 'phone', 'email', 'website', 'logo', 'cover_image', 'description', 'latitude', 'longitude', 'status', 'is_featured', 'is_verified'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
