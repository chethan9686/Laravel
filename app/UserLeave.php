<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLeave extends Model
{
    protected $fillable = [
        'user_id','branch','tl','rm','rh','emp_name','leave_type','duration','start_date','end_date','reason','admin_status','admin_comment','level','attendence_status'
    ];
}
