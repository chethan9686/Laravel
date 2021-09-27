<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNetworking extends Model
{
    protected $fillable = [
        'user_id','branch','tl','rm','rh','time','date','company_status','company_name','client_name','client_mobile','duration','eta','location','meeting_status','purpose_of_meeting','reason','referred_id','attendence_update'
    ];
}
