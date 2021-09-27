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
use App\UserDetails;
use Carbon\Carbon;

class AdminEventsController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function recce(){
        $Bang_Recce = Recce::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_Recce = Recce::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_Recce = Recce::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_Recce = Recce::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.recce',compact('Bang_Recce','Mum_Recce','Del_Recce','Hyd_Recce'));
    }
    public function eventsetup(){
        $Bang_EventSetup = EventSetup::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_EventSetup = EventSetup::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_EventSetup = EventSetup::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_EventSetup = EventSetup::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.eventsetup',compact('Bang_EventSetup','Mum_EventSetup','Del_EventSetup','Hyd_EventSetup'));
    }
    public function event(){
        $Bang_Event = Event::whereIn('branch',[1,7])->orderBy('created_at', 'desc')->paginate(25);
        $Mum_Event = Event::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->paginate(25);
        $Del_Event = Event::whereIn('branch',[3])->orderBy('created_at', 'desc')->paginate(25);
        $Hyd_Event = Event::whereIn('branch',[4])->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.workschedule.event',compact('Bang_Event','Mum_Event','Del_Event','Hyd_Event'));
    }
}
