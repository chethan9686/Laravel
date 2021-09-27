<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLateworking;

class AdminLateworkingController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function lateworking(){
    	$Bang_lateworking = UserLateworking::whereIn('branch',[1,6,7])->orderBy('created_at', 'desc')->paginate(25);
    	$Mum_lateworking = UserLateworking::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
    	$Del_lateworking = UserLateworking::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
    	$Hyd_lateworking = UserLateworking::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
    	return view ('admin.lateworking.lateworking',compact('Bang_lateworking','Mum_lateworking','Del_lateworking','Hyd_lateworking'));
    }
}
