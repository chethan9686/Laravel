<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRecce;
use App\Mail\UserEventSetup;
use App\Mail\UserEvent;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use App\User;
use App\Branch;
use App\Recce;
use App\EventSetup;
use App\Event;
use App\UserDetails;
use Carbon\Carbon;

class UserEventsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');       
    } 
    
    public function recce(){
    	$user = Auth::user(); 
    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
       	$userbranch = Branch::find($user->branch); 
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $Reccesid = Recce::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $Reccesid = Recce::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $Reccesid = Recce::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('recce_dateofrecce', 'desc')
       								->get();            
            }elseif($user->branch == 2 || $user->branch == 5){
                $Reccesid = Recce::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('recce_dateofrecce', 'desc')
       								->get();
            }elseif($user->branch == 3){
                $Reccesid = Recce::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('recce_dateofrecce', 'desc')
       								->get();
            }elseif($user->branch == 4){
                $Reccesid = Recce::where('user_id','=',$user->id)
        							->orWhere('tl','=',$user->id)    
			                        ->orWhere('rm','=',$user->id)
			                        ->orWhere('rh','=',$user->id)
			                        ->orderBy('recce_dateofrecce', 'desc')
       								->get();    
            }        
        }
        else{
                $Reccesid = Recce::where('user_id','=',$user->id)->get(); 
		    }	
    			
    	return view('user.workschedule.recce',compact('Employees','Reccesid'));
    }
    public function reccecreate(Request $request){

    				$request->validate([
						                'recce_clientname' => ['required'],
						                'recce_eventname' => ['required'],
						                'recce_dateofrecce' => ['required'],  
						                'recce_time' => ['required'], 
						                'recce_eventenddate' => ['required'],
						                'recce_eventlcation' => ['required'],
						                'recce_ERTW' => ['required']
							        ], [
						                'recce_clientname.required' => 'Please enter the client name.',
						                'recce_eventname.required' => 'Please enter the event name.',
						                'recce_dateofrecce.required' => 'Please select the date of recce',     
						                'recce_time.required' => 'Please select the time of recce',     
						                'recce_eventenddate.required' => 'Please select the event date',     
						                'recce_eventlcation.required' => 'Please enter the recce location',   
						                'recce_ERTW.required' => 'Please select the reporting time to work'
							        ]);  

    				
    				$user = Auth::user();
		    		$user_id = $user->id;  
		    		$user_branch = $user->branch;

		    		$today = Carbon::today(); 

			        $Meeting_date = Carbon::parse($request->recce_dateofrecce);

			        $day = $Meeting_date->day;

			        $number = new ConvertNumber(); 
			        $num_word = $number->numberTowords($day);

		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
		                    ->where('user_id','=',$user_id)
		                    ->first();
    				 
    				$recce_dateofrecce	= Carbon::parse($request->recce_dateofrecce	)->format('Y-m-d');
		            $recce_time = Carbon::parse($request->recce_time)->format('H:i:s'); 
    				$recce_eventenddate = Carbon::parse($request->recce_eventenddate)->format('Y-m-d');
		            $recce_ERTW = Carbon::parse($request->recce_ERTW)->format('H:i:s');

		            $checkRecce = Recce::select('recce_clientname','recce_dateofrecce','recce_eventlcation','recce_time')
						                    ->where('recce_clientname','=',$request->recce_clientname)
						                    ->where('recce_dateofrecce','=',$recce_dateofrecce)
						                    ->where('recce_eventlcation','=',$request->recce_eventlcation)
						                    ->where('recce_time','=',$recce_time)
						                    ->where('user_id','=',$user_id)
						                    ->first();

                    $tagemployee = $request->recce_references_id;
                    if(is_null($checkRecce)){
                    	$recce = new Recce();
			            $recce->user_id = $user_id;
			            $recce->rh = $userinfo->rh;
			            $recce->rm = $userinfo->rm;
			            $recce->tl = $userinfo->tl;
			            $recce->branch = $user_branch;
			            $recce->recce_clientname  = $request->recce_clientname;
			            $recce->recce_eventname  = $request->recce_eventname;
			            $recce->recce_dateofrecce  = $recce_dateofrecce;
			            $recce->recce_time  = $recce_time;
			            $recce->recce_eventenddate  = $recce_eventenddate;
			            $recce->recce_eventlcation  = $request->recce_eventlcation;
			            $recce->recce_ERTW  = $recce_ERTW;
			            $recce->save();

			            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
		                {               
		                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                    if($User_Attendence)
				            {
			                    if($recce->recce_time <= '11:00:00')
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
			                    if($recce->recce_time <= '11:30:00')
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
			                    if($recce->recce_time <= '11:30:00')
			                    {
			                        $User_Attendence->$num_word = 'M';
			                        $User_Attendence->save();
			                    }
		                	}
		                } 


			            $Mail = new SendMail();
		                $cc = $Mail->getusers($user,$userinfo); 

		                $send_to = User::find($userinfo->tl);

		                Mail::to($send_to)->send(new UserRecce($user,$recce,$cc,$userinfo));

			             if(! empty($tagemployee)){
			             	foreach ($tagemployee as $item){
			             		$user = User::find($item);
			             		$user_branch = Auth::user()->branch; 
					    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
									                    ->where('user_id','=',$item)
									                    ->first(); 
			             		
						        $checkRecce = Recce::select('recce_clientname','recce_dateofrecce','recce_eventlcation','recce_time')
						                    ->where('recce_clientname','=',$request->recce_clientname)
						                    ->where('recce_dateofrecce','=',$recce_dateofrecce)
						                    ->where('recce_eventlcation','=',$request->recce_eventlcation)
						                    ->where('recce_time','=',$recce_time)
						                    ->where('user_id','=',$item)
						                    ->first();

			            		$userrecceID = Recce::select('id','recce_clientname','recce_dateofrecce','recce_eventlcation','recce_time')
											                    ->where('recce_clientname','=',$request->recce_clientname)
											                    ->where('recce_dateofrecce','=',$recce_dateofrecce)
											                    ->where('recce_time','=',$recce_time)
											                    ->where('user_id','=',$user_id)
											                    ->first();

			             		$recce = new Recce();
					            $recce->user_id = $item;
					            $recce->rh = $userinfo->rh;
					            $recce->rm = $userinfo->rm;
					            $recce->tl = $userinfo->tl;
					            $recce->branch = $user_branch;
					            $recce->recce_clientname  = $request->recce_clientname;
					            $recce->recce_eventname  = $request->recce_eventname;
					            $recce->recce_dateofrecce  = $recce_dateofrecce;
					            $recce->recce_time  = $recce_time;
					            $recce->recce_eventenddate  = $recce_eventenddate;
					            $recce->recce_eventlcation  = $request->recce_eventlcation;
					            $recce->recce_ERTW  = $recce_ERTW;
					            $recce->recce_references_id  = $userrecceID->id;
					            $recce->save();

					            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
				                {               
				                 	$User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();

				                   	if($User_Attendence)
				                   	{
										if($recce->recce_time <= '11:00:00')
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
					                    if($recce->recce_time <= '11:30:00')
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
					                    if($recce->recce_time <= '11:30:00')
					                    {
					                        $User_Attendence->$num_word = 'M';
					                        $User_Attendence->save();
					                    }
				                	}
				                } 

					            $Mail = new SendMail();
				                $cc = $Mail->getusers($user,$userinfo); 

				                $send_to = User::find($userinfo->tl);

				                Mail::to($send_to)->send(new UserRecce($user,$recce,$cc,$userinfo));
			             	}
			             }
			             	Toastr::success('You Have Successfully Submitted Recce Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        			return back();
                    }
                    else{
		            		Toastr::error('Recce Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		            		return back();   
        		}
    }

    public function eventsetup(){

    			$user = Auth::user(); 
		    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
		       	$userbranch = Branch::find($user->branch); 
		        if($user->user_position == 5){
		             if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
		                $EventSetupid = EventSetup::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
		            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
		                $EventSetupid = EventSetup::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
		            }
		        }
		        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
		            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
		                $EventSetupid = EventSetup::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('setup_eventstartdate', 'desc')
		       								->get();            
		            }elseif($user->branch == 2 || $user->branch == 5){
		                $EventSetupid = EventSetup::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('setup_eventstartdate', 'desc')
		       								->get();  
		            }elseif($user->branch == 3){
		                $EventSetupid = EventSetup::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('setup_eventstartdate', 'desc')
		       								->get();  
		            }elseif($user->branch == 4){
		               $EventSetupid = EventSetup::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('setup_eventstartdate', 'desc')
		       								->get();      
		            }        
		        }else{
		                $EventSetupid = EventSetup::where('user_id','=',$user->id)->get(); 
		        }	


    			return view('user.workschedule.eventsetup',compact('Employees','EventSetupid'));
    }
    public function eventsetupcreate(Request $request){
					$request->validate([
					                'setup_clientname' => ['required'],
					                'setup_eventstartdate' => ['required'],  
					                'setup_eventenddate' => ['required'], 
					                'setup_time' => ['required'],
					                'setup_eventlcation' => ['required'],
					                'setup_EWH' => ['required']
						        ], [
					                'setup_clientname.required' => 'Please enter the company name.',
					                'setup_eventstartdate.required' => 'Please select the event setup start date',     
					                'setup_eventenddate.required' => 'Please select the event setup end date',     
					                'setup_time.required' => 'Please select the event setup start time',      
					                'setup_eventlcation.required' => 'Please enter the event setup location',   
					                'setup_EWH.required' => 'Please select the expected work hours'
						        ]);  

    					
    				$user = Auth::user();
		    		$user_id = $user->id;  
		    		$user_branch = $user->branch; 	
		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
		                    ->where('user_id','=',$user_id)
		                    ->first();
    				 
    				$setup_eventstartdate = Carbon::parse($request->setup_eventstartdate)->format('Y-m-d');
    				$setup_eventenddate	= Carbon::parse($request->setup_eventenddate)->format('Y-m-d');
		            $setup_time = Carbon::parse($request->setup_time)->format('H:i:s'); 

		           	$Today = Carbon::today();

		            $checkEventSetup = EventSetup::select('setup_clientname','setup_eventstartdate','setup_eventlcation','setup_time')
						                    ->where('setup_clientname','=',$request->setup_clientname)
						                    ->where('setup_eventstartdate','=',$setup_eventstartdate)
						                    ->where('setup_eventlcation','=',$request->setup_eventlcation)
						                    ->where('setup_time','=',$setup_time)
						                    ->where('user_id','=',$user_id)
						                    ->first();

                    $tagemployee = $request->setup_references_id;
                    if(is_null($checkEventSetup)){
                    	$eventsetup = new EventSetup();
			            $eventsetup->user_id = $user_id;
			            $eventsetup->rh = $userinfo->rh;
			            $eventsetup->rm = $userinfo->rm;
			            $eventsetup->tl = $userinfo->tl;
			            $eventsetup->branch = $user_branch;
			            $eventsetup->setup_clientname  = $request->setup_clientname;
			            $eventsetup->setup_eventstartdate  = $setup_eventstartdate;
			            $eventsetup->setup_eventenddate  = $setup_eventenddate;
			            $eventsetup->setup_time  = $setup_time;
			            $eventsetup->setup_eventlcation  = $request->setup_eventlcation;
			            $eventsetup->setup_EWH  = $request->setup_EWH;
			            $eventsetup->attendence_status = 1;
			            $eventsetup->save();

			            $Startdate = Carbon::parse($setup_eventstartdate);
			            $Enddate = Carbon::parse($setup_eventenddate);

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

			                if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
			                {               
			                    $User_Attendence = BangaloreAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();	

			                    if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();  
			                    }			                                             
			                }
			                elseif($user->branch == 2 || $user->branch == 5)
			                {
			                    $User_Attendence = MumbaiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();  
			                    }	  			                   			                                     
			                }   
			                elseif($user->branch == 3)
			                {
			                    $User_Attendence = DelhiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
			                   	if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();  
			                    }	 			                               
			                }
            			}


			            $Mail = new SendMail();
		                $cc = $Mail->getusers($user,$userinfo); 

		                $send_to = User::find($userinfo->tl);

		                Mail::to($send_to)->send(new UserEventSetup($user,$eventsetup,$cc,$userinfo));

			            if(! empty($tagemployee)){
			             	foreach ($tagemployee as $item){

			             		$user = User::find($item);
			             		$user_branch = Auth::user()->branch; 
					    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
									                    ->where('user_id','=',$item)
									                    ->first();

						        $checkEventSetup = EventSetup::select('setup_clientname','setup_eventstartdate','setup_eventlcation','setup_time')
						                    ->where('setup_clientname','=',$request->setup_clientname)
						                    ->where('setup_eventstartdate','=',$setup_eventstartdate)
						                    ->where('setup_eventlcation','=',$request->setup_eventlcation)
						                    ->where('setup_time','=',$setup_time)
						                    ->where('user_id','=',$item)
						                    ->first();            

			            		$userEventSetupID = EventSetup::select('id','setup_clientname','setup_eventstartdate','setup_eventlcation','setup_time')
											                    ->where('setup_clientname','=',$request->setup_clientname)
											                    ->where('setup_eventstartdate','=',$setup_eventstartdate)											                    
						                    					->where('setup_eventlcation','=',$request->setup_eventlcation)
											                    ->where('setup_time','=',$setup_time)
											                    ->where('user_id','=',$user_id)
											                    ->first();

					            $eventsetup = new EventSetup();
					            $eventsetup->user_id = $item;
					            $eventsetup->rh = $userinfo->rh;
					            $eventsetup->rm = $userinfo->rm;
					            $eventsetup->tl = $userinfo->tl;
					            $eventsetup->branch = $user_branch;
					            $eventsetup->setup_clientname  = $request->setup_clientname;
					            $eventsetup->setup_eventstartdate  = $setup_eventstartdate;
					            $eventsetup->setup_eventenddate  = $setup_eventenddate;
					            $eventsetup->setup_time  = $setup_time;
					            $eventsetup->setup_eventlcation  = $request->setup_eventlcation;
					            $eventsetup->setup_EWH  = $request->setup_EWH;
					            $eventsetup->setup_references_id  = $userEventSetupID->id;
					            $eventsetup->attendence_status = 1;
					            $eventsetup->save();


					            $Startdate = Carbon::parse($setup_eventstartdate);
					            $Enddate = Carbon::parse($setup_eventenddate);

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

					                if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
					                {               
					                    $User_Attendence = BangaloreAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();		
					                    if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();  
					                    }	                           
					                }
					                elseif($user->branch == 2 || $user->branch == 5)
					                {
					                    $User_Attendence = MumbaiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
					                    if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();  
					                    }  			                   			                                     
					                }   
					                elseif($user->branch == 3)
					                {
					                    $User_Attendence = DelhiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
					                   	if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();  
					                    }  			                               
					                }
		            			}	

					            $Mail = new SendMail();
				                $cc = $Mail->getusers($user,$userinfo); 

				                $send_to = User::find($userinfo->tl);

				                Mail::to($send_to)->send(new UserEventSetup($user,$eventsetup,$cc,$userinfo));
			             	}
			            }
			             	Toastr::success('You Have Successfully Submitted Event Setup Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        			return back();
                    }
                    else{
            				Toastr::error('Event Setup Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		            		return back();     
        		}
    }

    public function event(){

    			$user = Auth::user(); 
		    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
		       	$userbranch = Branch::find($user->branch); 
		        if($user->user_position == 5){
		            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
		                $Eventid = Event::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
		            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
		                $Eventid = Event::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
		            }
		        }
		        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
		            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
		                $Eventid = Event::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('eventfromdate', 'desc')
		       								->get();            
		            }elseif($user->branch == 2 || $user->branch == 5){
		                $Eventid = Event::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('eventfromdate', 'desc')
		       								->get();  
		            }elseif($user->branch == 3){
		                $Eventid = Event::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('eventfromdate', 'desc')
		       								->get();  
		            }elseif($user->branch == 4){
		               	$Eventid = Event::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('eventfromdate', 'desc')
		       								->get();      
		            }        
		        }else{
		                $Eventid = Event::where('user_id','=',$user->id)->get(); 
		        }

    	return view('user.workschedule.event',compact('Employees','Eventid'));
    }

    public function eventcreate(Request $request){
					$request->validate([
					                'eventname' => ['required'],
					                'clientname' => ['required'],
					                'eventfromdate' => ['required'],  
					                'eventtodate' => ['required'], 
					                'eventlocation' => ['required'],
					                'eventdesc' => ['required']
						        ], [
					                'eventname.required' => 'Please enter the event name.',
					                'clientname.required' => 'Please enter the company name.',
					                'eventfromdate.required' => 'Please select the event start date',     
					                'eventtodate.required' => 'Please select the event end date',     
					                'eventlocation.required' => 'Please enter the event location',   
					                'eventdesc.required' => 'Please type the event description'
						        ]);  

    					
    				$user = Auth::user();
		    		$user_id = $user->id;  
		    		$user_branch = $user->branch; 	
		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
		                    ->where('user_id','=',$user_id)
		                    ->first();
    				 
    				$eventfromdate	= Carbon::parse($request->eventfromdate)->format('Y-m-d');
    				$eventtodate	= Carbon::parse($request->eventtodate)->format('Y-m-d');
    				$Today = Carbon::today();

		            $checkEvent = Event::select('eventname','clientname','eventfromdate','eventlocation')
						                    ->where('eventname','=',$request->eventname)
						                    ->where('clientname','=',$request->clientname)
						                    ->where('eventfromdate','=',$eventfromdate)
						                    ->where('eventlocation','=',$request->eventlocation)
						                    ->where('user_id','=',$user_id)
						                    ->first();

                    $tagemployee = $request->event_references_id;

                    if(is_null($checkEvent)){
                    	$event = new Event();
			            $event->user_id = $user_id;
			            $event->rh = $userinfo->rh;
			            $event->rm = $userinfo->rm;
			            $event->tl = $userinfo->tl;
			            $event->branch = $user_branch;
			            $event->eventname  = $request->eventname;
			            $event->clientname  = $request->clientname;
			            $event->eventfromdate  = $eventfromdate;
			            $event->eventtodate  = $eventtodate;
			            $event->eventlocation  = $request->eventlocation;
			            $event->eventdesc  = $request->eventdesc;
			            $event->attendence_status = 1;
			            $event->save();

			            
			            $Startdate = Carbon::parse($eventfromdate);
			            $Enddate = Carbon::parse($eventtodate);

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

			                if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
			                {               
			                    $User_Attendence = BangaloreAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();    
			                    }		                                    
			                }
			                elseif($user->branch == 2 || $user->branch == 5)
			                {
			                    $User_Attendence = MumbaiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
			                    if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();    
			                    } 			                   			                                     
			                }   
			                elseif($user->branch == 3)
			                {
			                    $User_Attendence = DelhiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
			                   	if($User_Attendence)
			                    {
			                    	$User_Attendence->$num_word = 'E';
                            		$User_Attendence->save();    
			                    }  			                               
			                }
            			}

			            $Mail = new SendMail();
		                $cc = $Mail->getusers($user,$userinfo); 

		                $send_to = User::find($userinfo->tl);

		                Mail::to($send_to)->send(new UserEvent($user,$event,$cc,$userinfo));

			            if(! empty($tagemployee)){
			             	foreach ($tagemployee as $item){

			             		$user = User::find($item);
			             		$user_branch = Auth::user()->branch; 
					    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
									                    ->where('user_id','=',$item)
									                    ->first();

						        $checkEvent = Event::select('eventname','clientname','eventfromdate','eventlocation')
						                    ->where('eventname','=',$request->eventname)
						                    ->where('clientname','=',$request->clientname)
						                    ->where('eventfromdate','=',$eventfromdate)
						                    ->where('eventlocation','=',$request->eventlocation)
						                    ->where('user_id','=',$item)
						                    ->first();            

			            		$userEventID = Event::select('id','eventname','clientname','eventfromdate','eventlocation')
											                    ->where('eventname','=',$request->eventname)
											                    ->where('clientname','=',$request->clientname)
											                    ->where('eventfromdate','=',$eventfromdate)											                    
						                    					->where('eventlocation','=',$request->eventlocation)
											                    ->where('user_id','=',$user_id)
											                    ->first();

					            $event = new Event();
					            $event->user_id = $item;
					            $event->rh = $userinfo->rh;
					            $event->rm = $userinfo->rm;
					            $event->tl = $userinfo->tl;
					            $event->branch = $user_branch;
					            $event->eventname  = $request->eventname;
					            $event->clientname  = $request->clientname;
					            $event->eventfromdate  = $eventfromdate;
					            $event->eventtodate  = $eventtodate;
					            $event->eventlocation  = $request->eventlocation;
					            $event->eventdesc  = $request->eventdesc;
					            $event->event_references_id  = $userEventID->id;
					            $event->attendence_status = 1;
					            $event->save();	


					            $Startdate = Carbon::parse($eventfromdate);
					            $Enddate = Carbon::parse($eventtodate);

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

					                if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
					                {               
					                    $User_Attendence = BangaloreAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();		
					                    if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();    
					                    }  		                      
					                }
					                elseif($user->branch == 2 || $user->branch == 5)
					                {
					                    $User_Attendence = MumbaiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
					                   	if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();    
					                    }  		 			                   			                                     
					                }   
					                elseif($user->branch == 3)
					                {
					                    $User_Attendence = DelhiAttendence::where('year','=',$Event_date->year)->where('month','=',$Event_date->month)->where('user_id','=',$user->id)->first();
					                   	if($User_Attendence)
					                    {
					                    	$User_Attendence->$num_word = 'E';
		                            		$User_Attendence->save();    
					                    }  		 			                               
					                }
		            			}

					            $Mail = new SendMail();
				                $cc = $Mail->getusers($user,$userinfo); 

				                $send_to = User::find($userinfo->tl);

				                Mail::to($send_to)->send(new UserEvent($user,$event,$cc,$userinfo));
			             	}
			            }
			              	Toastr::success('You Have Successfully Submitted Event Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        			return back();
                    }
                    else{
            				Toastr::error('Event Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		            		return back();   
        		}
    }
}
