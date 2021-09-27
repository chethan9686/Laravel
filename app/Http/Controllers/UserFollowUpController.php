<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserFollowup;
use App\Branch;
use App\States;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use App\User;
use App\UserDetails;
use App\UserMeeting;
use App\UserFollowupMeeting;
use Toastr;
use Carbon\Carbon;

class UserFollowUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function followupmeeting($EncryptedID)
    {
    	$User = Auth::user();    	
        if($User->branch == 1 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name','ASC')->get();
        }
        elseif($User->branch == 4)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name','ASC')->get();
        }

    	$ID = Crypt::decrypt($EncryptedID);
        $Details = UserMeeting::find($ID);

        return view('user.meeting.follow_up_meeting',compact('Details','Users'));
    }

    public function submitfollowupmeeting(Request $request)
    {
    	$request->validate([
    		'company_name' => ['required'],
            'client_name' => ['required'],
            'client_email' => ['required'],  
            'date' => ['required'],  
            'time' => ['required'], 
            'duration' => ['required'],
            'location' => ['required'],  
            'expected_time' => ['required'],   
            'purpose_of_working' => ['required']
        ], [
        	'company_name.required' => 'Please Enter Company Name',
            'client_name.required' => 'Please Enter Client Name',
            'client_email.required' => 'Please Enter Client Email',     
            'date.required' => 'Please Select Date Of Meeting',   
            'time.required' => 'Please Select Time Of Meeting',   
            'duration.required' => 'Please Select Duration Of Meeting',
            'location.required' =>'Please Enter Location Of Meeting',  
            'expected_time.required' => 'Please Select Expected Arrival Time To Office.',    
            'purpose_of_working.required' => 'Please Enter Purpose Of Meeting'        
        ]);

        $User = Auth::user();
        $User_details = UserDetails::where('user_id', $User->id)->first();
        $Meeting_date = Carbon::parse($request->date);
        $day = $Meeting_date->day;

        $number = new ConvertNumber(); 
        $num_word = $number->numberTowords($day);

        $meeting = UserMeeting::where('user_id',$User->id)->where('company_name','=',$request->company_name)->where('date',$request->date)->where('time',$request->time)->first();
        $followup_meeting = UserFollowupMeeting::where('user_id',$User->id)->where('company_name','=',$request->company_name)->where('date',$request->date)->where('time',$request->time)->first();

        if(!is_null($meeting) || !is_null($followup_meeting))
        {
            Toastr::error('Please Check The Details Because You Have Already Meeting In That Slot!. Thank You ',$title = null, $options=["positionClass" => "toast-top-center"]);
            return back();
        }
        else
        {
        	if(is_null($request->tag_user))
            {
                $user_meeting = UserFollowupMeeting::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh, 
                                    'meeting_id' => $request->meeting_id,                           
                                    'company_name' => $request->company_name,
                                    'client_name' => $request->client_name,
                                    'client_email' => $request->client_email,
                                    'date' => $request->date,
                                    'time' => $request->time,
                                    'duration' => $request->duration,
                                    'eta' => $request->expected_time,
                                    'location' => $request->location,
                                    'purpose_of_meeting' => $request->purpose_of_working                                
                                ]);               

                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence=BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }                    
                }
                elseif($User->branch == 2 || $User->branch == 5)
                {
                    $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }
                }   
                elseif($User->branch == 3)
                {
                    $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }
                }    

                $Mail = new SendMail();
                $cc = $Mail->getusers($User,$User_details);

                $send_to = User::find($User_details->tl);

                Mail::to($send_to)->send(new UserFollowup($User,$user_meeting,$cc,$User_details));
            }
            else
            {               
                foreach($request->tag_user as $tag_user){
                    $tag_meeting = UserMeeting::where('user_id',$tag_user)->where('company_name','=',$request->company_name)->where('date',$request->date)->where('time',$request->time)->first(); 
                    $tag_followup_meeting = UserFollowupMeeting::where('user_id',$User->id)->where('company_name','=',$request->company_name)->where('date',$request->date)->where('time',$request->time)->first();

                    if($tag_meeting || $tag_followup_meeting)
                    {
                        Toastr::error('Please Check Tag Users Already Having Meeting In That Slot!. Thank You ',$title = null, $options=["positionClass" => "toast-top-center"]);
                        return back();
                    }                   
                }

                $user_meeting = UserFollowupMeeting::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh,    
                                    'meeting_id' => $request->meeting_id,                               
                                    'company_name' => $request->company_name,
                                    'client_name' => $request->client_name,
                                    'client_email' => $request->client_email,
                                    'date' => $request->date,
                                    'time' => $request->time,
                                    'duration' => $request->duration,
                                    'eta' => $request->expected_time,
                                    'location' => $request->location,
                                    'purpose_of_meeting' => $request->purpose_of_working                                
                                ]);

                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence=BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }
                }
                elseif($User->branch == 2 || $User->branch == 5)
                {
                    $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }
                }   
                elseif($User->branch == 3)
                {
                    $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
                    if($User_Attendence)
                    {
                        if($user_meeting->time <= '11:30')
                        {
                            $User_Attendence->$num_word = 'M';
                            $User_Attendence->save();
                        }
                    }
                } 

                $Mail = new SendMail();
                $cc = $Mail->getusers($User,$User_details);

                $send_to = User::find($User_details->tl);
                Mail::to($send_to)->send(new UserFollowup($User,$user_meeting,$cc,$User_details));

                foreach($request->tag_user as $tag_user){
                    $TagUser = User::find($tag_user);
                    $Tag_details = UserDetails::where('user_id', $TagUser->id)->first();

                    $Tag_meeting =  UserFollowupMeeting::create([
                                        'user_id' => $TagUser->id,
                                        'branch' => $TagUser->branch,
                                        'tl' => $Tag_details->tl,
                                        'rm' => $Tag_details->rm,
                                        'rh' => $Tag_details->rh,   
                                        'meeting_id' => $request->meeting_id,                                   
                                        'company_name' => $request->company_name,
                                        'client_name' => $request->client_name,
                                        'client_email' => $request->client_email,
                                        'date' => $request->date,
                                        'time' => $request->time,
                                        'duration' => $request->duration,              
                                        'eta' => $request->expected_time,
                                        'location' => $request->location,
                                        'purpose_of_meeting' => $request->purpose_of_working,
                                        'referred_id' => $user_meeting->id
                                    ]);

                    if($TagUser->branch == 1 || $TagUser->branch == 4 || $TagUser->branch == 6 || $TagUser->branch == 7)
                    {               
                        $User_Attendence=BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$TagUser->id)->first();
                        if($User_Attendence)
                        {
                            if($user_meeting->time <= '11:30')
                            {
                                $User_Attendence->$num_word = 'M';
                                $User_Attendence->save();
                            }
                        }
                    }
                    elseif($TagUser->branch == 2 || $TagUser->branch == 5)
                    {
                        $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$TagUser->id)->first();
                        if($User_Attendence)
                        {
                            if($user_meeting->time <= '11:30')
                            {
                                $User_Attendence->$num_word = 'M';
                                $User_Attendence->save();
                            }
                        }
                    }   
                    elseif($TagUser->branch == 3)
                    {
                        $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$TagUser->id)->first();
                        if($User_Attendence)
                        {
                            if($user_meeting->time <= '11:30')
                            {
                                $User_Attendence->$num_word = 'M';
                                $User_Attendence->save();
                            }
                        }                        
                    } 
                

                    $Mail = new SendMail();
                    $cc = $Mail->getusers($TagUser,$Tag_details);

                    $send_to = User::find($Tag_details->tl);
                    Mail::to($send_to)->send(new UserFollowup($TagUser,$Tag_meeting,$cc,$Tag_details));
                }
            }


            //////////////////////////////for redirecting ////////////////////////////////////////////


            $States = States::all();
	        $userbranch = Branch::find($User->branch);      
	        if($User->user_position == 5){
	            if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7){
	                $meetings = UserFollowupMeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
	            }elseif($User->branch == 2 || $User->branch == 3 || $User->branch == 5){
	                $meetings = UserFollowupMeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
	            }
	        }
	        elseif($User->user_position == 1 || $User->user_position == 2 || $User->user_position == 3){
	            if($User->branch == 1 || $User->branch == 6 || $User->branch == 7){                               
	                $meetings = UserFollowupMeeting::where('user_id','=',$User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();       
	            }elseif($User->branch == 2 || $User->branch == 5){
	                $meetings = UserFollowupMeeting::where('user_id','=',$User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
	            }elseif($user->branch == 3){
	                $meetings = UserFollowupMeeting::where('user_id','=',$User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
	            }elseif($user->branch == 4){
	                $meetings = UserFollowupMeeting::where('user_id','=',$User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();   
	            }        
	        }else{
	                $meetings = UserFollowupMeeting::where('user_id','=',$User->id)->orderBy('created_at', 'desc')->get();
	        }       

            ////////////////////////////////////////////////////////////////////////////////////

            Toastr::success('You Have Successfully Submitted Follow Up Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return redirect()->route('followup_meeting_list',compact('meetings','States'));
        }
    }

    public function followup_meetinglist()
    {
        $user = Auth::user(); 
        $States = States::all();
        $userbranch = Branch::find($user->branch);      
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $meetings = UserFollowupMeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $meetings = UserFollowupMeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $meetings = UserFollowupMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();       
            }elseif($user->branch == 2 || $user->branch == 5){
                $meetings = UserFollowupMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $meetings = UserFollowupMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 4){
                $meetings = UserFollowupMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();    
            }        
        }else{
                $meetings = UserFollowupMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }       
      
        return view('user.meeting.followup_meeting_list',compact('meetings','States'));
    }
}
