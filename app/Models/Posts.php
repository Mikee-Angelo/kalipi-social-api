<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Posts extends Model
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'user_id',
        'post_content',
        'post_privacy',
        'post_feelings',
        'post_location',
        'active',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comments');
    }

    public function post_reacts(){
        return $this->hasMany('App\Models\PostReacts');
    }
}
