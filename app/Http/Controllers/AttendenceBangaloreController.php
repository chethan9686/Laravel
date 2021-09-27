<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BangaloreAttendenceImport;
use App\Imports\DownloadBangalore;
use Toastr;
use Carbon\Carbon;
use App\Mail\UserLateComing;
use App\Mail\UserHalfDayComing;
use App\Mail\UserSecondHalfComing;
use App\Mail\UserAbsent;
use App\Mail\UserAbAfterMeeting;
use App\Mail\UserLaAfterMeeting;
use App\Mail\UserSimNotAtMeeting;
use App\Mail\UserInActiveSim;
use App\Mail\UserNotReported;
use App\Mail\UserEarlyDeparture;
use App\Mail\UserAbsentWithoutIdCard;
use App\BangalorePunchIn;
use App\BangaloreAttendence;
use App\UserMeeting;
use App\UserDetails;
use App\VendorMeeting;
use App\Preeventmeeting;
use App\Delivery;
use App\Dismental;
use App\UserLateworking;
use App\UserOutOfStation;
use App\UserLeave;
use App\Event;
use App\EventSetup;
use App\Recce;
use App\User;
use Log;
use DB;


class AttendenceBangaloreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

     public function attendence()
    {      
        return view('user.attendence.bangalore.index');
    }   

    public function attendencelist()
    {
        $Current = NULL;
        $Month = Carbon::now();
        $LastMonth = $Month->subMonth()->format('F');

        $today = Carbon::now();
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }
        
        $attendence_datas = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get(); 

        foreach($attendence_datas as $data)
        {           
            $this->calculate_bangalore_attendence($data->id);
        }

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get(); 
        
        return view('user.attendence.bangalore.attendence_list',compact('users','calendar','Current','LastMonth'));
    }
    
    public function previousattendencelist()
    {
        $Current = Carbon::now();
        $Month = Carbon::now();
        $today = $Month->subMonth();

        $LastMonth = NULL;
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }
        
        $attendence_datas = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get(); 

        foreach($attendence_datas as $data)
        {           
            $this->calculate_bangalore_attendence($data->id);
        }

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get(); 
        
        return view('user.attendence.bangalore.attendence_list',compact('users','calendar','Current','LastMonth'));
    }

    public function update_attendence(Request $request)
    {
        $Attendence = BangaloreAttendence::find($request->id);
        $column_name = $request->column_name;
        $Attendence->$column_name = $request->column_value;
        $Attendence->save();

        $data = array(
            "emp_name" => $Attendence->emp_name,
            "column" => $column_name,           
        );     
        echo json_encode($data);        
    }

    public function uploadpunchindetails(Request $request)
    {  
        if($request->hasFile('attendence_file'))
        {
            $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw");

            $result = array($request->file('attendence_file')->getClientOriginalExtension());

            if(in_array($result[0],$extensions))
            {         	
            	$file = $request->file('attendence_file');	   
            	$storeFile = "Attendence_".date('Y-m-d_h_i_s').'.'.$file->extension();
                $file->storeAs('public/Attendences',$storeFile);

                Excel::import(new BangaloreAttendenceImport, $file);

                $Latest = BangalorePunchIn::orderBy('id', 'DESC')->first();

                $date = Carbon::parse($Latest->date); 

                $day = $date->day;

                $today = Carbon::parse($Latest->date.'7:00:00');

                $ytoday = Carbon::parse($Latest->date.'7:00:00');
                $yesterday = $ytoday->subDay();              
                $yesterday = Carbon::parse( $yesterday->format('Y-m-d').'21:00:00');

                $users = BangaloreAttendence::where('year','=',$date->year)->where('month','=',$date->month)->distinct()->get(); 

                foreach ($users as $key => $user) 
                {
                    $punch_in = BangalorePunchIn::where('date','=',$date->format('Y-m-d'))->where('emp_id','=',$user->emp_id)->first();

                    $number = new ConvertNumber(); 
                    $num_word = $number->numberTowords($day);  

                    if(!is_null($punch_in))
                    {               
                        if(is_null($user->$num_word))
                        {              
                            if($punch_in->time < '09:46:00')
                            {
                                $user->$num_word = 'P'; 
                                $user->save();                  
                            }   

                            if($punch_in->time > '09:46:01' && $punch_in->time < '10:16:00')
                            {      
                                $Details = UserDetails::where('emp_id','=',$punch_in->emp_id)->first();                             

                                $Meeting = UserMeeting::where('user_id','=',$Details->user_id)->where('date','=',$date->format('Y-m-d'))->where('time','<=','11:30')->first();

                                $Vendor = VendorMeeting::where('user_id','=',$Details->user_id)->where('vendor_dateofmeeting','=',$date->format('Y-m-d'))->where('vendor_time','<=','11:30:00')->first();

                                $PreEvent = Preeventmeeting::where('user_id','=',$Details->user_id)->where('pem_dateofmeeting','=',$date->format('Y-m-d'))->where('pem_time','<=','11:30:00')->first();

                                $Delivery = Delivery::where('user_id','=',$Details->user_id)->where('delry_dateofdelivery','=',$date->format('Y-m-d'))->where('delry_time','<=','11:30:00')->first();

                                $Dismantle = Dismental::where('user_id','=',$Details->user_id)->where('dis_dateofdismantle','=',$date->format('Y-m-d'))->where('dis_time','<=','11:30:00')->first();

                                $Recce = Recce::where('user_id','=',$Details->user_id)->where('recce_dateofrecce','=',$date->format('Y-m-d'))->where('recce_time','<=','11:30:00')->first();

                                $Lateworking = UserLateworking::where('user_id','=',$Details->user_id)->where('created_at','>=',$yesterday)->where('created_at','<=',$today)->first();

                                $OutStation = UserOutOfStation::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Leave = UserLeave::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Event = Event::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Eventsetup = EventSetup::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();
                                
                                $User = User::find($Details->user_id);

                                $Mail = new SendMail();
                                $cc = $Mail->getusers($User,$Details); 

                                $tl = User::find($Details->tl);

                                $cc = array_merge((array)$tl->email,$cc);

                                array_splice($cc, 2, 1); 


                                if(!is_null($Meeting) || !is_null($Vendor) || !is_null($PreEvent) || !is_null($Delivery) || !is_null($Dismantle) || !is_null($Recce))
                                {
                                    $user->$num_word = 'M';  
                                    $user->save();   
                                }
                                elseif (!is_null($Lateworking)) 
                                {
                                    if($punch_in->time < '11:30:00')
                                    {
                                        $user->$num_word = 'P'; 
                                        $user->save();
                                    }
                                    elseif($punch_in->time > '11:30:00' && $punch_in->time < '14:00:00')
                                    {
                                        $user->$num_word = 'NHD';  
                                        $user->save();
                                        Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LW")); 
                                    }
                                    elseif($punch_in->time > '14:00:00')
                                    {
                                        $user->$num_word = 'AB';    
                                        $user->save(); 
                                        Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA")); 
                                    }                           
                                }
                                elseif(!($OutStation->isEmpty()))
                                {
                                    foreach ($OutStation as $key => $os) {
                                        $depart_date = Carbon::parse($os->departure_date);
                                        $arrival_date = Carbon::parse($os->arrival_date);
                                        $check = $date->between($depart_date,$arrival_date);                                       

                                        if($os->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'OS';    
                                                $user->save(); 
                                            }
                                            else
                                            {   
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = substr($punch_in->time,0,5); 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                                }
                                            }                                      
                                        }else
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'NOS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = substr($punch_in->time,0,5); 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                                }
                                            }                                     
                                        }

                                        if($arrival_date->eq($date))
                                        {
                                            $os->attendence_status = 1;
                                            $os->save();
                                        }
                                    }
                                }
                                elseif(!($Leave->isEmpty()))
                                {
                                    foreach ($Leave as $key => $leave) {
                                        $start_date = Carbon::parse($leave->start_date);
                                        $end_date = Carbon::parse($leave->end_date);
                                        $check = $date->between($start_date,$end_date);

                                        if($leave->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {                                        
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "FDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "FDL";
                                                        $user->save();
                                                    }                                                   
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "HDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "HDL";
                                                        $user->save();
                                                    }                                                    
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = substr($punch_in->time,0,5); 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                                }
                                            }                                      
                                        }
                                        else
                                        {                                    
                                            if($check)
                                            {
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NFDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NFDL";
                                                        $user->save();
                                                    }  
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NHDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NHDL";
                                                        $user->save();
                                                    } 
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = substr($punch_in->time,0,5); 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                                }
                                            }                                     
                                        }

                                        if($end_date->eq($date))
                                        {
                                            $leave->attendence_status = 1;
                                            $leave->save();
                                        }
                                    }
                                }
                                elseif(!($Event->isEmpty()))
                                {
                                    foreach ($Event as $key => $event) {
                                        $start_date = Carbon::parse($event->eventfromdate);
                                        $end_date = Carbon::parse($event->eventtodate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = substr($punch_in->time,0,5); 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                            }
                                        }     

                                        if($end_date->eq($date))
                                        {
                                            $event->attendence_status = 1;
                                            $event->save();
                                        }
                                    }
                                }
                                elseif(!($Eventsetup->isEmpty()))
                                {
                                    foreach ($Eventsetup as $key => $setup) {
                                        $start_date = Carbon::parse($setup->setup_eventstartdate);
                                        $end_date = Carbon::parse($setup->setup_eventenddate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = substr($punch_in->time,0,5); 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                            }
                                        }   

                                        if($end_date->eq($date))
                                        {
                                            $setup->attendence_status = 1;
                                            $setup->save();
                                        }
                                    }
                                }
                                else
                                {   
                                    if(is_null($user->$num_word))
                                    {
                                        $user->$num_word = substr($punch_in->time,0,5);
                                        $user->save();
                                        Mail::to($User)->send(new UserLateComing($User,$punch_in,$cc));
                                    }
                                }
                            }

                            if($punch_in->time > '10:16:01' && $punch_in->time < '14:00:00')
                            {
                                $Details = UserDetails::where('emp_id','=',$punch_in->emp_id)->first();
                                
                                $Meeting = UserMeeting::where('user_id','=',$Details->user_id)->where('date','=',$date->format('Y-m-d'))->where('time','<=','11:30')->first();

                                $Vendor = VendorMeeting::where('user_id','=',$Details->user_id)->where('vendor_dateofmeeting','=',$date->format('Y-m-d'))->where('vendor_time','<=','11:30:00')->first();

                                $PreEvent = Preeventmeeting::where('user_id','=',$Details->user_id)->where('pem_dateofmeeting','=',$date->format('Y-m-d'))->where('pem_time','<=','11:30:00')->first();

                                $Delivery = Delivery::where('user_id','=',$Details->user_id)->where('delry_dateofdelivery','=',$date->format('Y-m-d'))->where('delry_time','<=','11:30:00')->first();

                                $Dismantle = Dismental::where('user_id','=',$Details->user_id)->where('dis_dateofdismantle','=',$date->format('Y-m-d'))->where('dis_time','<=','11:30:00')->first();

                                $Recce = Recce::where('user_id','=',$Details->user_id)->where('recce_dateofrecce','=',$date->format('Y-m-d'))->where('recce_time','<=','11:30:00')->first();

                                $Lateworking = UserLateworking::where('user_id','=',$Details->user_id)->where('created_at','>=',$yesterday)->where('created_at','<=',$today)->first();

                                $OutStation = UserOutOfStation::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Leave = UserLeave::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Event = Event::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Eventsetup = EventSetup::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $User = User::find($Details->user_id);

                                $Mail = new SendMail();
                                $cc = $Mail->getusers($User,$Details); 

                                $tl = User::find($Details->tl);

                                $cc = array_merge((array)$tl->email,$cc);

                                array_splice($cc, 2, 1);  

                                if(!is_null($Meeting) || !is_null($Vendor) || !is_null($PreEvent) || !is_null($Delivery) || !is_null($Dismantle) || !is_null($Recce))
                                {
                                    $user->$num_word = 'M';  
                                    $user->save();   
                                }
                                elseif (!is_null($Lateworking)) 
                                {
                                    if($punch_in->time < '11:30:00')
                                    {
                                        $user->$num_word = 'P'; 
                                        $user->save();
                                    }
                                    elseif($punch_in->time > '11:30:00' && $punch_in->time < '14:00:00')
                                    {
                                        $user->$num_word = 'NHD';  
                                        $user->save();   
                                        Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LW"));     
                                    }
                                    elseif($punch_in->time > '14:00:00')
                                    {
                                        $user->$num_word = 'AB'; 
                                        $user->save(); 
                                        Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA")); 
                                    } 
                                }
                                elseif(!($OutStation->isEmpty()))
                                {
                                    foreach ($OutStation as $key => $os) {
                                        $depart_date = Carbon::parse($os->departure_date);
                                        $arrival_date = Carbon::parse($os->arrival_date);
                                        $check = $date->between($depart_date,$arrival_date);

                                        if($os->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'OS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'NHD'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                                }
                                            }                                      
                                        }else
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'NOS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'NHD'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                                }
                                            }                                     
                                        }
                                        
                                        if($arrival_date->eq($date))
                                        {
                                            $os->attendence_status = 1;
                                            $os->save();
                                        }
                                    }
                                }
                                elseif(!($Leave->isEmpty()))
                                {
                                    foreach ($Leave as $key => $leave) {
                                        $start_date = Carbon::parse($leave->start_date);
                                        $end_date = Carbon::parse($leave->end_date);
                                        $check = $date->between($start_date,$end_date);

                                        if($leave->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {                                        
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "FDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "FDL";
                                                        $user->save();
                                                    }                                                   
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "HDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "HDL";
                                                        $user->save();
                                                    }                                                    
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'NHD'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                                }
                                            }                                     
                                        }else
                                        {                                    
                                            if($check)
                                            {
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NFDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NFDL";
                                                        $user->save();
                                                    }  
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NHDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NHDL";
                                                        $user->save();
                                                    } 
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'NHD'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                                }
                                            }                                     
                                        }

                                        if($end_date->eq($date))
                                        {
                                            $leave->attendence_status = 1;
                                            $leave->save();
                                        }
                                    }
                                }
                                elseif(!($Event->isEmpty()))
                                {
                                    foreach ($Event as $key => $event) {
                                        $start_date = Carbon::parse($event->eventfromdate);
                                        $end_date = Carbon::parse($event->eventtodate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = 'NHD'; 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                            }
                                        }     

                                        if($end_date->eq($date))
                                        {
                                            $event->attendence_status = 1;
                                            $event->save();
                                        }
                                    }
                                }
                                elseif(!($Eventsetup->isEmpty()))
                                {
                                    foreach ($Eventsetup as $key => $setup) {
                                        $start_date = Carbon::parse($setup->setup_eventstartdate);
                                        $end_date = Carbon::parse($setup->setup_eventenddate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = 'NHD'; 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                            }
                                        }   

                                        if($end_date->eq($date))
                                        {
                                            $setup->attendence_status = 1;
                                            $setup->save();
                                        }
                                    }
                                }
                                else
                                {
                                    if(is_null($user->$num_word))
                                    {
                                        $user->$num_word = 'NHD';  
                                        $user->save(); 
                                        Mail::to($User)->send(new UserHalfDayComing($User,$punch_in,$cc,"LA"));
                                    }
                                }             
                            }
                           
                            if($punch_in->time > '14:01:00' && $punch_in->time < '18:00:00')
                            {
                                $Details = UserDetails::where('emp_id','=',$punch_in->emp_id)->first();    

                                $Meeting = UserMeeting::where('user_id','=',$Details->user_id)->where('date','=',$date->format('Y-m-d'))->where('time','<=','11:30')->first();

                                $Vendor = VendorMeeting::where('user_id','=',$Details->user_id)->where('vendor_dateofmeeting','=',$date->format('Y-m-d'))->where('vendor_time','<=','11:30:00')->first();

                                $PreEvent = Preeventmeeting::where('user_id','=',$Details->user_id)->where('pem_dateofmeeting','=',$date->format('Y-m-d'))->where('pem_time','<=','11:30:00')->first();

                                $Delivery = Delivery::where('user_id','=',$Details->user_id)->where('delry_dateofdelivery','=',$date->format('Y-m-d'))->where('delry_time','<=','11:30:00')->first();

                                $Dismantle = Dismental::where('user_id','=',$Details->user_id)->where('dis_dateofdismantle','=',$date->format('Y-m-d'))->where('dis_time','<=','11:30:00')->first();

                                $Recce = Recce::where('user_id','=',$Details->user_id)->where('recce_dateofrecce','=',$date->format('Y-m-d'))->where('recce_time','<=','11:30:00')->first();                  

                                $OutStation = UserOutOfStation::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Leave = UserLeave::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Event = Event::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Eventsetup = EventSetup::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();
                                
                                $User = User::find($Details->user_id);

                                $Mail = new SendMail();
                                $cc = $Mail->getusers($User,$Details); 

                                $tl = User::find($Details->tl);

                                $cc = array_merge((array)$tl->email,$cc);

                                array_splice($cc, 2, 1); 

                                if(!is_null($Meeting) || !is_null($Vendor) || !is_null($PreEvent) || !is_null($Delivery) || !is_null($Dismantle) || !is_null($Recce))
                                {
                                    $user->$num_word = 'M';  
                                    $user->save();   
                                }
                                elseif(!($OutStation->isEmpty()))
                                {
                                    foreach ($OutStation as $key => $os) {
                                        $depart_date = Carbon::parse($os->departure_date);
                                        $arrival_date = Carbon::parse($os->arrival_date);
                                        $check = $date->between($depart_date,$arrival_date);

                                        if($os->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'OS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'AB'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                                }
                                            }                                      
                                        }else
                                        {                                    
                                            if($check)
                                            {
                                                $user->$num_word = 'NOS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'AB'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                                }
                                            }                                     
                                        }
                                        
                                        if($arrival_date->eq($date))
                                        {
                                            $os->attendence_status = 1;
                                            $os->save();
                                        }
                                    }
                                }
                                elseif(!($Leave->isEmpty()))
                                {
                                    foreach ($Leave as $key => $leave) {
                                        $start_date = Carbon::parse($leave->start_date);
                                        $end_date = Carbon::parse($leave->end_date);
                                        $check = $date->between($start_date,$end_date);

                                        if($leave->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {                                        
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "FDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "FDL";
                                                        $user->save();
                                                    }                                                   
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "HDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "HDL";
                                                        $user->save();
                                                    }                                                    
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'AB'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                                }
                                            }                                     
                                        }else
                                        {                                    
                                            if($check)
                                            {
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NFDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NFDL";
                                                        $user->save();
                                                    }  
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NHDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NHDL";
                                                        $user->save();
                                                    } 
                                                }
                                            }
                                            else
                                            {
                                                if(is_null($user->$num_word))
                                                {
                                                    $user->$num_word = 'AB'; 
                                                    $user->save(); 
                                                    Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA")); 
                                                }
                                            }                                    
                                        }

                                        if($end_date->eq($date))
                                        {
                                            $leave->attendence_status = 1;
                                            $leave->save();
                                        }
                                    }
                                }
                                elseif(!($Event->isEmpty()))
                                {
                                    foreach ($Event as $key => $event) {
                                        $start_date = Carbon::parse($event->eventfromdate);
                                        $end_date = Carbon::parse($event->eventtodate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                            }
                                        }    

                                        if($end_date->eq($date))
                                        {
                                            $event->attendence_status = 1;
                                            $event->save();
                                        }
                                    }
                                }
                                elseif(!($Eventsetup->isEmpty()))
                                {
                                    foreach ($Eventsetup as $key => $setup) {
                                        $start_date = Carbon::parse($setup->setup_eventstartdate);
                                        $end_date = Carbon::parse($setup->setup_eventenddate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            if(is_null($user->$num_word))
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                                Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                            }
                                        }   

                                        if($end_date->eq($date))
                                        {
                                            $setup->attendence_status = 1;
                                            $setup->save();
                                        }
                                    }
                                }
                                else
                                {
                                    if(is_null($user->$num_word))
                                    {
                                        $user->$num_word = 'AB'; 
                                        $user->save();  
                                        Mail::to($User)->send(new UserSecondHalfComing($User,$punch_in,$cc,"BA"));  
                                    }
                                }                
                            }                                                      
                        }  
                    }
                    else
                    {   
                        if(is_null($user->$num_word)) 
                        {
                            $Details = UserDetails::where('emp_id','=',$user->emp_id)->first();  

                            $CheckUser = User::find($Details->user_id);  

                            if($CheckUser->branch == 1) 
                            {
                                $Meeting = UserMeeting::where('user_id','=',$Details->user_id)->where('date','=',$date->format('Y-m-d'))->where('time','<=','11:30')->first();

                                $Vendor = VendorMeeting::where('user_id','=',$Details->user_id)->where('vendor_dateofmeeting','=',$date->format('Y-m-d'))->where('vendor_time','<=','11:30:00')->first();

                                $PreEvent = Preeventmeeting::where('user_id','=',$Details->user_id)->where('pem_dateofmeeting','=',$date->format('Y-m-d'))->where('pem_time','<=','11:30:00')->first();

                                $Delivery = Delivery::where('user_id','=',$Details->user_id)->where('delry_dateofdelivery','=',$date->format('Y-m-d'))->where('delry_time','<=','11:30:00')->first();

                                $Dismantle = Dismental::where('user_id','=',$Details->user_id)->where('dis_dateofdismantle','=',$date->format('Y-m-d'))->where('dis_time','<=','11:30:00')->first();

                                $Recce = Recce::where('user_id','=',$Details->user_id)->where('recce_dateofrecce','=',$date->format('Y-m-d'))->where('recce_time','<=','11:30:00')->first();                  

                                $OutStation = UserOutOfStation::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Leave = UserLeave::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Event = Event::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();

                                $Eventsetup = EventSetup::where('user_id','=',$Details->user_id)->where('attendence_status','=','0')->whereMonth('created_at',$date->month)->orderBy('created_at','desc')->get();  
                                

                                if(!is_null($Meeting) || !is_null($Vendor) || !is_null($PreEvent) || !is_null($Delivery) || !is_null($Dismantle) || !is_null($Recce))
                                {                                   
                                    $user->$num_word = 'M';  
                                    $user->save();   
                                }
                                elseif(!($OutStation->isEmpty()))
                                {
                                    foreach ($OutStation as $key => $os) {
                                        $depart_date = Carbon::parse($os->departure_date);
                                        $arrival_date = Carbon::parse($os->arrival_date);
                                        $check = $date->between($depart_date,$arrival_date);

                                        if($os->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {                                                
                                                $user->$num_word = 'OS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                            }                                     
                                        }
                                        else
                                        {                                    
                                            if($check)
                                            {  
                                                $user->$num_word = 'NOS';    
                                                $user->save(); 
                                            }
                                            else
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                            }                                    
                                        }
                                        
                                        if($arrival_date->eq($date))
                                        {
                                            $os->attendence_status = 1;
                                            $os->save();
                                        }
                                    }
                                }
                                elseif(!($Leave->isEmpty()))
                                {
                                    foreach ($Leave as $key => $leave) {
                                        $start_date = Carbon::parse($leave->start_date);
                                        $end_date = Carbon::parse($leave->end_date);
                                        $check = $date->between($start_date,$end_date);                                      

                                        if($leave->admin_status == "Approved")
                                        {                                    
                                            if($check)
                                            {                                        
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "FDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "FDL";
                                                        $user->save();
                                                    }                                                   
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "HDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "HDL";
                                                        $user->save();
                                                    }                                                    
                                                }
                                            }
                                            else
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                            }                                   
                                        }
                                        else
                                        {                                    
                                            if($check)
                                            {
                                                if($leave->duration == "Full Day" || $leave->duration == "More Than 1 Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NFDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NFDL";
                                                        $user->save();
                                                    }  
                                                }
                                                elseif($leave->duration == "Half Day")
                                                {
                                                    if($leave->leave_type == "Comp Off"){
                                                        $user->$num_word = "NHDCO";
                                                        $user->save();
                                                    }
                                                    else{
                                                        $user->$num_word = "NHDL";
                                                        $user->save();
                                                    } 
                                                }
                                            }
                                            else
                                            {
                                                $user->$num_word = 'AB'; 
                                                $user->save(); 
                                            }                                     
                                        }

                                        if($end_date->eq($date))
                                        {
                                            $leave->attendence_status = 1;
                                            $leave->save();
                                        }
                                    }
                                }
                                elseif(!($Event->isEmpty()))
                                {
                                    foreach ($Event as $key => $event) {
                                        $start_date = Carbon::parse($event->eventfromdate);
                                        $end_date = Carbon::parse($event->eventtodate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {                                            
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            $user->$num_word = 'AB'; 
                                            $user->save(); 
                                        }    

                                        if($end_date->eq($date))
                                        {
                                            $event->attendence_status = 1;
                                            $event->save();
                                        }
                                    }
                                }
                                elseif(!($Eventsetup->isEmpty()))
                                {
                                    foreach ($Eventsetup as $key => $setup) {
                                        $start_date = Carbon::parse($setup->setup_eventstartdate);
                                        $end_date = Carbon::parse($setup->setup_eventenddate);
                                        $check = $date->between($start_date,$end_date);

                                        if($check)
                                        {                                           
                                            $user->$num_word = 'E';    
                                            $user->save(); 
                                        }
                                        else
                                        {
                                            $user->$num_word = 'AB'; 
                                            $user->save(); 
                                        }   

                                        if($end_date->eq($date))
                                        {
                                            $setup->attendence_status = 1;
                                            $setup->save();
                                        }
                                    }
                                }
                                else
                                {                                               
                                    $user->$num_word = 'AB'; 
                                    $user->save();  
                                } 
                            }                            
                        }             
                    }       

                }
                Toastr::success('You Have Successfully Uploaded File Sheet!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();  
            }
            else
            {
                Toastr::error('Please Check The File , It Should Be Xlsx File Sheet!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            } 
        }
        else
        {   
            Toastr::error('Please Upload The File Before Submit!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
    }

    public function calculate_bangalore_attendence($data)
    {        
        $Attendence = BangaloreAttendence::find($data);

        $data = array($Attendence->one,$Attendence->two,$Attendence->three,$Attendence->four,$Attendence->five,$Attendence->six,$Attendence->seven,$Attendence->eight,$Attendence->nine,$Attendence->ten,$Attendence->eleven,$Attendence->twelve,$Attendence->thirteen,$Attendence->fourteen,$Attendence->fifteen,$Attendence->sixteen,$Attendence->seventeen,$Attendence->eighteen,$Attendence->nineteen,$Attendence->twenty,$Attendence->twentyone,$Attendence->twentytwo,$Attendence->twentythree,$Attendence->twentyfour,$Attendence->twentyfive,$Attendence->twentysix,$Attendence->twentyseven,$Attendence->twentyeight,$Attendence->twentynine,$Attendence->thirty,$Attendence->thirtyone); 
        
        $P = array();
        $SUN = array();
        $H = array();
        $AB = array();
        $L = array();
        $M = array();
        $E = array();
        $OS = array();
        $CO = array();
        $COF = array();
        $LC = array();
        $NJ = array();
        $NHD = array();
        $HD = array();
        $LL = array();

        foreach($data as $dt)
        {
            if($dt == "SUN")
            {
                $dt = 1;
                array_push($SUN,$dt);
            }
            elseif($dt == "H")
            {
                $dt = 1;
                array_push($H,$dt);
            }
            elseif($dt == "NJ")
            {
                $dt = 1;
                array_push($NJ,$dt);
            }
            elseif($dt == "P")
            {
                $dt = 1;
                array_push($P,$dt);
            }   
            elseif($dt > '09:46' && $dt < '10:16')
            {
                $dt = 1;
                array_push($LC,$dt);
            }           
            elseif($dt == "M")
            {
                $dt = 1;
                array_push($M,$dt);
            }
            elseif($dt == "E")
            {
                $dt = 1;
                array_push($E,$dt);
            }
            elseif($dt == "OS")
            {
                $dt = 1;
                array_push($OS,$dt);
            }
            elseif($dt == "HDCO" || $dt == "FDCO")
            {
                if($dt == "HDCO")
                {
                    $dt = 0.5;
                    $dtc = 1;
                }
                if($dt == "FDCO")
                {
                    $dt = 1;
                    $dtc = 1;
                }
                array_push($CO,$dt);
                array_push($COF,$dtc);
            }
            elseif($dt == "AB" || $dt == "ABM")
            {
                if($dt == "AB" || $dt == "ABM")
                {
                    $dt = 1;
                }               
                array_push($AB,$dt);
            }
            elseif($dt == "HDL" || $dt == "FDL")
            {
                if($dt == "HDL")
                {
                    $dt = 0.5;
                    $dtl = 1;                    
                }
                if($dt == "FDL")
                {
                    $dt = 1;
                    $dtl = 1;  
                }               
                array_push($L,$dt);
                array_push($LL,$dtl);
            }
            elseif($dt == "NHD")
            {            
                $dt = 0.5;
                array_push($NHD,$dt);      
            }
            elseif($dt == "HD")
            {            
                $dt = 0.5;
                array_push($HD,$dt);      
            }
        }
        $P = array_sum($P);
        $M = array_sum($M);
        $E = array_sum($E);
        $OS = array_sum($OS);
        $CO = array_sum($CO);
        $COF = array_sum($COF);
        $L = array_sum($L);
        $AB = array_sum($AB);
        $SUN = array_sum($SUN);
        $H = array_sum($H);
        $LC = array_sum($LC);
        $NJ = array_sum($NJ);
        $NHD = array_sum($NHD);
        $HD = array_sum($HD);
        $LL = array_sum($LL);

        $Total = $SUN+$H+$P+$M+$E+$OS+$COF+$LL+$LC+$NJ+$NHD+$HD;

        $Attendence->present = $P;
        $Attendence->meeting = $M;
        $Attendence->event = $E;
        $Attendence->outstation = $OS;
        $Attendence->comp = $CO;
        $Attendence->paid_leave = $L+$HD;
        $Attendence->cut_leave = $AB+$NHD+$HD;
        $Attendence->working = $Total;
        $Attendence->save();    

        return back();   
    }

    public function download_attendence()
    {
        $today = Carbon::now();      
        $dates = []; 
        $heading = [];
        array_push($dates,'emp_name');
        
        array_push($heading,'Employeee Name');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $heading[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }
        
        array_push($dates,'present','meeting','event','outstation','comp','paid_leave','cut_leave','working');
        
        array_push($heading,'Present','Meeting','Event','Outstation','Comp','Paid_leave','Cut_leave','Working Days');

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->select($dates)->orderBy('emp_name','ASC')->get(); 
       
        return Excel::download(new DownloadBangalore($users,$heading), 'Bangalore_Employees.xlsx');
    }
    
    public function mail_attendence()
    {
        $today = Carbon::now();
        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get(); 

        $day = $today->day;

        $number = new ConvertNumber(); 
        $num_word = $number->numberTowords($day);  
        $absent_users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->where($num_word,'=','AB')->distinct()->orderBy('emp_name','ASC')->get(); 
       
        return view('user.attendence.bangalore.mail_attendence',compact('users','absent_users'));
    }

    public function bang_send_mail(Request $request)
    {
        $request->validate([
                'check_user' => ['required'],               
                'mail_date' => ['required'], 
                'leave_type' => ['required'], 
        ], [
                'check_user.required' => 'Please Select The Employee',                
                'mail_date.required' => 'Please Select Date To Send Mail',
                'leave_type.required' =>'Please Select Mail Type To Send Template',                
        ]);  

        foreach($request->check_user as $user)
        {
            $Send_User = User::find($user);
            $Details = UserDetails::where('user_id',$user)->first();
            $Date = Carbon::parse($request->mail_date);

            $Mail = new SendMail();
            $cc = $Mail->getusers($Send_User,$Details); 

            $tl = User::find($Details->tl);

            $cc = array_merge((array)$tl->email,$cc);
            array_splice($cc, 2, 1);                 

            switch ($request->leave_type) {
                case 1:
                    Mail::to($Send_User)->send(new UserAbsent($Send_User,$Date,$cc)); 
                break;            
                case 2:
                    Mail::to($Send_User)->send(new UserEarlyDeparture($Send_User,$Date,$cc));                     
                break;
                case 3:
                    Mail::to($Send_User)->send(new UserAbAfterMeeting($Send_User,$Date,$cc));                     
                break;
                case 4:
                    Mail::to($Send_User)->send(new UserLaAfterMeeting($Send_User,$Date,$cc));                    
                break;
                case 5:
                    Mail::to($Send_User)->send(new UserSimNotAtMeeting($Send_User,$Date,$cc));                     
                break;
                case 6:
                    Mail::to($Send_User)->send(new UserInActiveSim($Send_User,$Date,$cc));                     
                break;
                case 7:
                   Mail::to($Send_User)->send(new UserNotReported($Send_User,$Date,$cc));                  
                break;
                case 8:
                   Mail::to($Send_User)->send(new UserAbsentWithoutIdCard($Send_User,$Date,$cc)); 
                break;
            }
        }
        Toastr::success('You Have Successfully Sent Mail To User. Thank You!..',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
    
    
}