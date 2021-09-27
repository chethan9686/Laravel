<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recce extends Model
{
    //
     protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'recce_clientname',
        'recce_eventname',
        'recce_dateofrecce',
        'recce_time',
        'recce_eventlcation',
        'recce_eventenddate',
        'recce_ERTW',
        'recce_references_id'
    ];
}
