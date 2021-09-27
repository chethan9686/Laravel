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

class AdminOutOfStation extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function outofstation()
    {
    	$Bang_Users = UserOutOfStation::whereIn('branch',[1,6,7])->orderBy('created_at', 'desc')->get();
    	$Mum_Users = UserOutOfStation::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->get();
    	$Del_Users = UserOutOfStation::whereIn('branch',[3])->orderBy('created_at', 'desc')->get();
    	$Hyd_Users = UserOutOfStation::whereIn('branch',[4])->orderBy('created_at', 'desc')->get(); 

    	return view('admin.outofstation.out_of_station',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users'));
    }

    public function update_outofstation(Request $request)
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

            $OutStation = UserOutOfStation::find($request->id);

            $OutStation_User = User::find($OutStation->user_id);  
            $UserName = $OutStation_User->first_name.' '.$OutStation_User->last_name;    
            $Admin =  User::first();   
            $Admindetails = UserDetails::where('user_id', $Admin->id)->first();
            $AdminName = $Admin->first_name.' '.$Admin->last_name;
            $User_tl = User::find($OutStation->tl);
            $User_rm = User::find($OutStation->rm);
            $User_rh = User::find($OutStation->rh);
            $HeadName = $User_rh->first_name.' '.$User_rh->last_name; 

            //////////////////////////////Mail///////////////////////////////////////

            if(is_null($User_tl)){
                $tl = $User_rm->email;
            }else{
                $tl = $User_tl->email;
            }
            
            $rm = $User_rm->email;            
           
            $rh = $User_rh->email;      

           
            if($OutStation_User->branch == 1 || $OutStation_User->branch == 4 || $OutStation_User->branch == 6 || $OutStation_User->branch == 7)
            {               
                $hrs = User::where('branch','=',1)->where('user_position',5)->where('status','=','active')->get();
            }
            elseif($OutStation_User->branch == 2 || $OutStation_User->branch == 3 || $OutStation_User->branch == 5)
            {
                $hrs = User::where('branch','=',2)->where('user_position',5)->where('status','=','active')->get();
            } 

            foreach($hrs as $key => $Hr)
            {
                $hr[$key] = $Hr->email;
            }

            $cc = array_merge((array)$Admin->email,(array)$tl,(array)$rm,(array)$rh,$hr);

            //////////////////////////////////////////////////////////////////

            $Startdate = Carbon::parse($OutStation->departure_date);
            $Enddate = Carbon::parse($OutStation->arrival_date);

            $all_dates = array();
            while ($Startdate->lte($Enddate)){
              $all_dates[] = $Startdate->toDateString();

              $Startdate->addDay();
            }

            if(!is_null($OutStation)){
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

                        if($OutStation_User->branch == 1 || $OutStation_User->branch == 4 || $OutStation_User->branch == 6 || $OutStation_User->branch == 7)
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
                        elseif($OutStation_User->branch == 2 || $OutStation_User->branch == 5)
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
                        elseif($OutStation_User->branch == 3)
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

                Mail::to($OutStation_User)->send(new OutOfStationStatus($User,$OutStation,$cc,$AdminName,$Admindetails));

                Toastr::success('You Have Successfully Updated Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();  
            }else{
                Toastr::error('Please Check The details Before Update!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }
        }
    }
}
