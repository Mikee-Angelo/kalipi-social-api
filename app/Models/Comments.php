<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_content',
        'user_id',
        'post_id',
        'comment_reply_to'
    ];

    public function post(){
        return $this->belongsTo('App\Models\Posts');
    }

    public function comment_reacts(){
        return $this->hasMany('App\Models\CommentReacts');
    }
}
