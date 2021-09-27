<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutOfStationStatus;
use App\Mail\OutOfStation;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use Carbon\Carbon;
use App\User;
use App\UserDetails;
use App\Branch;
use App\UserOutOfStation;

class UserOutOfStationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function outofstation()
    {
        $user = Auth::user(); 
        $userbranch = Branch::find($user->branch);      
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $OutStations = UserOutOfStation::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $OutStations = UserOutOfStation::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $OutStations = UserOutOfStation::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 2 || $user->branch == 5){
                $OutStations = UserOutOfStation::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $OutStations = UserOutOfStation::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 4){
                $OutStations = UserOutOfStation::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();    
            }        
        }else{
                $OutStations = UserOutOfStation::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }       
      
    	return view('user.outofstation.out_of_station',compact('OutStations','user'));
    }

    public function add_outofstation(Request $request)
    {
       	$request->validate([
                'work_purpose' => ['required'],                
                'event_name' => ['required'],  
                'departure_date' => ['required'],
                'departure_time' => ['required'],  
                'arrival_date' => ['required'], 
                'arrival_time' => ['required'], 
                'event_date' => ['required'],  
                'location' => ['required'], 
                'mode_of_travel' => ['required'], 
        ], [
                'work_purpose.required' => 'Please Select Purpose Of Work',                   
                'event_name.required' => 'Please Enter Event/Meeting/Recce Name',   
                'departure_date.required' => 'Please Select Departure Date',
                'departure_time.required' =>'Please Enter Departure Time',  
                'arrival_date.required' => 'Please Select Arrival Date',
                'arrival_time.required' =>'Please Enter Arrival Time',   
                'event_date.required' =>'Please Select Event/Meeting/Recce Date',  
                'location.required' => 'Please Enter Event/Meeting/Recce Location',
                'mode_of_travel.required' =>'Please Select Mode Of Travel',               
        ]);  

        $User = Auth::user();
        $UserName = $User->first_name.' '.$User->last_name;  
        $UserDetails = UserDetails::where('user_id',$User->id)->first();

        
        if($User->user_position == 1)
        {
            $level = 2;
        }
        elseif($User->user_position == 2 || $User->user_position == 3 || $User->user_position == 5)
        {
            $level = 1;
        }
        elseif($User->user_position == 4)
        {
            $level = 0;
        }   


        $departure_date = Carbon::parse($request->departure_date)->format('Y-m-d');
        $arrival_date = Carbon::parse($request->arrival_date)->format('Y-m-d');
        $event_date = Carbon::parse($request->event_date)->format('Y-m-d');

        $Today = Carbon::today();

        $Outs = UserOutOfStation::where('user_id',$User->id)->where('departure_date','=',$departure_date)->where('arrival_date','=',$arrival_date)->first();

        if(!is_null($Outs))
        {
            Toastr::Error('Out Station Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();   
        }else{

            $Latest = UserOutOfStation::create([
                'user_id' => $User->id,
                'branch' => $User->branch,
                'tl' => $UserDetails->tl,
                'rm' => $UserDetails->rm,
                'rh' => $UserDetails->rh,
                'purpose_of_work' => $request->work_purpose,
                // 'purpose_of_travel' => $request->travel_purpose,
                'departure_date' => $departure_date,
                'departure_time' => $request->departure_time,
                'arrival_date' => $arrival_date,
                'arrival_time' => $request->arrival_time,
                'event_date' => $event_date,
                'event_name' => $request->event_name,
                'event_location' => $request->location,
                'travel_mode' => $request->mode_of_travel, 
                'admin_status' => 'Pending',              
                'level' => $level,
            ]);

            $Startdate = Carbon::parse($departure_date);
            $Enddate = Carbon::parse($arrival_date);

            $all_dates = array();
            while ($Startdate->lte($Enddate)){
              $all_dates[] = $Startdate->toDateString();

              $Startdate->addDay();
            }

            foreach($all_dates as $date)
            {
                $Event_date = Carbon::parse($date);

                $day = $Event_date->day;

                $number = new ConvertNumber(); 
                $num_word = $number->numberTowords($day);

                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence = BangaloreAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$User->id)->first(); 

                    if($User_Attendence)
                    {
                        $User_Attendence->$num_word = 'NOS';
                        $User_Attendence->save(); 
                    }                                          
                }
                elseif($User->branch == 2 || $User->branch == 5)
                {
                    $User_Attendence = MumbaiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$User->id)->first();

                    if($User_Attendence)
                    {
                        $User_Attendence->$num_word = 'NOS';
                        $User_Attendence->save(); 
                    }                                                                              
                }   
                elseif($User->branch == 3)
                {
                    $User_Attendence = DelhiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$User->id)->first();
                    
                    if($User_Attendence)
                    {
                        $User_Attendence->$num_word = 'NOS';
                        $User_Attendence->save(); 
                    }                                             
                }
            }


            $Mail = new SendMail();
            $cc = $Mail->getusers($User,$UserDetails);                    
           
            $send_to = User::find($UserDetails->tl);                   
           
            Mail::to($send_to)->send(new OutOfStation($User,$Latest,$cc,$UserDetails));

            Toastr::success('We appreciate you travelling for work. Wish you a Happy Journey and a Successful Event. ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();   
       }
    }

    public function update_outofstation(Request $request)
    {
        $User = Auth::user();    
        $UserDetails = UserDetails::where('user_id',$User->id)->first();
        $Username =  $User->first_name.' '.$User->last_name;
       
        if(is_null($request->status) || is_null($request->comment))
        {
            Toastr::error('Please Update The Form Before You Submit!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        else
        {
            $Status = $request->status;
            $Comment = $request->comment .' - '. $User->first_name.' '.$User->last_name;        

            $OutStation = UserOutOfStation::find($request->id);

            $OutStation_User = User::find($OutStation->user_id);  
            $UserName = $OutStation_User->first_name.' '.$OutStation_User->last_name; 
            $Admin =  User::first();    
            $User_tl = User::find($OutStation->tl);
            $User_rm = User::find($OutStation->rm);
            $User_rh = User::find($OutStation->rh);            
            $RmName = $User_rm->first_name.' '.$User_rm->last_name;
            $RhName = $User_rh->first_name.' '.$User_rh->last_name;

            //////////////////////////////////Mail////////////////////////////

            if(is_null($User_tl)){
                $tl = $User_rm->email;
                $TlName = $User_rm->first_name.' '.$User_rm->last_name;
            }else{
                $tl = $User_tl->email;
                $TlName = $User_tl->first_name.' '.$User_tl->last_name;
            }
            
            $rm = $User_rm->email;            
           
            $rh = $User_rh->email;      

          
            if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
            {               
                $hrs = User::where('branch','=',1)->where('user_position',5)->where('status','=','active')->get();
            }
            elseif($User->branch == 2 || $User->branch == 3 || $User->branch == 5)
            {
                $hrs = User::where('branch','=',2)->where('user_position',5)->where('status','=','active')->get();
            }  

            foreach($hrs as $key => $Hr)
            {
                $hr[$key] = $Hr->email;
            }

            $cc = array_merge((array)$Admin->email,(array)$tl,(array)$rm,(array)$rh,$hr);
            //////////////////////////////////////////////////////////////


            $Startdate = Carbon::parse($OutStation->departure_date);
            $Enddate = Carbon::parse($OutStation->arrival_date);

            $all_dates = array();
            while ($Startdate->lte($Enddate)){
              $all_dates[] = $Startdate->toDateString();

              $Startdate->addDay();
            }
             
            if(!is_null($OutStation)){

                if($OutStation->level == '0')
                {

                    if($User->user_position == '1')
                    {   
                        if($OutStation->rm == '1' && $OutStation->rh == '1')
                        {
                            $OutStation->admin_status = $request->status;
                            $OutStation->attendence_status = 1;
                            $OutStation->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Outstation_date = Carbon::parse($date);

                                $day = $Outstation_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 2 || $User->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }    
                                }
                            }
                        }
                        elseif($OutStation->rm != '1' && $OutStation->rh == '1')
                        {
                            if($request->status == "Rejected")
                            {
                                $OutStation->admin_status = $request->status;
                                $OutStation->attendence_status = 1;
                                $OutStation->level = 3;

                                foreach($all_dates as $date)
                                {
                                    $Outstation_date = Carbon::parse($date);

                                    $day = $Outstation_date->day;

                                    $number = new ConvertNumber(); 
                                    $num_word = $number->numberTowords($day);

                                    if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                    {
                                        $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                    elseif($User->branch == 2 || $User->branch == 5)
                                    {
                                        $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }   
                                    elseif($User->branch == 3)
                                    {   
                                        $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }    
                                    }   
                                }
                            }
                            else
                            {                                
                                $OutStation->level = 2;
                            }                                                       
                        }
                        elseif ($OutStation->rm != '1' && $OutStation->rh != '1') 
                        {
                            $OutStation->admin_status = $request->status;
                            $OutStation->attendence_status = 1;
                            $OutStation->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Outstation_date = Carbon::parse($date);

                                $day = $Outstation_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 2 || $User->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }    
                                }
                            }
                        }                     
                        
                        $OutStation->admin_comment = $Comment;
                        
                        $OutStation->save();   

                        Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$Username,$UserDetails));                                  
                    }
                    else
                    {
                        if($request->status == "Rejected")
                        {
                            $OutStation->admin_status = $request->status;
                            $OutStation->admin_comment = $Comment;
                            $OutStation->attendence_status = 1;
                            $OutStation->level = 3;
                            $OutStation->save();

                            foreach($all_dates as $date)
                            {
                                $Outstation_date = Carbon::parse($date);

                                $day = $Outstation_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day); 

                                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {                                  
                                        $User_Attendence->$num_word = 'ROS';
                                        $User_Attendence->save();                                    
                                    }
                                }
                                elseif($User->branch == 2 || $User->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {                                  
                                        $User_Attendence->$num_word = 'ROS';
                                        $User_Attendence->save();                                    
                                    }
                                }   
                                elseif($User->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {                                  
                                        $User_Attendence->$num_word = 'ROS';
                                        $User_Attendence->save();                                    
                                    }    
                                }  
                            }

                        }
                        else
                        {
                            $OutStation->admin_comment = $Comment;
                            $OutStation->level = 1;
                            $OutStation->save();
                        }
                    }
                   
                    Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$Username,$UserDetails));

                    Toastr::success('You Have Successfully Updated Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();  

                }elseif($OutStation->level == '1'){

                    if($User->user_position == '1'){
                       
                        if($OutStation->rm == '1' && $OutStation->rh == '1')
                        {
                            $OutStation->admin_status = $request->status;
                            $OutStation->attendence_status = 1;
                            $OutStation->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Outstation_date = Carbon::parse($date);

                                $day = $Outstation_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 2 || $User->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }    
                                }
                            }
                        }
                        elseif($OutStation->rm != '1' && $OutStation->rh == '1')
                        {
                            if($request->status == "Rejected")
                            {
                                $OutStation->admin_status = $request->status;
                                $OutStation->attendence_status = 1;
                                $OutStation->level = 3;

                                foreach($all_dates as $date)
                                {
                                    $Outstation_date = Carbon::parse($date);

                                    $day = $Outstation_date->day;

                                    $number = new ConvertNumber(); 
                                    $num_word = $number->numberTowords($day);

                                    if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                    {
                                        $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                    elseif($User->branch == 2 || $User->branch == 5)
                                    {
                                        $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }   
                                    elseif($User->branch == 3)
                                    {   
                                        $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }    
                                    }   
                                }
                            }
                            else
                            {                                
                                $OutStation->level = 2;
                            } 
                        }
                        elseif ($OutStation->rm != '1' && $OutStation->rh != '1') 
                        {
                            $OutStation->admin_status = $request->status;
                            $OutStation->attendence_status = 1;
                            $OutStation->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Outstation_date = Carbon::parse($date);

                                $day = $Outstation_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);                                

                                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 2 || $User->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                }
                                elseif($User->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                        else
                                        {
                                            $User_Attendence->$num_word = 'OS';
                                            $User_Attendence->save(); 
                                        }
                                    }    
                                }
                            }  
                        }   

                        $OutStation->admin_comment = $Comment;                        

                        Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$Username,$UserDetails));

                    }else{
                            if($request->status == "Rejected"){
                                $OutStation->admin_status = $request->status;
                                $OutStation->admin_comment = $Comment;
                                $OutStation->attendence_status = 1;
                                $OutStation->level = 3;
                                $OutStation->save();

                                foreach($all_dates as $date)
                                {
                                    $Outstation_date = Carbon::parse($date);

                                    $day = $Outstation_date->day;

                                    $number = new ConvertNumber(); 
                                    $num_word = $number->numberTowords($day);

                                    if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                                    {
                                        $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }
                                    elseif($User->branch == 2 || $User->branch == 5)
                                    {
                                        $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }
                                    }   
                                    elseif($User->branch == 3)
                                    {   
                                        $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            $User_Attendence->$num_word = 'ROS';
                                            $User_Attendence->save(); 
                                        }    
                                    }   
                                }

                            }else{
                                $OutStation->admin_comment = $Comment;
                                $OutStation->level = 2;
                            }
                           

                        Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$Username,$UserDetails));               
                    }                    

                    $OutStation->save();
                    Toastr::success('You Have Successfully Updated Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();  


                }elseif($OutStation->level == '2'){
                    $OutStation->admin_status = $Status;
                    $OutStation->admin_comment = $Comment;
                    $OutStation->attendence_status = 1;
                    $OutStation->level = 3;
                    $OutStation->save();

                    foreach($all_dates as $date)
                    {
                        $Outstation_date = Carbon::parse($date);

                        $day = $Outstation_date->day;

                        $number = new ConvertNumber(); 
                        $num_word = $number->numberTowords($day);

                        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                        {
                            $User_Attendence = BangaloreAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    $User_Attendence->$num_word = 'ROS';
                                    $User_Attendence->save();
                                }
                                else
                                {
                                    $User_Attendence->$num_word = 'OS';
                                    $User_Attendence->save();
                                }
                            }
                        }
                        elseif($User->branch == 2 || $User->branch == 5)
                        {
                            $User_Attendence = MumbaiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    $User_Attendence->$num_word = 'ROS';
                                    $User_Attendence->save();
                                }
                                else
                                {
                                    $User_Attendence->$num_word = 'OS';
                                    $User_Attendence->save();
                                }
                            }
                        }
                        elseif($User->branch == 3)
                        {   
                            $User_Attendence = DelhiAttendence::where('year','=',$Outstation_date->year)->where('month','=',$Outstation_date->month)->where('user_id','=',$OutStation->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    $User_Attendence->$num_word = 'ROS';
                                    $User_Attendence->save();
                                }
                                else
                                {
                                    $User_Attendence->$num_word = 'OS';
                                    $User_Attendence->save();
                                }
                            }    
                        }
                    }  
                    

                    Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$Username,$UserDetails));

                    Toastr::success('You Have Successfully Updated Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();  
                }

            }else{
                Toastr::error('Please Check The details Before Update!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
        }        
    }
    
}
