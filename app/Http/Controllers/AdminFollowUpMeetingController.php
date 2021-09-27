<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use App\User;
use App\UserMeeting;
use App\UserFollowupMeeting;

class AdminFollowUpMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function followupmeeting()
    {
    	$Bang_Users = UserFollowupMeeting::whereIn('branch',[1,6,7])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Mum_Users = UserFollowupMeeting::whereIn('branch',[2,5])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Del_Users = UserFollowupMeeting::whereIn('branch',[3])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Hyd_Users = UserFollowupMeeting::whereIn('branch',[4])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get(); 
       	
    	return view('admin.meeting.followup_meeting',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users'));
    }
}
