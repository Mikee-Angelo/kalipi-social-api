<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    public function event(){
        return $this->belongsTo('App\Models\Events');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
