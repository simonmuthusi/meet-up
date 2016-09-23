<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\User;

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

    /**
     * The users belonging to this event
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
