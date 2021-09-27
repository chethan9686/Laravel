<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLateworking extends Model
{
    //
    protected $fillable = [
        'user_id','tl','rm','rh',
        'branch',
        'date',
        'time',
        'clientName',
        'event_worked_on',
        'purpose_of_work'
    ];
}
