<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsersLeave;
use App\Mail\UsersLeaveStatus;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use Carbon\Carbon;
use App\User;
use App\UserDetails;
use App\UserLeave;
use App\Branch;
use Log;

class UserLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function index()
    {
    	$user = Auth::user(); 
    	return view('user.leave.index',compact('user'));
    }

    public function addleave(Request $request)
    {
       
    	$request->validate([
                'emp_name' => ['required'],               
                'leave_type' => ['required'], 
                'duration' => ['required'], 
                'start_date' => ['required'],         
                'reason' => ['required'], 
        ], [
                'emp_name.required' => 'Please Enter Employee Name',                
                'leave_type.required' => 'Please Select Leave Type To Apply',
                'duration.required' =>'Please Select Leave Duration',   
                'start_date.required' =>'Please Select Leave Start Date',       
                'reason.required' =>'Please Enter The Reason For Leave',               
        ]);  

        if($request->duration == "More Than 1 Day")
        {
        	if(is_null($request->end_date))
        	{
        		Toastr::Error('Please Select Leave Start and End Date!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            	return back();   
        	}else{
        		$end_date = Carbon::parse($request->end_date)->format('Y-m-d'); 
        	}
        }else{
        	$end_date = Carbon::parse($request->start_date)->format('Y-m-d');
        }

        $User = Auth::user();
        $UserName = $User->first_name.' '.$User->last_name;  
        $UserDetails = UserDetails::where('user_id',$User->id)->first();



        // Bangalore||Kolkata||Chennai 
        $Bang = Carbon::parse('today 1pm');   
        $current_day = Carbon::parse('today 11.58pm');
        // Now
        $now = Carbon::now(); 

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');  

        if(Carbon::parse($start_date)->eq(Carbon::parse($now->format('Y-m-d'))))
        {
            if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
            {
                if ($now->gte($Bang) && $now->lte($current_day))
                {
                    Toastr::Error('Please Apply Leave Before 2.30 PM!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();
                }
            }
        }

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

       

        $Leave = UserLeave::where('user_id',$User->id)->where('start_date',$request->start_date)->where('end_date',$request->start_date)->first(); 

        if($Leave)
        {
        	Toastr::Error('Please Check Leave Date Because You Have Already Applied For The Leave!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }else{
        	 	
    	 	if($request->leave_type == "Comp Off"){
            	$level = 2;
        	}

        	$user_leave = UserLeave::create([
			        		'user_id' => $User->id,
			                'branch' => $User->branch,
			                'tl' => $UserDetails->tl,
			                'rm' => $UserDetails->rm,
			                'rh' => $UserDetails->rh,
			                'emp_name' => $UserName,
			                'leave_type' => $request->leave_type,
			                'duration' => $request->duration,
			                'start_date' => $start_date,
			                'end_date' => $end_date,
			                'reason' => $request->reason,
			                'admin_status' => 'Pending',   
			                'level' => $level
			            ]);

            $Today = Carbon::today();
            $Startdate = Carbon::parse($start_date);
            $Enddate = Carbon::parse($end_date);

            $all_dates = array();
            while ($Startdate->lte($Enddate)){
              $all_dates[] = $Startdate->toDateString();

              $Startdate->addDay();
            }

            foreach($all_dates as $date)
            {
                $Leave_date = Carbon::parse($date);

                $day = $Leave_date->day;

                $number = new ConvertNumber(); 
                $num_word = $number->numberTowords($day);


                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {               
                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$User->id)->first();

                    if($User_Attendence)
                    {
                        if($request->leave_type == "Comp Off"){
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDCO';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDCO';
                                $User_Attendence->save();
                            }
                        }else{
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDL';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDL';
                                $User_Attendence->save();
                            }
                        }                           
                    }
                                 
                }
                elseif($User->branch == 2 || $User->branch == 5)
                {
                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$User->id)->first();

                    if($User_Attendence)
                    {
                        if($request->leave_type == "Comp Off"){
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDCO';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDCO';
                                $User_Attendence->save();
                            }
                        }else{
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDL';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDL';
                                $User_Attendence->save();
                            }
                        }
                    }
                                     
                }   
                elseif($User->branch == 3)
                {
                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$User->id)->first();
                   
                    if($User_Attendence)
                    {
                        if($request->leave_type == "Comp Off"){
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDCO';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDCO';
                                $User_Attendence->save();
                            }
                        }else{
                            if($request->duration == "Half Day")
                            {
                                $User_Attendence->$num_word = 'NHDL';
                                $User_Attendence->save();   
                            }else{
                                $User_Attendence->$num_word = 'NFDL';
                                $User_Attendence->save();
                            }
                        }
                    }          
                } 

            }

            $Mail = new SendMail();
            $cc = $Mail->getusers($User,$UserDetails);
            
            $send_to = User::find($UserDetails->tl);

            $when = now()->addMinutes(12);

            
           
           Mail::to($send_to)->later($when, new UsersLeave($User,$user_leave,$cc,$UserDetails));

            Toastr::success('You Have Successfully Submitted Leave Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
    }

    public function leavelist()
    {
    	$user = Auth::user(); 
        $userbranch = Branch::find($user->branch); 

        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $Leaves = UserLeave::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $Leaves = UserLeave::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $Leaves = UserLeave::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();  
            }elseif($user->branch == 2 || $user->branch == 5){
                $Leaves = UserLeave::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $Leaves = UserLeave::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 4){
                $Leaves = UserLeave::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();    
            }        
        }else{
                $Leaves = UserLeave::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }       
      
    	return view('user.leave.leave_list',compact('Leaves','user'));
    }

    public function updateleave(Request $request)
    {
        if(is_null($request->status) || is_null($request->comment))
        {
            Toastr::Error('Please Fill The Form For Updating Status Of Leave!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }

        $Auth = Auth::user();
        $AuthDetails = UserDetails::where('user_id',$Auth->id)->first();
        $AuthName = $Auth->first_name.' '.$Auth->last_name;

        $Leave = UserLeave::find($request->id);

        $Reason = $request->comment.' - '.$Auth->first_name.' '.$Auth->last_name;

        ///////////////////////////////Mail/////////////////////////////

        $Leave_User = User::find($Leave->user_id);  
        $UserName = $Leave_User->first_name.' '.$Leave_User->last_name; 
        $Admin =  User::first();   
        $User_tl = User::find($Leave->tl);
        $User_rm = User::find($Leave->rm);
        $User_rh = User::find($Leave->rh);            
        $RmName = $User_rm->first_name.' '.$User_rm->last_name;
        $RhName = $User_rh->first_name.' '.$User_rh->last_name;

        if(is_null($User_tl)){
            $tl = $User_rm->email;
            $TlName = $User_rm->first_name.' '.$User_rm->last_name;
        }else{
            $tl = $User_tl->email;
            $TlName = $User_tl->first_name.' '.$User_tl->last_name;
        }
        
        $rm = $User_rm->email;            
       
        $rh = $User_rh->email;      

        if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
        {               
            $hrs = User::where('branch','=',1)->where('user_position',5)->where('status','=','active')->get();
        }
        elseif($Auth->branch == 2 || $Auth->branch == 3 || $Auth->branch == 5)
        {
            $hrs = User::where('branch','=',2)->where('user_position',5)->where('status','=','active')->get();
        }  
        
        foreach($hrs as $key => $Hr)
        {
            $hr[$key] = $Hr->email;
        }

        $cc = array_merge((array)$Admin->email,(array)$tl,(array)$rm,(array)$rh,$hr);

        ///////////////////////////////////////////////////////////////////

        $Startdate = Carbon::parse($Leave->start_date);
        $Enddate = Carbon::parse($Leave->end_date);

        $all_dates = array();
        while ($Startdate->lte($Enddate)){
          $all_dates[] = $Startdate->toDateString();

          $Startdate->addDay();
        }
            
        if(!is_null($Leave))
        {
            if($Leave->leave_type == 'Comp Off')
            {
                if($Leave->rm == '1' && $Leave->rh == '1')
                {                   
                    $Leave->admin_status = $request->status;
                    $Leave->admin_comment = $Reason;
                    $Leave->attendence_status = 1;
                    $Leave->level = 3;
                    $Leave->save();

                    foreach($all_dates as $date)
                    {
                        $Leave_date = Carbon::parse($date);

                        $day = $Leave_date->day;

                        $number = new ConvertNumber(); 
                        $num_word = $number->numberTowords($day);                   


                        if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                        {
                            $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDCO';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDCO';
                                        $User_Attendence->save();
                                    }
                                }
                            }
                        }
                        elseif($Auth->branch == 2 || $Auth->branch == 5)
                        {
                            $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDCO';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDCO';
                                        $User_Attendence->save();
                                    }
                                }
                            }
                        }
                        elseif($Auth->branch == 3)
                        {   
                            $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDCO';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDCO';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDCO';
                                        $User_Attendence->save();
                                    }
                                }
                            }    
                        }
                    }                      
                }
                else{
                        if($request->status == "Rejected")
                        {
                            $Leave->admin_status = $request->status;
                            $Leave->admin_comment = $Reason;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;
                            $Leave->save();

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);                   


                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDCO';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDCO';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }    
                                }
                            }                              
                        }
                        else
                        {
                            $Leave->admin_comment = $Reason;
                            $Leave->level = 2;
                            $Leave->save();
                        } 
                }               

                Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails));

                Toastr::success('You Have Successfully Updated Leave Status!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
            else
            {
                if($Leave->level == '0')
                {   
                    if($Auth->user_position == '1')
                    {   
                        if($Leave->rm == '1' && $Leave->rh == '1')
                        {
                            $Leave->admin_status = $request->status;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }    
                                }
                            }
                        }
                        elseif($Leave->rm != '1' && $Leave->rh == '1')
                        {
                            if($request->status == "Rejected")
                            {
                                $Leave->admin_status = $request->status;
                                $Leave->attendence_status = 1;
                                $Leave->level = 3;

                                foreach($all_dates as $date)
                                {
                                    $Leave_date = Carbon::parse($date);

                                    $day = $Leave_date->day;

                                    $number = new ConvertNumber(); 
                                    $num_word = $number->numberTowords($day);

                                    if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                    {
                                        $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                    elseif($Auth->branch == 2 || $Auth->branch == 5)
                                    {
                                        $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }   
                                    elseif($Auth->branch == 3)
                                    {   
                                        $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }    
                                    }   
                                }
                            }
                            else
                            {                                
                                $Leave->level = 2;
                            }                                                       
                        }
                        elseif ($Leave->rm != '1' && $Leave->rh != '1') 
                        {
                            $Leave->admin_status = $request->status;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }    
                                }
                            }
                        }                     
                        
                        $Leave->admin_comment = $Reason;
                        
                        $Leave->save();   

                        Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails));                                    
                    }
                    else
                    {
                        if($request->status == "Rejected"){
                            $Leave->admin_status = $request->status;
                            $Leave->admin_comment = $Reason;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;
                            $Leave->save();

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }
                                }   
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }    
                                }   
                            }

                        }else{
                            $Leave->admin_comment = $Reason;
                            $Leave->level = 1;
                            $Leave->save();
                        }

                        Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails));
                    }               

                    Toastr::success('You Have Successfully Updated Leave Status!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();                
                }
                elseif($Leave->level == '1')
                {
                    if($Auth->user_position == '1')
                    {   
                        if($Leave->rm == '1' && $Leave->rh == '1')
                        {
                            $Leave->admin_status = $request->status;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }    
                                }
                            }
                        }
                        elseif($Leave->rm != '1' && $Leave->rh == '1')
                        {
                            if($request->status == "Rejected")
                            {
                                $Leave->admin_status = $request->status;
                                $Leave->attendence_status = 1;
                                $Leave->level = 3;

                                foreach($all_dates as $date)
                                {
                                    $Leave_date = Carbon::parse($date);

                                    $day = $Leave_date->day;

                                    $number = new ConvertNumber(); 
                                    $num_word = $number->numberTowords($day);

                                    if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                    {
                                        $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                    elseif($Auth->branch == 2 || $Auth->branch == 5)
                                    {
                                        $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }   
                                    elseif($Auth->branch == 3)
                                    {   
                                        $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                        if($User_Attendence)
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }    
                                    }   
                                }
                            }
                            else
                            {                                
                                $Leave->level = 2;
                            }                                                       
                        }
                        elseif ($Leave->rm != '1' && $Leave->rh != '1') 
                        {
                            $Leave->admin_status = $request->status;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }
                                }
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($request->status == "Rejected")
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'RHDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'RFDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                        else
                                        {
                                            if($Leave->duration == "Half Day")
                                            {
                                                $User_Attendence->$num_word = 'HDL';
                                                $User_Attendence->save();   
                                            }else{
                                                $User_Attendence->$num_word = 'FDL';
                                                $User_Attendence->save();
                                            }
                                        }
                                    }    
                                }
                            }
                        }                     
                        
                        $Leave->admin_comment = $Reason;
                        
                        $Leave->save();   

                        Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails));                                    
                    }
                    else
                    {
                        if($request->status == "Rejected"){
                            $Leave->admin_status = $request->status;
                            $Leave->admin_comment = $Reason;
                            $Leave->attendence_status = 1;
                            $Leave->level = 3;
                            $Leave->save();

                            foreach($all_dates as $date)
                            {
                                $Leave_date = Carbon::parse($date);

                                $day = $Leave_date->day;

                                $number = new ConvertNumber(); 
                                $num_word = $number->numberTowords($day);

                                if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                                {
                                    $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }
                                }
                                elseif($Auth->branch == 2 || $Auth->branch == 5)
                                {
                                    $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }
                                }   
                                elseif($Auth->branch == 3)
                                {   
                                    $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                                    if($User_Attendence)
                                    {
                                        if($Leave->duration == "Half Day")
                                        {
                                            $User_Attendence->$num_word = 'RHDL';
                                            $User_Attendence->save();   
                                        }else{
                                            $User_Attendence->$num_word = 'RFDL';
                                            $User_Attendence->save();
                                        }
                                    }    
                                }   
                            }

                        }else{
                            $Leave->admin_comment = $Reason;
                            $Leave->level = 2;
                            $Leave->save();
                        }

                        Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails)); 
                    }

                    Toastr::success('You Have Successfully Updated Leave Status!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();
                }
                elseif($Leave->level == '2') 
                {                
                    $Leave->admin_status = $request->status;
                    $Leave->admin_comment = $Reason;
                    $Leave->attendence_status = 1;
                    $Leave->level = 3;
                    $Leave->save();

                    foreach($all_dates as $date)
                    {
                        $Leave_date = Carbon::parse($date);

                        $day = $Leave_date->day;

                        $number = new ConvertNumber(); 
                        $num_word = $number->numberTowords($day);

                        if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7)
                        {
                            $User_Attendence = BangaloreAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDL';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDL';
                                        $User_Attendence->save();
                                    }
                                }
                            }
                        }
                        elseif($Auth->branch == 2 || $Auth->branch == 5)
                        {
                            $User_Attendence = MumbaiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDL';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDL';
                                        $User_Attendence->save();
                                    }
                                }
                            }
                        }
                        elseif($Auth->branch == 3)
                        {   
                            $User_Attendence = DelhiAttendence::where('year','=',$Leave_date->year)->where('month','=',$Leave_date->month)->where('user_id','=',$Leave->user_id)->first();
                            if($User_Attendence)
                            {
                                if($request->status == "Rejected")
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'RHDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'RFDL';
                                        $User_Attendence->save();
                                    }
                                }
                                else
                                {
                                    if($Leave->duration == "Half Day")
                                    {
                                        $User_Attendence->$num_word = 'HDL';
                                        $User_Attendence->save();   
                                    }else{
                                        $User_Attendence->$num_word = 'FDL';
                                        $User_Attendence->save();
                                    }
                                }
                            }    
                        }
                    }  
                    
                    Mail::to($Leave_User)->send(new UsersLeaveStatus($Auth,$Leave,$cc,$AuthName,$AuthDetails));

                    Toastr::success('You Have Successfully Updated Leave Status!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();         
                }
            }
        }
        else
        {
            Toastr::error('Please Check The details Before Update!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
    }
}
