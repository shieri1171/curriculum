<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['follower_id', 'follow_id',];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function followedUser() {
        return $this->belongsTo(User::class, 'follow_id');
    }
}
