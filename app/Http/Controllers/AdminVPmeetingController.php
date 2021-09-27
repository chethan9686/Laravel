<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Branch;
use App\VendorMeeting;
use App\Preeventmeeting;
use App\UserDetails;
use Carbon\Carbon;

class AdminVPmeetingController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function vendormeeting(){
        $Bang_vendormeeting = VendorMeeting::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_vendormeeting = VendorMeeting::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_lateworking = VendorMeeting::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_lateworking = VendorMeeting::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.vendormeeting',compact('Bang_vendormeeting','Mum_vendormeeting','Del_lateworking','Hyd_lateworking'));
    }
    public function preeventmeeting(){
    	$Bang_Preeventmeeting = Preeventmeeting::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
    	$Mum_Preeventmeeting = Preeventmeeting::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
    	$Del_Preeventmeeting = Preeventmeeting::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
    	$Hyd_Preeventmeeting = Preeventmeeting::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
    	return view('admin.workschedule.preeventmeeting',compact('Bang_Preeventmeeting','Mum_Preeventmeeting','Del_Preeventmeeting','Hyd_Preeventmeeting'));
    }
}
