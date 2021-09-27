<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDelivery;
use App\Mail\UserDismantle;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use App\User;
use App\Branch;
use App\Recce;
use App\EventSetup;
use App\Event;
use App\Delivery;
use App\Dismental;
use App\UserDetails;
use Carbon\Carbon;

class UserDeliveryDismantaleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');       
    } 
    
    public function delivery(){
    			$user = Auth::user(); 
		    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
		       	$userbranch = Branch::find($user->branch); 
		        if($user->user_position == 5){
		            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
		                $Deliveryid = Delivery::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
		            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
		                $Deliveryid = Delivery::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
		            }
		        }
		        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
		            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
		                $Deliveryid = Delivery::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('delry_dateofdelivery', 'desc')
		       								->get();            
		            }elseif($user->branch == 2 || $user->branch == 5){
		                $Deliveryid = Delivery::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('delry_dateofdelivery', 'desc')
		       								->get();
		            }elseif($user->branch == 3){
		                $Deliveryid = Delivery::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('delry_dateofdelivery', 'desc')
		       								->get();
		            }elseif($user->branch == 4){
		                $Deliveryid = Delivery::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('delry_dateofdelivery', 'desc')
		       								->get();    
		            }        
		        }else{
		                $Deliveryid = Delivery::where('user_id','=',$user->id)->get(); 
		        }	
    	return view('user.workschedule.delivery',compact('Employees','Deliveryid'));
    }
    public function deliverycreate(Request $request){
    				$request->validate([
						                'delry_clientname' => ['required'],
						                'delry_lcation' => ['required'],  
						                'delry_dateofdelivery' => ['required'], 
						                'delry_time' => ['required'],
						                'purposeofdelivery' => ['required'],
						                'itemdescription' => ['required'],
						                'delry_ERTW' => ['required'],
							        ], [
						                'delry_clientname.required' => 'Please enter the client name.',
						                'delry_lcation.required' => 'Please enter the delivery location.',
						                'delry_dateofdelivery.required' => 'Please select the delivery date',     
						                'delry_time.required' => 'Please select the time of delivery',     
						                'purposeofdelivery.required' => 'Please type the purpose of  delivery',   
						                'itemdescription.required' => 'Please type the item description',   
						                'delry_ERTW.required' => 'Please select the reporting time to work'
							        ]);  

    				$user = Auth::user();
		    		$user_id = $user->id;  
		    		$user_branch = $user->branch; 

		    		$today = Carbon::today(); 

			        $Meeting_date = Carbon::parse($request->delry_dateofdelivery);

			        $day = $Meeting_date->day;

			        $number = new ConvertNumber(); 
			        $num_word = $number->numberTowords($day);

		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
		                    ->where('user_id','=',$user_id)
		                    ->first();
    				 
    				$delry_dateofdelivery	= Carbon::parse($request->delry_dateofdelivery	)->format('Y-m-d');
		            $delry_time = Carbon::parse($request->delry_time)->format('H:i:s'); 
		            $delry_ERTW = Carbon::parse($request->delry_ERTW)->format('H:i:s');

		            $checkDelivery = Delivery::select('delry_clientname','delry_dateofdelivery','delry_lcation','delry_time')
						                    ->where('delry_clientname','=',$request->delry_clientname)
						                    ->where('delry_dateofdelivery','=',$delry_dateofdelivery)
						                    ->where('delry_lcation','=',$request->delry_lcation)
						                    ->where('delry_time','=',$delry_time)
						                    ->where('user_id','=',$user_id)
						                    ->first();
					$tagemployee = $request->delivery_references_id;
					if(is_null($checkDelivery)){
                    	$delivery = new Delivery();
			            $delivery->user_id = $user_id;
			            $delivery->rh = $userinfo->rh;
			            $delivery->rm = $userinfo->rm;
			            $delivery->tl = $userinfo->tl;
			            $delivery->branch = $user_branch;
			            $delivery->delry_clientname  = $request->delry_clientname;
			            $delivery->delry_lcation  = $request->delry_lcation;
			            $delivery->delry_dateofdelivery  = $delry_dateofdelivery;
			            $delivery->delry_time  = $delry_time;
			            $delivery->purposeofdelivery  = $request->purposeofdelivery;
			            $delivery->itemdescription  = $request->itemdescription;
			            $delivery->delry_ERTW  = $delry_ERTW;
			            $delivery->save();

			            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
		                {               
		                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                    if($User_Attendence)
		                    {
		                    	if($delivery->delry_time <= '11:00:00')
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
			                    if($delivery->delry_time <= '11:30:00')
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
			                    if($delivery->delry_time <= '11:30:00')
			                    {
			                        $User_Attendence->$num_word = 'M';
			                        $User_Attendence->save();
			                    }
		                	}
		                } 

			            $Mail = new SendMail();
		                $cc = $Mail->getusers($user,$userinfo); 

		                $send_to = User::find($userinfo->tl);

		                Mail::to($send_to)->send(new UserDelivery($user,$delivery,$cc,$userinfo));

			             if(! empty($tagemployee)){
			             	foreach ($tagemployee as $item){

			             		$user = User::find($item);
			             		$user_branch = Auth::user()->branch; 
					    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
									                    ->where('user_id','=',$item)
									                    ->first(); 
			             		
						       $checkDelivery = Delivery::select('delry_clientname','delry_dateofdelivery','delry_lcation','delry_time')
						                    ->where('delry_clientname','=',$request->delry_clientname)
						                    ->where('delry_dateofdelivery','=',$delry_dateofdelivery)
						                    ->where('delry_lcation','=',$request->delry_lcation)
						                    ->where('delry_time','=',$delry_time)
						                    ->where('user_id','=',$item)
						                    ->first();

			            		$userDeliveryID = Delivery::select('id','delry_clientname','delry_dateofdelivery','delry_lcation','delry_time')
											                    ->where('delry_clientname','=',$request->delry_clientname)
											                    ->where('delry_dateofdelivery','=',$delry_dateofdelivery)
											                    ->where('delry_lcation','=',$request->delry_lcation)
											                    ->where('delry_time','=',$delry_time)
											                    ->where('user_id','=',$user_id)
											                    ->first();
			             		$delivery = new Delivery();
					            $delivery->user_id = $item;
					            $delivery->rh = $userinfo->rh;
					            $delivery->rm = $userinfo->rm;
					            $delivery->tl = $userinfo->tl;
					            $delivery->branch = $user_branch;
					            $delivery->delry_clientname  = $request->delry_clientname;
					            $delivery->delry_lcation  = $request->delry_lcation;
					            $delivery->delry_dateofdelivery  = $delry_dateofdelivery;
					            $delivery->delry_time  = $delry_time;
					            $delivery->purposeofdelivery  = $request->purposeofdelivery;
					            $delivery->itemdescription  = $request->itemdescription;
					            $delivery->delry_ERTW  = $delry_ERTW;
					            $delivery->delivery_references_id  = $userDeliveryID->id;
					            $delivery->save();

					            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
				                {               
				                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
				                    if($User_Attendence)
		                    		{
					                    if($delivery->delry_time <= '11:00:00')
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
					                    if($delivery->delry_time <= '11:30:00')
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
					                    if($delivery->delry_time <= '11:30:00')
					                    {
					                        $User_Attendence->$num_word = 'M';
					                        $User_Attendence->save();
					                    }
				                	}
				                } 

					            $Mail = new SendMail();
				                $cc = $Mail->getusers($user,$userinfo); 

				                $send_to = User::find($userinfo->tl);

				                Mail::to($send_to)->send(new UserDelivery($user,$delivery,$cc,$userinfo));
			             	}
			             }
			              	Toastr::success('You Have Successfully Submitted Delivery Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        			return back();
                    }
                    else{
            				Toastr::error('Delivery Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		            		return back();     
        		}
    }
    public function dismantle(){
    			$user = Auth::user(); 
		    	$Employees = User::where('branch','=',$user->branch)->where('email_verify','=',1)->where('status','=','active')->get();
		       	$userbranch = Branch::find($user->branch); 
		        if($user->user_position == 5){
		            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
		                $Dismentalid = Dismental::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
		            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
		                $Dismentalid = Dismental::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
		            }
		        }
		        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
		            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
		                $Dismentalid = Dismental::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('dis_dateofdismantle', 'desc')
		       								->get();            
		            }elseif($user->branch == 2 || $user->branch == 5){
		                $Dismentalid = Dismental::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('dis_dateofdismantle', 'desc')
		       								->get();
		            }elseif($user->branch == 3){
		                $Dismentalid = Dismental::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('dis_dateofdismantle', 'desc')
		       								->get();
		            }elseif($user->branch == 4){
		                $Dismentalid = Dismental::where('user_id','=',$user->id)
		        							->orWhere('tl','=',$user->id)    
					                        ->orWhere('rm','=',$user->id)
					                        ->orWhere('rh','=',$user->id)
					                        ->orderBy('dis_dateofdismantle', 'desc')
		       								->get();    
		            }        
		        }else{
		                $Dismentalid = Dismental::where('user_id','=',$user->id)->get(); 
		        }	
    	return view('user.workschedule.dismantle',compact('Employees','Dismentalid'));
    }
    public function dismantlecreate(Request $request){
    				$request->validate([
						                'dis_clientname' => ['required'],
						                'dis_eventname' => ['required'],  
						                'dis_dateofdismantle' => ['required'], 
						                'dis_location' => ['required'],
						                'dis_time' => ['required'],
						                'dis_EWH' => ['required']
							        ], [
						                'dis_clientname.required' => 'Please enter the client name.',
						                'dis_eventname.required' => 'Please enter the event name.',
						                'dis_dateofdismantle.required' => 'Please select the dismantle date',
						                'dis_location.required' => 'Please enter the location.',     
						                'dis_time.required' => 'Please select the start time of dismantle',     
						                'dis_EWH.required' => 'Please select the expected work hours'
							        ]);  

    				$user = Auth::user();
		    		$user_id = $user->id;  
		    		$user_branch = $user->branch; 

		    		$today = Carbon::today(); 

			        $Meeting_date = Carbon::parse($request->dis_dateofdismantle);

			        $day = $Meeting_date->day;

			        $number = new ConvertNumber(); 
			        $num_word = $number->numberTowords($day);

		    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
		                    ->where('user_id','=',$user_id)
		                    ->first();
    				 
    				$dis_dateofdismantle = Carbon::parse($request->dis_dateofdismantle	)->format('Y-m-d');
		            $dis_time = Carbon::parse($request->dis_time)->format('H:i:s'); 

		            $checkdismantle = Dismental::select('dis_clientname','dis_eventname','dis_location','dis_dateofdismantle','dis_time')
						                    ->where('dis_clientname','=',$request->dis_clientname)
						                    ->where('dis_eventname','=',$request->dis_eventname)
						                    ->where('dis_location','=',$request->dis_location)
						                    ->where('dis_dateofdismantle','=',$dis_dateofdismantle)
						                    ->where('dis_time','=',$dis_time)
						                    ->where('user_id','=',$user_id)
						                    ->first();
					$tagemployee = $request->dis_references_id;
					if(is_null($checkdismantle)){
                    	$dismental = new Dismental();
			            $dismental->user_id = $user_id;
			            $dismental->rh = $userinfo->rh;
			            $dismental->rm = $userinfo->rm;
			            $dismental->tl = $userinfo->tl;
			            $dismental->branch = $user_branch;
			            $dismental->dis_clientname  = $request->dis_clientname;
			            $dismental->dis_eventname  = $request->dis_eventname;
			            $dismental->dis_location  = $request->dis_location;
			            $dismental->dis_dateofdismantle  = $dis_dateofdismantle;
			            $dismental->dis_time  = $dis_time;
			            $dismental->dis_EWH  = $request->dis_EWH;
			            $dismental->save();

			            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
		                {               
		                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
		                    if($User_Attendence)
		                    {
			                    if($dismental->dis_time <= '11:00:00')
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
			                    if($dismental->dis_time <= '11:30:00')
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
			                    if($dismental->dis_time <= '11:30:00')
			                    {
			                        $User_Attendence->$num_word = 'M';
			                        $User_Attendence->save();
			                    }
		                	}
		                } 

			            $Mail = new SendMail();
		                $cc = $Mail->getusers($user,$userinfo); 

		                $send_to = User::find($userinfo->tl);

		                Mail::to($send_to)->send(new UserDismantle($user,$dismental,$cc,$userinfo));

			             if(! empty($tagemployee)){
			             	foreach ($tagemployee as $item){

			             		$user = User::find($item);
			             		$user_branch = Auth::user()->branch; 
					    		$userinfo = UserDetails::select('emp_id','tl','rm','rh','signature')
									                    ->where('user_id','=',$item)
									                    ->first(); 
			             		
						       $checkdismantle = Dismental::select('dis_clientname','dis_eventname','dis_location','dis_dateofdismantle','dis_time')
						                    ->where('dis_clientname','=',$request->dis_clientname)
						                    ->where('dis_eventname','=',$request->dis_eventname)
						                    ->where('dis_location','=',$request->dis_location)
						                    ->where('dis_dateofdismantle','=',$dis_dateofdismantle)
						                    ->where('dis_time','=',$dis_time)
						                    ->where('user_id','=',$item)
						                    ->first();

			            		$userDismentalID = Dismental::select('id','dis_clientname','dis_eventname','dis_location','dis_dateofdismantle','dis_time')
											                    ->where('dis_clientname','=',$request->dis_clientname)
											                    ->where('dis_eventname','=',$request->dis_eventname)
											                    ->where('dis_location','=',$request->dis_location)
											                    ->where('dis_dateofdismantle','=',$dis_dateofdismantle)
											                    ->where('dis_time','=',$dis_time)
											                    ->where('user_id','=',$user_id)
											                    ->first();
			             		$dismental = new Dismental();
					            $dismental->user_id = $item;
					            $dismental->rh = $userinfo->rh;
					            $dismental->rm = $userinfo->rm;
					            $dismental->tl = $userinfo->tl;
					            $dismental->branch = $user_branch;
					            $dismental->dis_clientname  = $request->dis_clientname;
					            $dismental->dis_eventname  = $request->dis_eventname;
					            $dismental->dis_location  = $request->dis_location;
					            $dismental->dis_dateofdismantle  = $dis_dateofdismantle;
					            $dismental->dis_time  = $dis_time;
					            $dismental->dis_EWH  = $request->dis_EWH;
					            $dismental->dis_references_id  = $userDismentalID->id;
					            $dismental->save();

					            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
				                {               
				                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$user->id)->first();
				                    if($User_Attendence)
		                    		{
					                    if($dismental->dis_time <= '11:00:00')
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
					                    if($dismental->dis_time <= '11:30:00')
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
					                    if($dismental->dis_time <= '11:30:00')
					                    {
					                        $User_Attendence->$num_word = 'M';
					                        $User_Attendence->save();
					                    }
				                	}
				                }

					            $Mail = new SendMail();
				                $cc = $Mail->getusers($user,$userinfo); 

				                $send_to = User::find($userinfo->tl);

				                Mail::to($send_to)->send(new UserDismantle($user,$dismental,$cc,$userinfo));
			             	}
			             }
			             	Toastr::success('You Have Successfully Submitted Dismantle Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);   
		        			return back();
                    }
                    else{
            				Toastr::error('Dismantle Details Already Submitted!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		            		return back(); 
        		}
    }
}
