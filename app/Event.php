<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'eventname',
        'clientname',
        'eventfromdate',
        'eventtodate',
        'eventlocation',
        'eventdesc',
        'event_references_id','attendence_status'
    ];
}
