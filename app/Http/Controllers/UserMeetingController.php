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
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Toastr;
use App\Branch;
use App\States;
use App\User;
use App\UserDetails;
use App\UserMeeting;
use App\Clients;
use Carbon\Carbon;

class UserMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function meeting()
    {
    	$User = Auth::user();    	
        if($User->branch == 1 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->get();
        }
        elseif($User->branch == 4)
        {
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->get();
        }

    	return view('user.meeting.meeting',compact('Users'));
    }

    function companylist(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');        

            $data = Clients::select('company_name')->distinct('company_name')->where('company_name', 'LIKE', '%'.$query.'%') ->orderBy('company_name', 'asc')->get();

            $collection = collect($data);

            $unique_data = $collection->unique()->values()->all();

            if(count($unique_data) > 0)
            {
                $output = '<ul class="dropdown-menu companylist" style="display:block;position:relative;width: 100%;">';

                foreach($unique_data as $row)
                {
                  $output .= '<li><a>'.$row->company_name.'</a></li>'; 
                }   
    
                $output .='</ul>';
    
                echo $output;
            }else{
                $msg ="No search result found";
                
                $output = '<ul class="dropdown-menu companylist" style="display:block;position:relative;width: 100%;pointer-events: none;">';
                $output .= '<li><a>'.$msg.'</a></li>';

                $output .='</ul>';
                
                echo $output;
            }       
        }
    }

    public function addmeeting(Request $request)
    {    	
    	if(is_null($request->exist_company_name) && is_null($request->new_company_name)){
    		Toastr::error('Please Select Or Enter Company Name!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        	return back();
    	}

    	$request->validate([
            'client_name' => ['required'],
            'client_email' => ['required'],  
            'date' => ['required'],  
            'time' => ['required'], 
            'duration' => ['required'],
            'location' => ['required'],  
            'expected_time' => ['required'],   
            'purpose_of_working' => ['required']
        ], [
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

        $meeting = UserMeeting::where('user_id',$User->id)->where('company_name','=',$companyname)->where('date',$request->date)->where('time',$request->time)->first();

        if(!is_null($meeting))
        {
            Toastr::error('Please Check The Details Because You Have Already Meeting In That Slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        else
        { 
            if(is_null($request->tag_user))
            {
                $user_meeting = UserMeeting::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh,
                                    'company_status' => $request->company,
                                    'company_name' => $companyname,
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

                Mail::to($send_to)->send(new UsersMeeting($User,$user_meeting,$cc,$User_details));

            }else{
               
                foreach($request->tag_user as $tag_user){
                    $tag_meeting = UserMeeting::where('user_id',$tag_user)->where('company_name','=',$companyname)->where('date',$request->date)->where('time',$request->time)->first(); 

                    if($tag_meeting)
                    {
                        Toastr::error('Please Check Tag Users Already Having Meeting In That Slot!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }                   
                }

                $user_meeting = UserMeeting::create([
                                    'user_id' => $User->id,
                                    'branch' => $User->branch,
                                    'tl' => $User_details->tl,
                                    'rm' => $User_details->rm,
                                    'rh' => $User_details->rh,
                                    'company_status' => $request->company,
                                    'company_name' => $companyname,
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
                Mail::to($send_to)->send(new UsersMeeting($User,$user_meeting,$cc,$User_details));

                foreach($request->tag_user as $tag_user){
                    $TagUser = User::find($tag_user);
                    $Tag_details = UserDetails::where('user_id', $TagUser->id)->first();

                    $Tag_meeting =  UserMeeting::create([
                                        'user_id' => $TagUser->id,
                                        'branch' => $TagUser->branch,
                                        'tl' => $Tag_details->tl,
                                        'rm' => $Tag_details->rm,
                                        'rh' => $Tag_details->rh,
                                        'company_status' => $request->company,
                                        'company_name' => $companyname,
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
                        $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$TagUser->id)->first();
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
                    Mail::to($send_to)->send(new UsersMeeting($TagUser,$Tag_meeting,$cc,$Tag_details));
                }
            }

            Toastr::success('You Have Successfully Submitted Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();           
        }   
    }

    public function meetinglist()
    {
        $user = Auth::user(); 
        $States = States::all();
        $userbranch = Branch::find($user->branch);      
        if($user->user_position == 5){
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7){
                $meetings = UserMeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5){
                $meetings = UserMeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($user->user_position == 1 || $user->user_position == 2 || $user->user_position == 3){
            if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){                               
                $meetings = UserMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();       
            }elseif($user->branch == 2 || $user->branch == 5){
                $meetings = UserMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 3){
                $meetings = UserMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();
            }elseif($user->branch == 4){
                $meetings = UserMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->orwhere('tl',$user->id)->orwhere('rm',$user->id)->orwhere('rh',$user->id)->get();    
            }        
        }else{
                $meetings = UserMeeting::where('user_id','=',$user->id)->orderBy('created_at', 'desc')->get();
        }       
      
        return view('user.meeting.meeting_list',compact('meetings','States'));
    }

    public function uploadmeeting($EncryptedID)
    {   
        $States = States::all();
        $ID = Crypt::decrypt($EncryptedID);
        $Details = UserMeeting::find($ID);

        if(is_null($Details->referred_id)){
            $parent_id = $Details->id;
        }else{
            $parent_id = $Details->referred_id;
        }  

        $collection = collect();

        $res=array();

        $meeting = UserMeeting::join('users','user_meetings.user_id','=','users.id')->where('user_meetings.id','=',$parent_id)->select('users.first_name','users.last_name')->get();

        $meetings = UserMeeting::join('users','user_meetings.user_id','=','users.id')->where('user_meetings.referred_id','=',$parent_id)->select('users.first_name','users.last_name')->get();               
                
        foreach ($meeting as $meet)
            $collection->push($meet);
        foreach ($meetings as $meets)
            $collection->push($meets);        

        foreach($collection as $m)
        {
            $name = $m->first_name.' '.$m->last_name;
            array_push($res,$name);   
        }

        $data = array_values(array_filter(array_unique($res))); 

        $data = implode($data,',');

        $parent_id = Crypt::encrypt($parent_id);

        if($Details->company_status == 'exist')
        {
            $exist = Clients::where('company_name','like', '%' . $Details->company_name . '%')->orderBy('company_name', 'desc')->first();  
        }else{
            $exist = NULL;
        }
      
        return view('user.meeting.upload_meeting',compact('Details','States','data','EncryptedID','parent_id','exist'));
    }

    public function submitmeetingdetails(Request $request)
    {
        $Auth = Auth::user();       

        //////////////////returning back to list page/////////////////////////

        $userbranch = Branch::find($Auth->branch);      
        if($Auth->user_position == 5){
            if($Auth->branch == 1 || $Auth->branch == 4 || $Auth->branch == 6 || $Auth->branch == 7){
                $meetings = UserMeeting::whereIn('branch',[1,4,6,7])->orderBy('created_at', 'desc')->get();
            }elseif($Auth->branch == 2 || $Auth->branch == 3 || $Auth->branch == 5){
                $meetings = UserMeeting::whereIn('branch',[2,3,5])->orderBy('created_at', 'desc')->get();
            }
        }
        elseif($Auth->user_position == 1 || $Auth->user_position == 2 || $Auth->user_position == 3){
            if($Auth->branch == 1 || $Auth->branch == 6 || $Auth->branch == 7){                               
                $meetings = UserMeeting::where('user_id','=',$Auth->id)->orderBy('created_at', 'desc')->orwhere('tl',$Auth->id)->orwhere('rm',$Auth->id)->orwhere('rh',$Auth->id)->get();       
            }elseif($Auth->branch == 2 || $Auth->branch == 5){
                $meetings = UserMeeting::where('user_id','=',$Auth->id)->orderBy('created_at', 'desc')->orwhere('tl',$Auth->id)->orwhere('rm',$Auth->id)->orwhere('rh',$Auth->id)->get();
            }elseif($Auth->branch == 3){
                $meetings = UserMeeting::where('user_id','=',$Auth->id)->orderBy('created_at', 'desc')->orwhere('tl',$Auth->id)->orwhere('rm',$Auth->id)->orwhere('rh',$Auth->id)->get();
            }elseif($Auth->branch == 4){
                $meetings = UserMeeting::where('user_id','=',$Auth->id)->orderBy('created_at', 'desc')->orwhere('tl',$Auth->id)->orwhere('rm',$Auth->id)->orwhere('rh',$Auth->id)->get();    
            }        
        }else{
                $meetings = UserMeeting::where('user_id','=',$Auth->id)->orderBy('created_at', 'desc')->get();
        } 

        ///////////////////////////////////////////////////////////////////////

        $ID = Crypt::decrypt($request->mom_id);
        $Mom_Details = UserMeeting::find($ID);
        $Parent_ID = Crypt::decrypt($request->parent_mom);        

        if($request->meeting_status == 'Completed')
        {   
            if(is_null($request->exist_company_name) && is_null($request->exist_company_email) && is_null($request->alt_company_name) && is_null($request->alt_company_email))
            {
                Toastr::error('Please Fill The Client Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                return back();
            }

            $request->validate([
                'company_name' => ['required'],
                'client_status' => ['required'],  
                'date' => ['required'],  
                'time' => ['required'],           
                'location' => ['required'],  
                'person_involved' => ['required'],   
                'from_client' => ['required'],
                'from_agency' => ['required'],
                'key_points' => ['required'],
                'mobile' => ['required'],
                'landline' => ['required'],
                'address_1' => ['required'],
                'address_2' => ['required'],
                'address_3' => ['required'],
                'state' => ['required'],
                'city' => ['required'],
                'zip_code' => ['required'],
            ], [
                'company_name.required' => 'Please Enter Company Name',
                'client_status.required' => 'Please Select Atleast One Status OF client Details',     
                'date.required' => 'Please Select Date Of Meeting',   
                'time.required' => 'Please Select Time Of Meeting',               
                'location.required' =>'Please Enter Location Of Meeting',  
                'person_involved.required' => 'Please Enter Total No Of Persons Involved In Meeting.',    
                'from_client.required' => 'Please Enter Name Of client Team Members Involved In Meeting',
                'from_agency.required' => 'Please Enter Name Of Agency Team Members Involved In Meeting',
                'key_points.required' => 'Please Enter Key Points Or Discussion Points From The Meeting ',
                'mobile.required' => 'Please Enter Mobile Number',
                'landline.required' => 'Please Enter Landline Number',
                'address_1.required' => 'Please Enter Address Line No 1',
                'address_2.required' => 'Please Enter Address Line No 3',
                'address_3.required' => 'Please Enter Address Line No 3',    
                'state.required' => 'Please Select State',
                'city.required' => 'Please Enter City Name',
                'zip_code.required' => 'Please Enter Zip Code',                 
            ]); 
            
            libxml_use_internal_errors(true);
            $dom = new \domdocument();
            $dom->loadHtml(mb_convert_encoding($request->key_points, 'HTML-ENTITIES', 'UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
            $key_points = $dom->savehtml();  
                      

            $client = new Clients();
            $client->user_id = $Auth->id;
            $client->mom_id = $ID;
            $client->parent_mom_id = $Parent_ID;
            $client->company_name = $request->company_name;
            $client->client_name = $request->exist_company_name;
            $client->client_email = $request->exist_company_email;
            $client->alternate_client_name = $request->alt_company_name;
            $client->alternate_client_email = $request->alt_company_email;
            $client->date = $request->date;
            $client->time = $request->time;
            $client->location = $request->location;
            $client->bcc_email = implode($request->bcc_email,',');
            $client->extra_email = implode($request->additional_email,',');
            $client->person_involved = $request->person_involved;
            $client->from_client = $request->from_client;
            $client->from_agency = $request->from_agency; 
            $client->key_points = $key_points;
            $client->mobile = $request->mobile;
            $client->landline = $request->landline;
            $client->address_1 = $request->address_1;
            $client->address_2 = $request->address_2;
            $client->address_3 = $request->address_3;
            $client->state = $request->state;
            $client->city = $request->city;
            $client->zipcode = $request->zip_code;
            $client->save();
            

            if($Mom_Details->referred_id == NULL)
            {
                UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->update(['meeting_status'=>$request->meeting_status]);   
                UserMeeting::where('referred_id',$ID)->update(['meeting_status'=>$request->meeting_status]);

                //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->select('user_id','client_email')->first();
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$ID)->select('user_id')->get();
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        array_push($Ref,$ruser->email);      
                }

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 

                $username = $Ouser->first_name.' '.$Ouser->last_name;
                $bcc = '';

                if(is_null($request->alt_company_email))
                {
                    if(empty($client->bcc_email) && empty($client->extra_email)){
                        $cc = array_merge($Ref,(array)$Ouser->email,$cc);                   
                    }else{
                        if(!empty($client->bcc_email) && empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }
                        elseif(empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                        }
                        elseif(!empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }                       
                    } 
                   // dd("alt",$request->exist_company_email,$cc,$bcc);
                    Mail::to($request->exist_company_email)->send(new ReviewClientMoM($Ouser,$client,$cc,$Ouser_details,$bcc));
                }
                elseif(is_null($request->exist_company_email))
                {
                    if(empty($client->bcc_email) && empty($client->extra_email)){
                        $cc = array_merge($Ref,(array)$Ouser->email,$cc);                   
                    }else{
                        if(!empty($client->bcc_email) && empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }
                        elseif(empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                        }
                        elseif(!empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }                       
                    } 

                    //$cc = array_merge($cc,(array)$Own_user->client_email);
                   // dd("exist",$request->alt_company_email,$cc,$bcc);
                    Mail::to($request->alt_company_email)->send(new ReviewClientMoM($Ouser,$client,$cc,$Ouser_details,$bcc));
                }   

                ///////////////////////////////////////////////////////////////////////////////////////////////////             
            }
            elseif($ID != $Mom_Details->referred_id)
            {
                UserMeeting::where('id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status]);   
                UserMeeting::where('referred_id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status]);  

                 //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->first();
                
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->select('user_id')->get();
               
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        array_push($Ref,$ruser->email);      
                }

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 
                $bcc = "";

                $username = $Ouser->first_name.' '.$Ouser->last_name;

                if(is_null($request->alt_company_email))
                {
                    if(empty($client->bcc_email) && empty($client->extra_email)){
                        $cc = array_merge($Ref,(array)$Ouser->email,$cc);                   
                    }else{
                        if(!empty($client->bcc_email) && empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }
                        elseif(empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = "";
                        }
                        elseif(!empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }                       
                    } 
                  
                    Mail::to($request->exist_company_email)->send(new ReviewClientMoM($Ouser,$client,$cc,$Ouser_details,$bcc));
                }
                elseif(is_null($request->exist_company_email))
                {
                    if(empty($client->bcc_email) && empty($client->extra_email)){
                        $cc = array_merge($Ref,(array)$Ouser->email,$cc);                   
                    }else{
                        if(!empty($client->bcc_email) && empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }
                        elseif(empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = "";
                        }
                        elseif(!empty($client->bcc_email) && !empty($client->extra_email))
                        {
                            $cc = array_merge($Ref,(array)$Ouser->email,explode(',',$client->extra_email),$cc);
                            $bcc = explode(',',$client->bcc_email);
                        }                       
                    } 

                  //  $cc = array_merge($cc,(array)$Own_user->client_email);

                    Mail::to($request->alt_company_email)->send(new ReviewClientMoM($Ouser,$client,$cc,$Ouser_details,$bcc));
                }   

                ///////////////////////////////////////////////////////////////////////////////////////////////////             
            }        


            Toastr::success('You Have Successfully Submitted Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return redirect()->route('meeting_list',compact('meetings','States'));  
        }
        elseif($request->meeting_status == 'Postponed')
        {
            $request->validate([
                'postpone' => ['required'],
            ], [
                'postpone.required' => 'Please Enter Reason For Postponing The Meeting',
            ]); 

            if($Mom_Details->referred_id == NULL)
            {
                UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->postpone]);   
                UserMeeting::where('referred_id',$ID)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->postpone]);


                //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->first();
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$ID)->select('user_id')->get();

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 

                $send_to = User::find($Ouser_details->tl);

                $username = $Ouser->first_name.' '.$Ouser->last_name;
                Mail::to($send_to)->send(new StatusMoM($Ouser,$Own_user,$cc,$Ouser_details));

               
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        $ruser_details = UserDetails::where('user_id', $ruser->id)->first();
                        $cc = $Mail->getusers($ruser,$ruser_details); 

                        $send_to = User::find($ruser_details->tl);

                        $username = $ruser->first_name.' '.$ruser->last_name;
                        Mail::to($send_to)->send(new StatusMoM($ruser,$Own_user,$cc,$ruser_details));                          
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////        

               
            }
            elseif($ID != $Mom_Details->referred_id)
            {
                UserMeeting::where('id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->postpone]);   
                UserMeeting::where('referred_id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->postpone]);   

                //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->first();
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->select('user_id')->get();

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 

                $send_to = User::find($Ouser_details->tl);

                $username = $Ouser->first_name.' '.$Ouser->last_name;
                Mail::to($send_to)->send(new StatusMoM($Ouser,$Own_user,$cc,$Ouser_details));

               
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        $ruser_details = UserDetails::where('user_id', $ruser->id)->first();
                        $cc = $Mail->getusers($ruser,$ruser_details); 

                        $send_to = User::find($ruser_details->tl);

                        $username = $ruser->first_name.' '.$ruser->last_name;
                        Mail::to($send_to)->send(new StatusMoM($ruser,$Own_user,$cc,$ruser_details));                          
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////               
            }  

            Toastr::success('You Have Successfully Submitted Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return redirect()->route('meeting_list', compact('meetings','States')); 
        }
        elseif ($request->meeting_status == 'Canceled') 
        {
            $request->validate([
                'cancel' => ['required'],
            ], [
                'cancel.required' => 'Please Enter Reason For Canceling The Meeting',
            ]); 

            if($Mom_Details->referred_id == NULL)
            {
                UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->cancel]);   
                UserMeeting::where('referred_id',$ID)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->cancel]);

                  //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('id',$ID)->where('user_id',$Auth->id)->first();
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$ID)->select('user_id')->get();

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 

                $send_to = User::find($Ouser_details->tl);

                $username = $Ouser->first_name.' '.$Ouser->last_name;
                Mail::to($send_to)->send(new StatusMoM($Ouser,$Own_user,$cc,$Ouser_details));

               
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        $ruser_details = UserDetails::where('user_id', $ruser->id)->first();
                        $cc = $Mail->getusers($ruser,$ruser_details); 

                        $send_to = User::find($ruser_details->tl);

                        $username = $ruser->first_name.' '.$ruser->last_name;
                        Mail::to($send_to)->send(new StatusMoM($ruser,$Own_user,$cc,$ruser_details));                          
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////  
            }
            elseif($ID != $Mom_Details->referred_id)
            {
                UserMeeting::where('id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->cancel]);   
                UserMeeting::where('referred_id',$Mom_Details->referred_id)->update(['meeting_status'=>$request->meeting_status,'reason'=>$request->cancel]);    

                   //////////////////////////////////////Only For Mail/////////////////////////////////////////////

                $Own_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->first();
                $Ouser = User::find($Own_user->user_id);
                $Ouser_details = UserDetails::where('user_id', $Own_user->user_id)->first();
                $Referred_user = UserMeeting::where('referred_id',$Mom_Details->referred_id)->select('user_id')->get();

                $Mail = new SendMail();
                $cc = $Mail->getusers($Ouser,$Ouser_details); 
                
                $send_to = User::find($Ouser_details->tl);

                $username = $Ouser->first_name.' '.$Ouser->last_name;
                Mail::to($send_to)->send(new StatusMoM($Ouser,$Own_user,$cc,$Ouser_details));

               
                $Ref=array();
                foreach ($Referred_user as $value) {
                        $ruser = User::find($value->user_id);
                        $ruser_details = UserDetails::where('user_id', $ruser->id)->first();
                        $cc = $Mail->getusers($ruser,$ruser_details); 

                        $send_to = User::find($ruser_details->tl);

                        $username = $ruser->first_name.' '.$ruser->last_name;
                        Mail::to($send_to)->send(new StatusMoM($ruser,$Own_user,$cc,$ruser_details));                          
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////            
            }  

            Toastr::success('You Have Successfully Submitted Meeting Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return redirect()->route('meeting_list',compact('meetings','States')); 
        }

    }
}
