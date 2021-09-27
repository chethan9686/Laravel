<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollowupMeeting extends Model
{
    protected $fillable = [
        'user_id','branch','tl','rm','rh','meeting_id','time','date','company_name','client_name','client_email','duration','eta','location','purpose_of_meeting','reason','referred_id'
    ];
}
