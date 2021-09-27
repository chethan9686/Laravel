<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResignedUser extends Model
{
       protected $fillable = [
        'id','user_id','tl','rm','rh','resigned_date','designation','reason_for_leaving','rehired','branch'
    ];
}
