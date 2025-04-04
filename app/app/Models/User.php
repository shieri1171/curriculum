<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function item() {
        return $this->hasMany('App\Models\Item');
    }

    public function buy() {
        return $this->hasMany('App\Models\Buy');
    }

    public function favorite() {
        return $this->hasMany('App\Models\Favorite');
    }

    public function follow() {
        return $this->hasMany('App\Models\Follow');
    }

    public function comment() {
        return $this->hasMany('App\Models\comment');
    }

}
