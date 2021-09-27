<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appriciation extends Model
{
    //
     protected $fillable = [
        'companyname',
        'clientname',
        'eventname',
        'eventdate',
        'location',
        'clientmail'
    ];
}
