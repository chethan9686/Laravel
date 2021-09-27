<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dismental extends Model
{
    //
     protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'dis_clientname',
        'dis_eventname',
        'dis_location',
        'dis_dateofdismantle',
        'dis_time',
        'dis_EWH',
        'dis_references_id'
    ];
}
