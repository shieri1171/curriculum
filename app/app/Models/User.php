<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

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

    //ユーザーがいいねした商品
    public function favoriteItems()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }

}
