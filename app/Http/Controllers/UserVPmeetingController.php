<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVendorMeeting;
use App\Mail\UserPreEventMeeting;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use App\User;
use App\Branch;
use App\VendorMeeting;
use App\Preeventmeeting;
use App\UserDetails;
use Carbon\Carbon;


class UserVPmeetingController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function vendormeeting(){

    	$user = Auth::user(); 
    	$Bang_Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
       	$userbranch = Branch::find($user->branch); 
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $Meetingsid = VendorMeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $Meetingsid = VendorMeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $Meetingsid = VendorMeeting::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('vendor_dateofmeeting', 'desc')
       								->get();            
            }elseif($user->branch == 2 || $user->branch == 5){
                $Meetingsid = VendorMeeting::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('vendor_dateofmeeting', 'desc')
       								->get();
            }elseif($user->branch == 3){
                $Meetingsid = VendorMeeting::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('vendor_dateofmeeting', 'desc')
       								->get();
            }elseif($user->branch == 4){
                $Meetingsid = VendorMeeting::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('vendor_dateofmeeting', 'desc')
       								->get();    
            }        
        }else{
                $Meetingsid = VendorMeeting::where('user_id','=',$user->id)->get(); 
        }							 

    	return view('user.workschedule.vendormeeting',compact('Bang_Employees','Meetingsid'));
    }

  	public function vendormeetingcreate(Request $request)
  	{

	 	$request->validate([
			                'vendor_name' => ['required'],
			                'vendor_eventname' => ['required'],  
			                'location' => ['required'],    
			                'vendor_dateofmeeting' => ['required'],
			                'vendor_time' => ['required'],
			                'vendor_ERTW' => ['required'],
			                'vendor_purpose' => ['required']
				        ], [
			                'vendor_name.required' => 'Please enter the vendor name.',
			                'vendor_eventname.required' => 'Please enter the event name',     
			                'location.required' => 'Please enter the location',     
			                'vendor_dateofmeeting.required' => 'Please select the date',     
			                'vendor_time.required' => 'Please select the time',   
			                'vendor_ERTW.required' => 'Please select the time',
			                'vendor_purpose.required' => 'Please mention the purpose Of meeting'   
				        ]);  

	 			$user = Auth::user();
	    		$user_id = $user->id;  
	    		$user_branch = $user->branch; 

	    		$today = Carbon::today(); 

		        $Meeting_date = Carbon::parse($request->vendor_dateofmeeting);

		        $day = $Meeting_date->day;

		        $number = new ConvertNumber(); 
		        $num_word = $number->numberTowords($day);

	    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
					                    ->where('user_id','=',$user_id)
					                    ->first();
	            $vendor_meetingdate = Carbon::parse($request->vendor_dateofmeeting)->format('Y-m-d');
	            $vendor_time = Carbon::parse($request->vendor_time)->format('H:i:s');            
	            $vendor_ERTW = Carbon::parse($request->vendor_ERTW)->format('H:i:s');

	            $checkVendormeeting = Vendormeeting::select('vendor_name','vendor_eventname','vendor_time')
								                    ->where('vendor_name','=',$request->vendor_name)
								                    ->where('vendor_dateofmeeting','=',$vendor_meetingdate)
								                    ->where('vendor_eventname','=',$request->vendor_eventname)
								                    ->where('vendor_time','=',$vendor_time)
								                    ->where('user_id','=',$user_id)
								                    ->first();   

                $tagemployee = $request->references_id;   	

                if(!is_null($checkVendormeeting))
                {

                	Toastr::error('Please check the details because already you have meeting in that time slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
           			return back(); 
                }
                else
                {
                 	if(!is_null($tagemployee))
                 	{
                 		foreach ($tagemployee as $item)
                 		{
                 			$tagusermeeting = Vendormeeting::select('vendor_name','vendor_eventname','vendor_time')
								                    ->where('vendor_name','=',$request->vendor_name)
								                    ->where('vendor_dateofmeeting','=',$vendor_meetingdate)
								                    ->where('vendor_eventname','=',$request->vendor_eventname)
								                    ->where('vendor_time','=',$vendor_time)
								                    ->where('user_id','=',$item)
								                    ->first();   

		                    if(!is_null($tagusermeeting))
		                    {
		                     	Toastr::error('Tagged team member(s) already have a meeting in this time slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		                     	return back(); 
		                    }
                 		}
                 	}


                 	$vendormeeting = new VendorMeeting();
		            $vendormeeting->user_id = $user_id;
		            $vendormeeting->rh = $userinfo->rh;
		            $vendormeeting->rm = $userinfo->rm;
		            $vendormeeting->tl = $userinfo->tl;
		            $vendormeeting->branch = $user_branch;
		            $vendormeeting->vendor_name  = $request->vendor_name;
		            $vendormeeting->location  = $request->location;
		            $vendormeeting->vendor_eventname  = $request->vendor_eventname;
		            $vendormeeting->vendor_dateofmeeting  = $vendor_meetingdate;
		            $vendormeeting->vendor_time  = $vendor_time;
		            $vendormeeting->vendor_ERTW  = $vendor_ERTW;
		            $vendormeeting->vendor_purpose  = $request->vendor_purpose;
		            $vendormeeting->save();

		            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
	                {               
	                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
	                    if($User_Attendence)
		                {
		                    if($vendormeeting->vendor_time <= '11:00:00')
		                    {
		                        $User_Attendence->$num_word = 'M';
		                        $User_Attendence->save();
		                    }
	                	}	                    
	                }
	                elseif($user->branch == 2 || $user->branch == 5)
	                {
	                    $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
	                    if($User_Attendence)
		                {
		                    if($vendormeeting->vendor_time <= '11:30:00')
		                    {
		                        $User_Attendence->$num_word = 'M';
		                        $User_Attendence->save();
		                    }
	                	}
	                }   
	                elseif($user->branch == 3)
	                {
	                    $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
	                    if($User_Attendence)
		                {
		                    if($vendormeeting->vendor_time <= '11:30:00')
		                    {
		                        $User_Attendence->$num_word = 'M';
		                        $User_Attendence->save();
		                    }
	                	}
	                } 

		            $Mail = new SendMail();
	                $cc = $Mail->getusers($user,$userinfo); 

	                $send_to = User::find($userinfo->tl);

	                Mail::to($send_to)->send(new UserVendorMeeting($user,$vendormeeting,$cc,$userinfo));

	                if(! empty($tagemployee))
	                {
			        	foreach ($tagemployee as $item){

			        		$user = User::find($item);
				    		$user_branch = Auth::user()->branch; 
				    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
								                    ->where('user_id','=',$item)
								                    ->first(); 

				            $vendor_meetingdate = Carbon::parse($request->vendor_dateofmeeting)->format('Y-m-d');
				            $vendor_time = Carbon::parse($request->vendor_time)->format('H:i:s');            
				            $vendor_ERTW = Carbon::parse($request->vendor_ERTW)->format('H:i:s');

				            $checkVendormeeting = Vendormeeting::select('vendor_name','vendor_eventname','vendor_time')
												                    ->where('vendor_name','=',$request->vendor_name)
												                    ->where('vendor_dateofmeeting','=',$vendor_meetingdate)
												                    ->where('vendor_eventname','=',$request->vendor_eventname)
												                    ->where('vendor_time','=',$vendor_time)
												                    ->where('user_id','=',$item)
												                    ->get();

				            $userVendormeetingID = Vendormeeting::select('id','vendor_name','vendor_eventname','vendor_time')
												                    ->where('vendor_name','=',$request->vendor_name)
												                    ->where('vendor_dateofmeeting','=',$vendor_meetingdate)
												                    ->where('vendor_eventname','=',$request->vendor_eventname)
												                    ->where('vendor_time','=',$vendor_time)
												                    ->where('user_id','=',$user_id)
												                    ->first();
							$vendormeeting = new Vendormeeting();
			                $vendormeeting->user_id = $item;
				            $vendormeeting->rh = $userinfo->rh;
				            $vendormeeting->rm = $userinfo->rm;
				            $vendormeeting->tl = $userinfo->tl;
				            $vendormeeting->branch = $user_branch;
				            $vendormeeting->vendor_name  = $request->vendor_name;
				            $vendormeeting->location  = $request->location;
				            $vendormeeting->vendor_eventname  = $request->vendor_eventname;
				            $vendormeeting->vendor_dateofmeeting  = $vendor_meetingdate;
				            $vendormeeting->vendor_time  = $vendor_time;
				            $vendormeeting->vendor_ERTW  = $vendor_ERTW;
				            $vendormeeting->vendor_purpose  = $request->vendor_purpose;
			                $vendormeeting->references_id  = $userVendormeetingID->id;
			                $vendormeeting->save();


			                if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
			                {               
			                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
		                		{
				                    if($vendormeeting->vendor_time <= '11:00:00')
				                    {
				                        $User_Attendence->$num_word = 'M';
				                        $User_Attendence->save();
				                    }
			                	}			                    
			                }
			                elseif($user->branch == 2 || $user->branch == 5)
			                {
			                    $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
		                		{
				                    if($vendormeeting->vendor_time <= '11:30:00')
				                    {
				                        $User_Attendence->$num_word = 'M';
				                        $User_Attendence->save();
				                    }
			                	}
			                }   
			                elseif($user->branch == 3)
			                {
			                    $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
		                		{
				                    if($vendormeeting->vendor_time <= '11:30:00')
				                    {
				                        $User_Attendence->$num_word = 'M';
				                        $User_Attendence->save();
				                    }
			                	}
			                }

			                $Mail = new SendMail();
			                $cc = $Mail->getusers($user,$userinfo); 

			                $send_to = User::find($userinfo->tl);

			                Mail::to($send_to)->send(new UserVendorMeeting($user,$vendormeeting,$cc,$userinfo));
		           		}
		        	} 
		        	Toastr::success('You Have Successfully Submitted Vendor Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        	return back();
                }    
	        return back(); 
    }

    public function preeventmeeting(){
    		$user = Auth::user(); 
	    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
	       	$userbranch = Branch::find($user->branch); 
	        if($user->user_position == 5){
	             if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
	                $Preeventmeetingsid = Preeventmeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
	            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
	                $Preeventmeetingsid = Preeventmeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
	            }
	        }
	        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
	            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
	                $Preeventmeetingsid = Preeventmeeting::where('user_id','=',$user->id)
	        							->orWhere('tl','=',$user->id)    
				                        ->orWhere('rm','=',$user->id)
				                        ->orWhere('rh','=',$user->id)
				                        ->orderBy('pem_dateofmeeting', 'desc')
	       								->get();            
	            }elseif($user->branch == 2 || $user->branch == 5){
	                $Preeventmeetingsid = Preeventmeeting::where('user_id','=',$user->id)
	        							->orWhere('tl','=',$user->id)    
				                        ->orWhere('rm','=',$user->id)
				                        ->orWhere('rh','=',$user->id)
				                        ->orderBy('pem_dateofmeeting', 'desc')
	       								->get();
	            }elseif($user->branch == 3){
	                $Preeventmeetingsid = Preeventmeeting::where('user_id','=',$user->id)
	        							->orWhere('tl','=',$user->id)    
				                        ->orWhere('rm','=',$user->id)
				                        ->orWhere('rh','=',$user->id)
				                        ->orderBy('pem_dateofmeeting', 'desc')
	       								->get();
	            }elseif($user->branch == 4){
	                $Preeventmeetingsid = Preeventmeeting::where('user_id','=',$user->id)
	        							->orWhere('tl','=',$user->id)    
				                        ->orWhere('rm','=',$user->id)
				                        ->orWhere('rh','=',$user->id)
				                        ->orderBy('pem_dateofmeeting', 'desc')
	       								->get();    
	            }        
	        }else{
	                $Preeventmeetingsid = Preeventmeeting::where('user_id','=',$user->id)->get(); 
	        }							 

    	return view('user.workschedule.preeventmeeting',compact('Employees','Preeventmeetingsid'));
    }
    public function preeventmeetingcreate(Request $request)
    {    				
		$request->validate([
			                'pem_clientname' => ['required'],
			                'pem_dateofmeeting' => ['required'],  
			                'pem_time' => ['required'], 
			                'pem_eventstartdate' => ['required'],
			                'pem_lcation' => ['required'],
			                'pem_ERTW' => ['required']
				        ], [
			                'pem_clientname.required' => 'Please enter the client name.',
			                'pem_dateofmeeting.required' => 'Please select the date of meeting',     
			                'pem_time.required' => 'Please select the time of meeting',     
			                'pem_eventstartdate.required' => 'Please select event start date',     
			                'pem_lcation.required' => 'Please enter the meeting location',   
			                'pem_ERTW.required' => 'Please select the reporting time to work'
				        ]);  

		$user = Auth::user();
		$user_id = $user->id;  
		$user_branch = $user->branch; 

		$today = Carbon::today(); 

        $Meeting_date = Carbon::parse($request->pem_dateofmeeting);

        $day = $Meeting_date->day;

        $number = new ConvertNumber(); 
        $num_word = $number->numberTowords($day);

		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
                ->where('user_id','=',$user_id)
                ->first();
		 
		$pem_dateofmeeting = Carbon::parse($request->pem_dateofmeeting)->format('Y-m-d');
        $pem_time = Carbon::parse($request->pem_time)->format('H:i:s'); 
		$pem_eventstartdate = Carbon::parse($request->pem_eventstartdate)->format('Y-m-d');
        $pem_ERTW = Carbon::parse($request->pem_ERTW)->format('H:i:s');

        $checkPreEventmeeting = Preeventmeeting::select('pem_clientname','pem_dateofmeeting','pem_lcation','pem_time')
			                    ->where('pem_clientname','=',$request->pem_clientname)
			                    ->where('pem_dateofmeeting','=',$pem_dateofmeeting)
			                    ->where('pem_lcation','=',$request->pem_lcation)
			                    ->where('pem_time','=',$pem_time)
			                    ->where('user_id','=',$user_id)
			                    ->first();

       	$tagemployee = $request->pem_references_id;

        if(!is_null($checkPreEventmeeting))
        {
            Toastr::error('Please check the details because already you have meeting in this time slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
           	return back(); 
        }
        else
        {

    		if(!is_null($tagemployee))
    		{
        		foreach ($tagemployee as $item)
        		{
     				$tagusermeeting = Preeventmeeting::select('id','pem_clientname','pem_dateofmeeting','pem_lcation','pem_time')
								                    ->where('pem_clientname','=',$request->pem_clientname)
								                    ->where('pem_dateofmeeting','=',$pem_dateofmeeting)
								                    ->where('pem_time','=',$pem_time)
								                    ->where('user_id','=',$item)
								                    ->first();   

                    if(!is_null($tagusermeeting))
                    {
                     	Toastr::error('Tagged team member(s) already have a meeting in this time slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                     	return back(); 
                    }
         		}
     		}

        	$preeventmeeting = new Preeventmeeting();
            $preeventmeeting->user_id = $user_id;
            $preeventmeeting->rh = $userinfo->rh;
            $preeventmeeting->rm = $userinfo->rm;
            $preeventmeeting->tl = $userinfo->tl;
            $preeventmeeting->branch = $user_branch;
            $preeventmeeting->pem_clientname  = $request->pem_clientname;
            $preeventmeeting->pem_dateofmeeting  = $pem_dateofmeeting;
            $preeventmeeting->pem_time  = $pem_time;
            $preeventmeeting->pem_eventstartdate  = $pem_eventstartdate;
            $preeventmeeting->pem_lcation  = $request->pem_lcation;
            $preeventmeeting->pem_ERTW  = $pem_ERTW;
            $preeventmeeting->save();

            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
            {               
                $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
                if($User_Attendence)
		        {
	                if($preeventmeeting->pem_time <= '11:00:00')
	                {
	                    $User_Attendence->$num_word = 'M';
	                    $User_Attendence->save();
	                }
            	}                
            }
            elseif($user->branch == 2 || $user->branch == 5)
            {
                $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
                if($User_Attendence)
		        {
	                if($preeventmeeting->pem_time <= '11:30:00')
	                {
	                    $User_Attendence->$num_word = 'M';
	                    $User_Attendence->save();
	                }
            	}
            }   
            elseif($user->branch == 3)
            {
                $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
                if($User_Attendence)
		        {
	                if($preeventmeeting->pem_time <= '11:30:00')
	                {
	                    $User_Attendence->$num_word = 'M';
	                    $User_Attendence->save();
	                }
            	}
            }


            $Mail = new SendMail();
            $cc = $Mail->getusers($user,$userinfo); 

            $send_to = User::find($userinfo->tl);

            Mail::to($send_to)->send(new UserPreEventMeeting($user,$preeventmeeting,$cc,$userinfo));

             if(! empty($tagemployee)){
             	foreach ($tagemployee as $item){

             		$user = User::find($item);
             		$user_branch = Auth::user()->branch; 
		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
						                    ->where('user_id','=',$item)
						                    ->first(); 
             		$checkPreEventmeeting = Preeventmeeting::select('pem_clientname','pem_dateofmeeting','pem_lcation','pem_time')
			                    ->where('pem_clientname','=',$request->pem_clientname)
			                    ->where('pem_dateofmeeting','=',$pem_dateofmeeting)
			                    ->where('pem_lcation','=',$request->pem_lcation)
			                    ->where('pem_time','=',$pem_time)
			                    ->where('user_id','=',$item)
			                    ->first();

            		$userpreeventmeetingID = Preeventmeeting::select('id','pem_clientname','pem_dateofmeeting','pem_lcation','pem_time')
								                    ->where('pem_clientname','=',$request->pem_clientname)
								                    ->where('pem_dateofmeeting','=',$pem_dateofmeeting)
								                    ->where('pem_time','=',$pem_time)
								                    ->where('user_id','=',$user_id)
								                    ->first();

             		$preeventmeeting = new Preeventmeeting();
		            $preeventmeeting->user_id = $item;
		            $preeventmeeting->rh = $userinfo->rh;
		            $preeventmeeting->rm = $userinfo->rm;
		            $preeventmeeting->tl = $userinfo->tl;
		            $preeventmeeting->branch = $user_branch;
		            $preeventmeeting->pem_clientname  = $request->pem_clientname;
		            $preeventmeeting->pem_dateofmeeting  = $pem_dateofmeeting;
		            $preeventmeeting->pem_time  = $pem_time;
		            $preeventmeeting->pem_eventstartdate  = $pem_eventstartdate;
		            $preeventmeeting->pem_lcation  = $request->pem_lcation;
		            $preeventmeeting->pem_ERTW  = $pem_ERTW;
		            $preeventmeeting->pem_references_id  = $userpreeventmeetingID->id;
		            $preeventmeeting->save();

		            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
		            {               
		                $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                if($User_Attendence)
		        		{
			                if($preeventmeeting->pem_time <= '11:00:00')
			                {
			                    $User_Attendence->$num_word = 'M';
			                    $User_Attendence->save();
			                }
		            	}		                
		            }
		            elseif($user->branch == 2 || $user->branch == 5)
		            {
		                $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                if($User_Attendence)
		        		{
			                if($preeventmeeting->pem_time <= '11:30:00')
			                {
			                    $User_Attendence->$num_word = 'M';
			                    $User_Attendence->save();
			                }
		            	}
		            }   
		            elseif($user->branch == 3)
		            {
		                $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                if($User_Attendence)
		        		{
			                if($preeventmeeting->pem_time <= '11:30:00')
			                {
			                    $User_Attendence->$num_word = 'M';
			                    $User_Attendence->save();
			                }
		            	}
		            }

		            $Mail = new SendMail();
	                $cc = $Mail->getusers($user,$userinfo); 

	                $send_to = User::find($userinfo->tl);

	                Mail::to($send_to)->send(new UserPreEventMeeting($user,$preeventmeeting,$cc,$userinfo));
             	}
             }
            Toastr::success('You Have Successfully Submitted Pre Event Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
    		return back();
        }
        return back();
    }


}