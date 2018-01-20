<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['name', 'description', 'longitude', 'latitude', 'price', 'user_id', 'address'];
}
