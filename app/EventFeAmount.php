<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventFeAmount extends Model
{
    protected $fillable = [
        'user_id', 
        'branch',
        'year',      
        'April',
        'May',
        'June',
        'July',
        'Agust',
        'September',
        'October',
        'November',
        'December',
        'January',
        'February',
        'March'
    ];
}
