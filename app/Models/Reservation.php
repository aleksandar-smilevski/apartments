<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'apartment_id', 'from', 'to', 'price', 'description'];
    protected $table = "reservations";
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function apartment(){
        return $this->belongsTo('App\Models\Apartment', 'apartment_id');
    }
}
