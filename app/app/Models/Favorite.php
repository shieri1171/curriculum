<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'item_id'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function item() {
        return $this->belongsTo('App\Models\Item');
    }

}
