<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $fillable = [
        'name',
        'event_from_date',
        'event_to_date',
        'location',
        'description',
        'attachment',
        'send_notification'
    ];
}
