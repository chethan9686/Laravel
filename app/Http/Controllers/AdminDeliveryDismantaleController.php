<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Branch;
use App\Recce;
use App\EventSetup;
use App\Event;
use App\VendorMeeting;
use App\Preeventmeeting;
use App\Delivery;
use App\Dismental;
use App\UserDetails;
use Carbon\Carbon;

class AdminDeliveryDismantaleController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('auth:admin');
    }

     public function delivery(){
        $Bang_Delivery = Delivery::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_Delivery = Delivery::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_Delivery = Delivery::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_Delivery = Delivery::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.delivery',compact('Bang_Delivery','Mum_Delivery','Del_Delivery','Hyd_Delivery'));
    }
    public function dismantle(){
        $Bang_Dismental = Dismental::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_Dismental = Dismental::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_Dismental = Dismental::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_Dismental = Dismental::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.dismantel',compact('Bang_Dismental','Mum_Dismental','Del_Dismental','Hyd_Dismental'));
    }
}
