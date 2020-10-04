<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'event_name',
        'event_description',
        'event_img',
        'event_video',
        'event_start',
        'event_end',
        'event_payment',
        'event_payment_type',
    ];
}
