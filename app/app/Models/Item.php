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

    public function itemImages()
    {
        return $this->hasMany(ItemImage::class, 'item_id');
    }

    public function mainImage()
    {
        return $this->hasOne(ItemImage::class)->where('mainflg', 1);
    }

    public const ITEM_STATES = [
        1 => '新品・未使用',
        2 => '未使用に近い',
        3 => '目立った傷や汚れなし',
        4 => 'やや傷や汚れあり',
        5 => '傷や汚れあり',
        6 => '全体的に状態が悪い',
    ];

    public function getStateLabelAttribute()
    {
        return self::ITEM_STATES[$this->state];
    }

}
