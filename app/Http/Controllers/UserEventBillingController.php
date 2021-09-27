<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\EventsBilling;
use App\EventFeAmount;
use Toastr;
use Carbon\Carbon;

class UserEventBillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 
    
    public function eventbilling(){
      $Amount = EventFeAmount::first();
     
    	return view('user.eventbilling.event_billing_report',compact('Amount'));
    }

    public function createbilling(Request $request){

    	$user = Auth::user();
    	$user_id = $user->id;    
    	$ammount = $request->ammount;
    	$month = $request->month;
    	$year = $request->year;
    	$branch = $request->branch;

      $data = EventsBilling::where('year',$year)->where('branch',$branch)->first();

      if(is_null($data))
      {
        $res = EventsBilling::create([
                'user_id' => $user_id,
                'branch' => $branch,
                'year' => $year,          
              ]);
        $res->$month = $ammount;
        $res->save();
      }
      else
      {
        $data->$month = $ammount;
        $data->save();
      }  
      Toastr::success('You Have Successfully Submitted Billing Report!.. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);     
      return back(); 
    }

    public function createfeamount(Request $request){

      $user = Auth::user();
      $user_id = $user->id;    
      $ammount = $request->ammount;
      $month = $request->month;
      $year = $request->year;
      

      $data = EventFeAmount::where('year',$year)->first();

      if(is_null($data))
      {
        $res = EventFeAmount::create([
                'user_id' => $user_id,                
                'year' => $year,          
              ]);
        $res->$month = $ammount;
        $res->save();
      }
      else
      {
        $data->$month = $ammount;
        $data->save();
      }  
      Toastr::success('You Have Successfully Submitted FE Amount!.. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);     
      return back(); 
    }
}
