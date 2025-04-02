<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function buy() {
        return $this->hasOne('App\Models\Buy');
    }

    public function favorite() {
        return $this->hasMany('App\Models\Favorite');
    }

    public function comment() {
        return $this->hasMany('App\Models\comment');
    }

}
