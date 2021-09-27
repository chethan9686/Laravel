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
use App\Mail\UsersMeeting;
use App\Mail\ReviewClientMoM;
use App\Mail\StatusMoM;
use App\Mail\UsersNetworking;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use App\Branch;
use App\States;
use App\User;
use App\UserDetails;
use App\UserMeeting;
use App\UserNetworking;
use App\Clients;
use Carbon\Carbon;

class UserNetworkingMeeting extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function networkingmeeting()
    {
    	$User = Auth::user();    	
        if($User->branch == 1 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name', 'asc')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name', 'asc')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name', 'asc')->get();
        }
        elseif($User->branch == 4)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBy('first_name', 'asc')->get();
        }

    	return view('user.meeting.networking_meeting',compact('Users'));
    }

    public function addnetworkingmeeting(Request $request)
    {    	
    	if(is_null($request->exist_company_name) && is_null($request->new_company_name)){
    		Toastr::error('Please Select Or Enter Company Name!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        	return back();
    	}

    	$request->validate([
            'client_name' => ['required'],
            'client_mobile' => ['required'],  
            'date' => ['required'],  
            'time' => ['required'], 
            'duration' => ['required'],
            'location' => ['required'],  
            'expected_time' => ['required'],   
            'purpose_of_working' => ['required']
        ], [
            'client_name.required' => 'Please Enter Client Name',
            'client_mobile.required' => 'Please Enter Client Mobile Number',     
            'date.required' => 'Please Select Date Of Meeting',   
            'time.required' => 'Please Select Time Of Meeting',   
            'duration.required' => 'Please Select Duration Of Meeting',
            'location.required' =>'Please Enter Location Of Meeting',  
            'expected_time.required' => 'Please Select Expected Arrival Time To Office.',    
            'purpose_of_working.required' => 'Please Enter Purpose Of Meeting'        
        ]); 

        $User = Auth::user();
        $User_details = UserDetails::where('user_id', $User->id)->first();

        $today = Carbon::today(); 

        $Meeting_date = Carbon::parse($request->date);

        $day = $Meeting_date->day;

        $number = new ConvertNumber(); 
        $num_word = $number->numberTowords($day);

        if(!is_null($request->new_company_name))
        {
            $companyname = $request->new_company_name;
        }
        elseif(!is_null($request->exist_company_name))            
        {
            $companyname = $request->exist_company_name;
        }            

        $meeting = UserNetworking::where('user_id',$User->id)->where('company_name','=',$companyname)->where('date',$request->date)->where('time',$request->time)->first();

        if(!is_null($meeting))
        {
            Toastr::error('Please Check The Details Because You Have Already Meeting In That Slot!.Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        else
        { 
            if(is_null($request->tag_user))
            {
                $user_meeting = UserNetworking::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh,
                                    'company_status' => $request->company,
                                    'company_name' => $companyname,
                                    'client_name' => $request->client_name,
                                    'client_mobile' => $request->client_mobile,
                                    'date' => $request->date,
                                    'time' => $request->time,
                                    'duration' => $request->duration,
                                    'eta' => $request->expected_time,
                                    'location' => $request->location,
                                    'purpose_of_meeting' => $request->purpose_of_working                                
                                ]);               

                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
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

                Mail::to($send_to)->send(new UsersNetworking($User,$user_meeting,$cc,$User_details));

            }else{
               
                foreach($request->tag_user as $tag_user){
                    $tag_meeting = UserNetworking::where('user_id',$tag_user)->where('company_name','=',$companyname)->where('date',$request->date)->where('time',$request->time)->first(); 

                    if($tag_meeting)
                    {
                        Toastr::error('Please Check Tag Users Already Having Meeting In That Slot!. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }                   
                }

                $user_meeting = UserNetworking::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh,
                                    'company_status' => $request->company,
                                    'company_name' => $companyname,
                                    'client_name' => $request->client_name,
                                    'client_mobile' => $request->client_mobile,
                                    'date' => $request->date,
                                    'time' => $request->time,
                                    'duration' => $request->duration,
                                    'eta' => $request->expected_time,
                                    'location' => $request->location,
                                    'purpose_of_meeting' => $request->purpose_of_working                                
                                ]);

                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$User->id)->first();
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
                Mail::to($send_to)->send(new UsersNetworking($User,$user_meeting,$cc,$User_details));

                foreach($request->tag_user as $tag_user){
                    $TagUser = User::find($tag_user);
                    $Tag_details = UserDetails::where('user_id', $TagUser->id)->first();

                    $Tag_meeting =  UserNetworking::create([
                                        'user_id' => $TagUser->id,
                                        'branch' => $TagUser->branch,
                                        'tl' => $Tag_details->tl,
                                        'rm' => $Tag_details->rm,
                                        'rh' => $Tag_details->rh,
                                        'company_status' => $request->company,
                                        'company_name' => $companyname,
                                        'client_name' => $request->client_name,
                                        'client_mobile' => $request->client_mobile,
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
                    Mail::to($send_to)->send(new UsersNetworking($TagUser,$Tag_meeting,$cc,$Tag_details));
                }
            }

            Toastr::success('You Have Successfully Submitted Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();           
        }   
    }

    public function networkingmeetinglist()
    {
        $user = Auth::user(); 
        $States = States::all();
        $userbranch = Branch::find($user->branch);      
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $meetings = UserNetworking::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $meetings = UserNetworking::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){                               
                $meetings = UserNetworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 2 || $user->branch == 5){
                $meetings = UserNetworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $meetings = UserNetworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }       
        }else{
                $meetings = UserNetworking::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }       
      
        return view('user.meeting.networking_list',compact('meetings','States'));
    }
}
