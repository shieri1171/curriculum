<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    //メール文変更
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    //各テーブル結合
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

    //自分がフォローしている人数
    public function follows()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    //自分がフォローされている人数
    public function followers()
    {
        return $this->hasMany(Follow::class, 'follow_id');
    }

}