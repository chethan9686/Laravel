<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

class AdminLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function leavelist()
    {
    	/*$Comp_Users = UserLeave::where('leave_type','=','Comp Off')->orderBy('created_at', 'desc')->get();*/ 
    	$Comp_Users = UserLeave::where('leave_type','=','Comp Off')->orderBy('created_at', 'desc')->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get(); 
        $Leave_Users = UserLeave::orwhere('tl',1)->orwhere('rm',1)->orwhere('rh',1)->orderBy('created_at', 'desc')->get(); 
        return view('admin.leave.leave',compact('Comp_Users','Leave_Users'));
    }

    public function updateuserleave(Request $request)
    {       
        $User = Auth::user();  

        if(is_null($request->status) || is_null($request->comment))
        {
            Toastr::error('Please Update The Form Before You Submit!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }else
        {
            $Status = $request->status;
            $Comment = $request->comment .' - '. $User->name; 

            $Leave = UserLeave::find($request->id);

            $Leave_User = User::find($Leave->user_id);  
            $UserName = $Leave_User->first_name.' '.$Leave_User->last_name;    
            $Admin =  User::first();   
            $Admindetails = UserDetails::where('user_id', $Admin->id)->first();
            $AdminName = $Admin->first_name.' '.$Admin->last_name; 
            $User_tl = User::find($Leave->tl);
            $User_rm = User::find($Leave->rm);
            $User_rh = User::find($Leave->rh);
            $HeadName = $User_rh->first_name.' '.$User_rh->last_name; 

            if(is_null($User_tl)){
                $tl = $User_rm->email;
            }else{
                $tl = $User_tl->email;
            }
            
            $rm = $User_rm->email;            
           
            $rh = $User_rh->email;      

            if($Leave_User->branch == 1 || $Leave_User->branch == 4 || $Leave_User->branch == 6 || $Leave_User->branch == 7)
            {               
                $hrs = User::where('branch','=',1)->where('user_position',5)->where('status','=','active')->get();
            }
            elseif($Leave_User->branch == 2 || $Leave_User->branch == 3 || $Leave_User->branch == 5)
            {
                $hrs = User::where('branch','=',2)->where('user_position',5)->where('status','=','active')->get();
            } 

            foreach($hrs as $key => $Hr)
            {
                $hr[$key] = $Hr->email;
            }

            $cc = array_merge((array)$Admin->email,(array)$tl,(array)$rm,(array)$rh,$hr);

            if(!is_null($Leave)){
                $Leave->admin_status = $Status;
                $Leave->admin_comment = $Comment; 
                $Leave->attendence_status = 1;
                $Leave->level = 3;
                $Leave->save();  


                $Startdate = Carbon::parse($Leave->start_date);
                $Enddate = Carbon::parse($Leave->end_date);

                $all_dates = array();
                while ($Startdate->lte($Enddate)){
                  $all_dates[] = $Startdate->toDateString();

                  $Startdate->addDay();
                }

                if($Leave->leave_type == "Comp Off")
                {
                    foreach($all_dates as $date)
                    {
                        $Leave_date = Carbon::parse($date);

                        $day = $Leave_date->day;

                        $number = new ConvertNumber(); 
                        $num_word = $number->numberTowords($day);                   


                        if($Leave_User->branch == 1 || $Leave_User->branch == 4 || $Leave_User->branch == 6 || $Leave_User->branch == 7)
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
                        elseif($Leave_User->branch == 2 || $Leave_User->branch == 5)
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
                        elseif($Leave_User->branch == 3)
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
                    foreach($all_dates as $date)
                    {
                        $Leave_date = Carbon::parse($date);

                        $day = $Leave_date->day;

                        $number = new ConvertNumber(); 
                        $num_word = $number->numberTowords($day);

                        if($Leave_User->branch == 1 || $Leave_User->branch == 4 || $Leave_User->branch == 6 || $Leave_User->branch == 7)
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
                        elseif($Leave_User->branch == 2 || $Leave_User->branch == 5)
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
                        elseif($Leave_User->branch == 3)
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

                Mail::to($Leave_User)->send(new UsersLeaveStatus($Admin,$Leave,$cc,$AdminName,$Admindetails));            

                Toastr::success('You Have Successfully Updated Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();  
            }else{
                Toastr::error('Please Check The details Before Update!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
        }  
    }
}
