<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAcademics extends Model
{
     protected $fillable = [
        'user_id','course_name','from','to','university','location','branch','percentage','class_obt'
    ];
}
