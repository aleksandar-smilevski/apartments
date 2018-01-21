<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $table = "apartments";
    protected $fillable = ['name', 'description', 'longitude', 'latitude', 'price', 'user_id', 'address'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function reservations(){
        return $this->hasMany('App\Models\Reservation');
    }
}
