<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\LateWorking;
use Toastr;
use App\User;
use App\UserDetails;
use App\Branch;
use App\UserLateworking;

class UserLateworkingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    }

    public function lateworking(){
    	$user = Auth::user(); 
        $userbranch = Branch::find($user->branch);   	
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $lateworkingdata = UserLateworking::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $lateworkingdata = UserLateworking::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $lateworkingdata = UserLateworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();             
            }elseif($user->branch == 2 || $user->branch == 5){
                $lateworkingdata = UserLateworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $lateworkingdata = UserLateworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 4){
                $lateworkingdata = UserLateworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();    
            }        
        }else{
                $lateworkingdata = UserLateworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }
    	
    	return view('user.lateworking.index',compact('user','userbranch','lateworkingdata'));
    }

    public function storelateworking(Request $request){

        $request->validate([
                'branch' => ['required'],
                'date' => ['required'],  
                'time' => ['required'],    
                'clientName' => ['required'],
                'event_worked_on' => ['required'],
                'purpose_of_work' => ['required']
        ], [
                'branch.required' => 'Branch Is Required.',
                'date.required' => 'Please Select The Date',     
                'time.required' => 'Please Select The Time', 
                'clientName.required' => 'PLease Enter The Client Name',   
                'event_worked_on.required' => 'Please Enter The Event Name',
                'purpose_of_work.required' => 'Please Mention The Purpose of Work'   
        ]);  

        $user = Auth::user();
        $username = $user->first_name.' '.$user->last_name;  
    	$branch = Branch::where('name',$request->branch)->first();
        $user_details = UserDetails::where('user_id',$user->id)->first();

        $lateworking = new UserLateworking();
        $lateworking->user_id = $user->id;
        $lateworking->tl = $user_details->tl;
        $lateworking->rm = $user_details->rm;
        $lateworking->rh = $user_details->rh;
        $lateworking->branch = $branch->id;
        $lateworking->date = date('Y-m-d', strtotime($request->date));
        $lateworking->time = $request->time;
        $lateworking->clientName = $request->clientName;
        $lateworking->event_worked_on = $request->event_worked_on;
        $lateworking->purpose_of_work = $request->purpose_of_work;

        // Bangalore||Kolkata||Chennai at 9pm
        $Bang = \Carbon\Carbon::parse('today 9pm');
        // Mumbai||Pune at 9.30pm
        $Mum = \Carbon\Carbon::parse('today 9.30pm');
        // Delhi at 9.30pm
        $Del = \Carbon\Carbon::parse('today 9.30pm');
        // Hyderabad at 9.30pm
        $Hyd = \Carbon\Carbon::parse('today 9.30pm');

        // tomorrow 6am
        $tomorrow = \Carbon\Carbon::parse('tomorrow 6am');

        // Now
        $now = \Carbon\Carbon::now(); 

        $Mail = new SendMail();
        $cc = $Mail->getusers($user,$user_details);
               
        $send_to = User::find($user_details->tl);

        if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){
            if ($now->gte($Bang) && $now->lte($tomorrow)){
                
                $lateworking->save();   
                Mail::to($send_to)->send(new LateWorking($user,$lateworking,$cc,$user_details));
               
                Toastr::success('Thanks a lot for working hard and late, past the standard office hours. We value your sincere efforts. Please punch in before 11:30 am tomorrow, post which standard attendance policies will be in effect.',$title = null, $options = ["positionClass" => "toast-top-center", "showDuration" => "50000","closeButton" => true]);
                return back();
            }else{
                Toastr::error('Please Check The Timings Before You Submit The Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }

        }elseif($user->branch == 2 || $user->branch == 5){
            if ($now->gte($Mum) && $now->lte($tomorrow)){
                
                $lateworking->save();
                Mail::to($send_to)->send(new LateWorking($user,$lateworking,$cc,$user_details));
                
                /*Toastr::success('You Have Successfully Uploaded LateWorking Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);*/
                Toastr::success('Thanks a lot for working hard and late, past the standard office hours. We value your sincere efforts. Please punch in before 12 Noon tomorrow, post which standard attendance policies will be in effect.',$title = null, $options = ["positionClass" => "toast-top-center", "showDuration" => "50000","closeButton" => true]);
                return back();
            }else{
                Toastr::error('Please Check The Timings Before You Submit The Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
        }elseif($user->branch == 3){
            if ($now->gte($Del) && $now->lte($tomorrow)){
                
                $lateworking->save();
                Mail::to($send_to)->send(new LateWorking($user,$lateworking,$cc,$user_details));
                
                /*Toastr::success('You Have Successfully Uploaded LateWorking Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);*/
                Toastr::success('Thanks a lot for working hard and late, past the standard office hours. We value your sincere efforts. Please punch in before 12 Noon tomorrow, post which standard attendance policies will be in effect.',$title = null, $options = ["positionClass" => "toast-top-center", "showDuration" => "50000","closeButton" => true]);
                return back();
            }else{
                Toastr::error('Please Check The Timings Before You Submit The Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();                
            }
        }elseif($user->branch == 4){
            if ($now->gte($Hyd) && $now->lte($tomorrow)){
                
                $lateworking->save();
                Mail::to($send_to)->send(new LateWorking($user,$lateworking,$cc,$user_details));                
               
                /*Toastr::success('You Have Successfully Uploaded LateWorking Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);*/
                Toastr::success('Thanks a lot for working hard and late, past the standard office hours. We value your sincere efforts. Please punch in before 11:30 am tomorrow, post which standard attendance policies will be in effect.',$title = null, $options = ["positionClass" => "toast-top-center", "showDuration" => "50000","closeButton" => true]);
                return back();
            }else{
                Toastr::error('Please Check The Timings Before You Submit The Details. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
        }    	
    }
}