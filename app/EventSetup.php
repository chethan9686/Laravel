<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSetup extends Model
{
    //
    protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'setup_clientname',
        'setup_eventstartdate',
        'setup_eventenddate',
        'setup_time',
        'setup_eventlcation',
        'setup_EWH',
        'setup_references_id','attendence_status'
    ];
}
