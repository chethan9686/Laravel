<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessSignupSplit extends Model
{
    protected $fillable = [
    	'id','signup_id','employee_id','percentage'
    	];
}
