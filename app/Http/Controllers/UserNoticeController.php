<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\UserDetails;
use App\Holidays;
use App\Appriciation;
Use \Carbon\Carbon;
use App\Appriciationwish;
use App\Notice;

class UserNoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    }     
  
    public function noticelist()
    {
        $User = Auth::User();
        $UserNotice = Notice::where('branch',$User->branch)->where('status',0)->paginate(15);       
        return view('user.notice.notice_list',compact('UserNotice'));
    }  

    public function viewnotice($EncryptedID)
    {
        $ID = Crypt::decrypt($EncryptedID);
        $Notice = Notice::find($ID);
        return view('user.notice.view_notice',compact('Notice'));
    }
    public function newappriciationmail()
    {
        $latest = Appriciation::orderBy('id', 'DESC')->first();
        return view('user.appriciations.newappriciation',compact('latest'));
    }

    public function viewappriciation(Request $request)
    {
        $id = Crypt::decrypt($request->EncryptedId);
        $viewappriciation = Appriciation::orderBy('id', 'DESC')->where('id','=',$id)->first();
        $maildata = Appriciation::orderBy('id', 'DESC')->where('id','!=',$viewappriciation->id)->get();
        return view('user.appriciations.appriciationview', compact('viewappriciation', 'maildata'));
    }

    public function userappriciationwish(Request $request)
    {        
        $request->validate([
            'appriciation_whishes' => 'required',
        ]);
        
        $user = Auth::user();
        $appriciationwish = new Appriciationwish();
        $appriciationwish->name = $user->first_name.' '.$user->last_name; 
        $appriciationwish->appriciationmail_id = $request->appriciationmail_id;
        $appriciationwish->appriciation_whishes = $request->appriciation_whishes;
        $appriciationwish->save();
        return back();
    }

    public function holidaysfileview()
    {
        $holidays = Holidays::all();       
        return view('user.holidayslist.holidays',compact('holidays'));
    }

    public function hrpolicies()
    {
        return view('user.hrpolicies.hrpolicies');
    }

    public function aup()
    {   
        $user = Auth::user();
        $confirmationemp = UserDetails::where('id','=',$user->id)->select('designation')->first();
        return view('user.companypolicy.aup',compact('user','confirmationemp'));
    }
}
