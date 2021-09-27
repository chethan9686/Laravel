<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BsNumber extends Model
{
    protected $fillable = [
    	 'id','user_id','signup_id','bs_number'
    ];
}
