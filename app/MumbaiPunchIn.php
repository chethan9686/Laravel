<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MumbaiPunchIn extends Model
{
    protected $fillable = [
        'user_id','emp_id','card_id','emp_name','date','time','gate','punch_details','location'
    ];
}
