<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFamily extends Model
{
     protected $fillable = [
        'user_id','relationship','name','age','dependent'
    ];
}
