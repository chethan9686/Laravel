<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOutOfStation extends Model
{
      protected $fillable = [
        'user_id','tl','rm','rh','purpose_of_work','purpose_of_travel','departure_date','departure_time','arrival_date','branch',
        'arrival_time','event_date','event_name','event_location','travel_mode','admin_status','admin_comment','level','attendence_status'
    ];
}
