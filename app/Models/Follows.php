<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    public function user(){
        return $this->hasMany('App\Models\User');
    }

    public function follower(){
        return $this->hasMany('App\Models\User', 'follower_id');
    }
}
