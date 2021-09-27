<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Toastr;
use ZipArchive;
use App\User;
use App\UserDetails;
use App\Department;
use App\States;
use App\PassportDetails;
use App\UserBankDetails;
use App\UserPfForm;
use App\UserAcademics;
use App\UserEmployment;
use App\UserFamily;
use App\UserDocument;
use App\UserOtherDetails;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\UserOfficialDocument;
use App\Wishes;

class UserController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');       
    }    

    public function dashboard()
    { 
        $User = Auth::user();
        $today = Carbon::now();
	    $dates = []; 

	    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
	        $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
	    }

	 	if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7 )
        {               
           	$Data = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();  
           	if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }  
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Data = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            
            if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }
        }
        elseif($User->branch == 3)
        {               
            $Data = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            
            if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            } 
        }           
        
        $Birthday = UserDetails::join('users','user_details.user_id','=','users.id')->whereDay('user_details.dob',$today->day)->whereMonth('user_details.dob',$today->month)->where('users.status','=','active')->get(); 
       
        $Wishes = Wishes::all()->where('level','1')->sortByDesc('created_at');

        $Work = UserDetails::join('users','user_details.user_id','=','users.id')->whereDay('user_details.doj',$today->day)->whereMonth('user_details.doj',$today->month)->where('users.status','=','active')->get();

        $WorkWishes = Wishes::all()->where('level','2')->sortByDesc('created_at');
        
        $Attendence = array_sum($attend);

        
        if(!is_null($User->confirme_date))
        {
            $Date =Carbon::parse($User->confirme_date);

            $Current = Carbon::now();    
            $Datas = array();
            $i=0;

            if($Current->month < 4)
            {
                $Last = new Carbon('last year');
                $Current = $Current->year.'-03';
                $Last = $Last->year.'-04';
                $period = CarbonPeriod::create($Last, '1 month', $Current);
                foreach ($period as $dt) {    
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }                        
            }
            else
            {
                $Next = new Carbon('next year');
                $Current = $Current->year.'-04';
                $Next = $Next->year.'-03';
                $period = CarbonPeriod::create($Current, '1 month', $Next);
                foreach ($period as $dt) {
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }
            }

            if(in_array($Date->format("Y-m"), $Datas))
            {
               $Key = array_search($Date->format("Y-m"), $Datas);
               $Res = array_slice($Datas,$Key);
               $Days = count($Res) * 1.5;          
            }
            else
            {
                $Days = 18;
            }
        }
        else
        {
            $Days = 0;
        } 
        
        return view('user.dashboard.dashboard',compact('dates','today','Data','Birthday','Wishes','User','Work','WorkWishes','Attendence','Days'));
    }

    public function profile()
    {
        $user = Auth::User();
        $user_details = UserDetails::where('user_id',$user->id)->first();

        if(is_null($user_details->dob)){
            $dob_date = $user_details->dob;
        }else{
            $dob_date = \Carbon\Carbon::parse($user_details->dob);     
            $dob_date = $dob_date->format('l jS F Y'); 
        }
            
        if(is_null($user_details->doj)){
            $doj_date = $user_details->doj;
        }else{
            $doj_date = \Carbon\Carbon::parse($user_details->doj); 
            $doj_date = $doj_date->format('l jS F Y'); 
        }

        if(is_null($user_details->marriage_date)){
            $marriage_date = $user_details->marriage_date;
        }else{
            $marriage_date = \Carbon\Carbon::parse($user_details->marriage_date); 
            $marriage_date = $marriage_date->format('l jS F Y'); 
        }

        $passport_details = PassportDetails::where('user_id',$user->id)->first();
        if(is_null($passport_details->issued_on)){
            $issued_on = $passport_details->issued_on;
        }else{
            $issued_on = \Carbon\Carbon::parse($passport_details->issued_on);     
            $issued_on = $issued_on->format('l jS F Y'); 
        }
            
        if(is_null($passport_details->expiry_on)){
            $expiry_on = $passport_details->expiry_on;
        }else{
            $expiry_on = \Carbon\Carbon::parse($passport_details->expiry_on); 
            $expiry_on = $expiry_on->format('l jS F Y'); 
        }

        $bank_details = UserBankDetails::where('user_id',$user->id)->first();

        $pf_details = UserPfForm::where('user_id',$user->id)->first();
        if(is_null($pf_details->pf_dob)){
            $pf_dob = $pf_details->pf_dob;
        }else{
            $pf_dob = \Carbon\Carbon::parse($pf_details->pf_dob);     
            $pf_dob = $pf_dob->format('l jS F Y'); 
        }
            
        if(is_null($pf_details->pf_doj)){
            $pf_doj = $pf_details->pf_doj;
        }else{
            $pf_doj = \Carbon\Carbon::parse($pf_details->pf_doj); 
            $pf_doj = $pf_doj->format('l jS F Y'); 
        }
        if(is_null($pf_details->father_dob)){
            $father_dob = $pf_details->father_dob;
        }else{
            $father_dob = \Carbon\Carbon::parse($pf_details->father_dob);     
            $father_dob = $father_dob->format('l jS F Y'); 
        }
            
        if(is_null($pf_details->mother_dob)){
            $mother_dob = $pf_details->mother_dob;
        }else{
            $mother_dob = \Carbon\Carbon::parse($pf_details->mother_dob); 
            $mother_dob = $mother_dob->format('l jS F Y'); 
        }
        if(is_null($pf_details->husb_or_wife_dob)){
            $husb_or_wife_dob = $pf_details->husb_or_wife_dob;
        }else{
            $husb_or_wife_dob = \Carbon\Carbon::parse($pf_details->husb_or_wife_dob);     
            $husb_or_wife_dob = $husb_or_wife_dob->format('l jS F Y'); 
        }
            
        if(is_null($pf_details->son_dob)){
            $son_dob = $pf_details->son_dob;
        }else{
            $son_dob = \Carbon\Carbon::parse($pf_details->son_dob); 
            $son_dob = $son_dob->format('l jS F Y'); 
        }
        if(is_null($pf_details->daughter_dob)){
            $daughter_dob = $pf_details->daughter_dob;
        }else{
            $daughter_dob = \Carbon\Carbon::parse($pf_details->daughter_dob);     
            $daughter_dob = $daughter_dob->format('l jS F Y'); 
        } 

        $documents = UserDocument::where('user_id',$user->id)->first();

        $id_proof = current(explode('|',$documents->id_proof));  
        $aadhar = current(explode('|',$documents->aadhar));   
        $pan = current(explode('|',$documents->pan));
        $exp_letter = current(explode('|',$documents->exp_letter));
        $salary_slip = current(explode('|',$documents->salary_slip));
        $bank_stat = current(explode('|',$documents->bank_stat));
        $sslc = current(explode('|',$documents->sslc));
        $puc = current(explode('|',$documents->puc));
        $graduate = current(explode('|',$documents->graduate));
        $post_graduate = current(explode('|',$documents->post_graduate));
        $other_qualification = current(explode('|',$documents->other_qualification));
        $certificate_course = current(explode('|',$documents->certificate_course));      

        $other_details = UserOtherDetails::where('user_id',$user->id)->first();
        
        $states = States::all();
        
        $departments = Department::all();

        if($user->branch == 1 || $user->branch == 6 || $user->branch == 7){
            $rhs = User::where('user_position','1')->whereIn('branch',[1,6,7])->where('status','=','active')->get();
            $rms = User::whereIn('user_position',[1,2,3])->whereIn('branch',[1,6,7])->where('status','=','active')->get();
            $tls = User::whereIn('user_position', [1,2,3,4])->whereIn('branch',[1,6,7])->where('status','=','active')->get();
        }elseif($user->branch == 2 || $user->branch == 5){
            $rhs = User::where('user_position','1')->whereIn('branch',[2,5])->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
            $rms = User::whereIn('user_position',[1,2,3])->whereIn('branch',[2,5])->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
            $tls = User::whereIn('user_position', [1,2,3,4])->whereIn('branch',[2,5])->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
        }elseif($user->branch == 3){
            $rhs = User::where('user_position','1')->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
            $rms = User::whereIn('user_position',[1,2,3])->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
            $tls = User::whereIn('user_position', [1,2,3,4])->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',3)->where('status','=','active')->get();
        }elseif($user->branch == 4){
            $rhs = User::where('user_position','1')->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',2)->where('status','=','active')->get();
            $rms = User::whereIn('user_position',[1,2,3])->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',2)->where('status','=','active')->get();
            $tls = User::whereIn('user_position', [1,2,3,4])->where('branch','=',$user->branch)->orwhere('admin','=',1)->orwhere('admin','=',2)->where('status','=','active')->get();  
        }  

        return view('user.profile.profile',compact('user','user_details','rhs','rms','tls','states','dob_date','doj_date','marriage_date','passport_details','bank_details','issued_on','expiry_on','pf_details','pf_dob','pf_doj','father_dob','mother_dob','husb_or_wife_dob','son_dob','daughter_dob','other_details','id_proof','aadhar','pan','exp_letter','salary_slip','bank_stat','sslc','puc','graduate','post_graduate','other_qualification','certificate_course','departments'));
    }

    public function update_basic_details(Request $request)
    {     
        if(is_null($request->team_lead)) {
            $team_lead = 0;
        }else{
            $team_lead = $request->team_lead;
        }

        if(is_null($request->dob)){
            $dob_date = $request->dob;
        }else{
           $dob_date = \Carbon\Carbon::parse($request->dob);  
        }

        if(is_null($request->doj)){
            $doj_date = $request->doj;
        }else{
            $doj_date = \Carbon\Carbon::parse($request->doj);                      
        }

        if(is_null($request->marriage_date)){
            $marriage_date = $request->marriage_date;
        }else{
           $marriage_date = \Carbon\Carbon::parse($request->marriage_date); 
        }
        
        $user = Auth::user();
        $user->first_name = $request->f_name;
        $user->last_name = $request->l_name;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->save();

        $user_details = UserDetails::where('user_id',$user->id)->first();
        $user_details->tl = $team_lead;
        $user_details->rm = $request->reporting_manager;
        $user_details->rh = $request->regional_head;
        $user_details->emp_id = $request->emp_id;
        $user_details->ref_emp_id = $request->ref_emp_id;
        $user_details->dob = $dob_date;
        $user_details->doj = $doj_date;
        $user_details->emergency_phone = $request->emrg_phone;
        $user_details->business_phone = $request->buss_phone;
        $user_details->father_name = $request->father_name;
        $user_details->mother_name = $request->mother_name;
        $user_details->occupation = $request->occupation;
        $user_details->marital_status = $request->marital_status;
        $user_details->spouse_name = $request->spouse_name;
        $user_details->marriage_date = $marriage_date;
        $user_details->designation = $request->designation;
        $user_details->department = $request->department;
        $user_details->work_location = $request->location;
        $user_details->blood_group = $request->blood_grp;
        $user_details->local_addr = $request->local_addr;
        $user_details->permanent_addr = $request->permt_addr;        
        $user_details->city = $request->city;
        $user_details->state = $request->state;
        $user_details->pincode = $request->pin_code;

        $Profile_pic = $request->profile_pic;
        if(!is_null($Profile_pic)){         
            $FileName = $Profile_pic->hashName();
            Storage::disk('Uploads')->putFile('user/profilepicture/', $Profile_pic);
            $user_details->profile_picture = 'user/profilepicture/' . $FileName;
        }
       

        $Signature = $request->signature;
        if(!is_null($Signature)){   
            $File = $Signature->hashName();
            Storage::disk('Uploads')->putFile('user/signature/', $Signature);
            $user_details->signature = 'user/signature/' . $File;
        }

        $user_details->save();

        if($user->branch == 1 || $user->branch == 6 || $user->branch == 7 || $user->branch == 4)
        {                
            $Attendence = BangaloreAttendence::where('user_id','=',$user->id)->get();
            foreach($Attendence as $Attd)
            {
                $Attd->emp_id = $request->emp_id; 
                $Attd->save();
            }
            
        }
        elseif($user->branch == 2 || $user->branch == 5)
        {
            $Attendence = MumbaiAttendence::where('user_id','=',$user->id)->get();
            foreach($Attendence as $Attd)
            {
                $Attd->emp_id = $request->emp_id; 
                $Attd->save();
            }
        }
        elseif($user->branch == 3)
        {               
            $Attendence = DelhiAttendence::where('user_id','=',$user->id)->get();
            foreach($Attendence as $Attd)
            {
                $Attd->emp_id = $request->emp_id; 
                $Attd->save();
            }
        }  

        Toastr::success('You Have Successfully Updated Basic Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function update_passport_details(Request $request)
    {   

        $request->validate([
                'passport_no' => ['required', 'string', 'max:255'],
                'issued_at' => ['required', 'string', 'max:255'],
                'issued_on' => ['required'],               
                'expiry_on' => ['required']  
        ], [
                'passport_no.required' => 'Passport Number Required.',
                'issued_at.required' => 'Passport Issued At Required',
                'issued_on.required' => 'Please Select Your Passport Issued Date',
                'expiry_on.required' => 'Please Select Your Passport Expiry Date',     
        ]);          

        if(is_null($request->issued_on)){
            $issued_on = $request->issued_on;
        }else{
            $issued_on = \Carbon\Carbon::parse($request->issued_on); 
        }

        if(is_null($request->expiry_on)){
            $expiry_on = $request->expiry_on;
        }else{
            $expiry_on = \Carbon\Carbon::parse($request->expiry_on);                 
        }

        $user = Auth::user();
        $passport = PassportDetails::where('user_id',$user->id)->first();
        $passport->passport_no = $request->passport_no;
        $passport->issued_at = $request->issued_at;
        $passport->issued_on = $issued_on;
        $passport->expiry_on =  $expiry_on;
        $passport->save();

        Toastr::success('You Have Successfully Updated Your Passport Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
        
    }

    public function update_bank_details(Request $request)
    {        

        $request->validate([
                'acc_name' => ['required', 'string', 'max:255'],
                'acc_no' => ['required', 'string', 'max:255'],
                'bank_name' => ['required'],
                'bank_ifsc' => ['required','string', 'max:255'],
                'bank_branch' => ['required'],    
        ], [
                'acc_name.required' => 'Account Holder Name Is Required.',
                'acc_no.required' => 'Account Number Is Required',
                'bank_name.required' => 'Bank Name Is Required',
                'bank_ifsc.required' => 'Bank IFSC Code Is Required',
                'bank_branch.required' => 'Bank Branch Is Required'     
        ]);  

        $user = Auth::user();
        $bank_details = UserBankDetails::where('user_id',$user->id)->first();
        $bank_details->acc_holder_name = $request->acc_name;
        $bank_details->acc_no = $request->acc_no;
        $bank_details->bank_name = $request->bank_name;
        $bank_details->bank_ifsc = $request->bank_ifsc;
        $bank_details->bank_branch = $request->bank_branch;
        $bank_details->bank_division = $request->bank_division;
        $bank_details->save();

        Toastr::success('You Have Successfully Updated Your Bank Account Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function update_pf_form(Request $request)
    {
        if(is_null($request->pf_dob)){
            $pf_dob = $request->pf_dob;
        }else{
            $pf_dob = \Carbon\Carbon::parse($request->pf_dob);          
        }

        if(is_null($request->pf_doj)){
            $pf_doj = $request->pf_doj;
        }else{
            $pf_doj = \Carbon\Carbon::parse($request->pf_doj);                
        }

        if(is_null($request->father_dob)){
            $father_dob = $request->father_dob;
        }else{
            $father_dob = \Carbon\Carbon::parse($request->father_dob);          
        }

        if(is_null($request->mother_dob)){
            $mother_dob = $request->mother_dob;
        }else{
            $mother_dob = \Carbon\Carbon::parse($request->mother_dob);       
        }

        if(is_null($request->husb_or_wife_dob)){
            $husb_or_wife_dob = $request->husb_or_wife_dob;
        }else{
            $husb_or_wife_dob = \Carbon\Carbon::parse($request->husb_or_wife_dob);          
        }

        if(is_null($request->son_dob)){
            $son_dob = $request->son_dob;
        }else{
            $son_dob = \Carbon\Carbon::parse($request->son_dob);         
        }

        if(is_null($request->daughter_dob)){
            $daughter_dob = $request->daughter_dob;
        }else{
            $daughter_dob = \Carbon\Carbon::parse($request->daughter_dob);           
        }
           

        $user = Auth::user();
        $user_pf = UserPfForm::where('user_id',$user->id)->first(); 
        $user_pf->pf_name = $request->pf_name;
        $user_pf->pf_dob = $pf_dob;
        $user_pf->pf_doj = $pf_doj;
        $user_pf->pf_acc_no = $request->pf_acc;
        $user_pf->pf_bank_name = $request->pf_bank_name;
        $user_pf->pf_bank_ifsc = $request->pf_ifsc;
        $user_pf->pf_phone = $request->pf_phone;
        $user_pf->pf_aadhar = $request->pf_aadhar;
        $user_pf->pf_pan = $request->pf_pan;
        $user_pf->father_name = $request->father_name;
        $user_pf->father_age = $request->father_age;
        $user_pf->father_dob = $father_dob;
        $user_pf->father_aadhar = $request->father_aadhar;
        $user_pf->mother_name = $request->mother_name;
        $user_pf->mother_age = $request->mother_age;
        $user_pf->mother_dob = $mother_dob;
        $user_pf->mother_aadhar = $request->mother_aadhar;
        $user_pf->husb_or_wife_name = $request->husb_or_wife_name;
        $user_pf->husb_or_wife_dob = $husb_or_wife_dob;
        $user_pf->husb_or_wife_aadhar = $request->husb_or_wife_aadhar;
        $user_pf->son_name = $request->son_name;
        $user_pf->son_dob = $son_dob;
        $user_pf->son_aadhar = $request->son_aadhar;
        $user_pf->daughter_name = $request->daughter_name;
        $user_pf->daughter_dob = $daughter_dob;
        $user_pf->daughter_aadhar = $request->daughter_aadhar;
        $user_pf->nominee_name = $request->nominee_name;
        $user_pf->nominee_relt = $request->nominee_relt;
        $user_pf->dispensary = $request->dispensary;
        $user_pf->permt_addr = $request->permt_addr;
        $user_pf->temp_addr = $request->temp_addr;
        $user_pf->save();

        Toastr::success('You Have Successfully Updated Your PF Account Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();

    }

    public function academics_data(Request $request)
    {           
        $user = Auth::user();   
        if($request->ajax())
        {      
           $data = UserAcademics::where('user_id',$user->id)->get();       
           echo json_encode($data);
        }
    }

    public function add_academic_data(Request $request)
    {      
        $user = Auth::user();  
        if($request->ajax())
        {
            $data = array(
                'user_id' => $user->id,
                'course_name'    =>  $request->course_name,
                'from'     =>  $request->from,
                'to'    =>  $request->to,
                'university'     =>  $request->university,
                'location'    =>  $request->location,
                'branch'     =>  $request->branch,
                'percentage'    =>  $request->percentage,
                'class_obt'     =>  $request->class_obt,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            );            
            $id =  UserAcademics::insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Data Inserted</div>';
            }
        } 
    }

    public function update_academic_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name   =>  $request->column_value
            );            
            UserAcademics::where('id', $request->id)->update($data);
            echo '<div class="alert alert-success">Data Updated</div>';
        }
    }

    public function delete_academic_data(Request $request)
    {
        if($request->ajax())
        {
            UserAcademics::where('id', $request->id)->delete();
            echo '<div class="alert alert-success">Data Deleted</div>';
        }
    }


    public function employment_data(Request $request)
    {           
        $user = Auth::user();   
        if($request->ajax())
        {      
           $data = UserEmployment::where('user_id',$user->id)->get();       
           echo json_encode($data);
        }
    }

    public function add_employment_data(Request $request)
    {      
        $user = Auth::user();  
        if($request->ajax())
        {
            $data = array(
                'user_id' => $user->id,
                'duration_from'    =>  $request->duration_from,
                'duration_to'     =>  $request->duration_to,
                'duration_month'    =>  $request->duration_month,
                'organization'     =>  $request->organization,
                'designation'    =>  $request->designation,
                'role'     =>  $request->role,
                'leaving'    =>  $request->leaving,           
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            );            
            $id =  UserEmployment::insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Employment Data Inserted</div>';
            }
        } 
    }

    public function update_employment_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name   =>  $request->column_value
            );            
            UserEmployment::where('id', $request->id)->update($data);
            echo '<div class="alert alert-success">Employment Data Updated</div>';
        }
    }

    public function delete_employment_data(Request $request)
    {
        if($request->ajax())
        {
            UserEmployment::where('id', $request->id)->delete();
            echo '<div class="alert alert-success">Employment Data Deleted</div>';
        }
    }

    public function family_data(Request $request)
    {           
        $user = Auth::user();   
        if($request->ajax())
        {      
           $data = UserFamily::where('user_id',$user->id)->get();       
           echo json_encode($data);
        }
    }

    public function add_family_data(Request $request)
    {      
        $user = Auth::user();  
        if($request->ajax())
        {
            $data = array(
                'user_id' => $user->id,
                'relationship'    =>  $request->relationship,
                'age'     =>  $request->age,
                'dependent'    =>  $request->dependent,                      
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            );            
            $id =  UserFamily::insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Family Data Inserted</div>';
            }
        } 
    }

    public function update_family_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name  => $request->column_value
            );            
            UserFamily::where('id', $request->id)->update($data);
            echo '<div class="alert alert-success">Family Data Updated</div>';
        }
    }

    public function delete_family_data(Request $request)
    {
        if($request->ajax())
        {
            UserFamily::where('id', $request->id)->delete();
            echo '<div class="alert alert-success">Family Data Deleted</div>';
        }
    }

    public function upload_personal_documents(Request $request)
    {
        $user = Auth::user(); 
        $time = date('m/d/Y h:i:s', time());
        $time = strtotime($time);   
        $Document = UserDocument::where('user_id',$user->id)->first();
       
        $request->validate([
                'id_proof' => ['max:10240'],
                'aadhar_card' => ['max:10240'],
                'pan_card' => ['max:10240'],
                'experience_letter' => ['max:10240'],
                'salary_slip' => ['max:10240'],
                'bank_statement' => ['max:10240'] 
        ], [
                'id_proof.max' => 'Maximum file size to upload is 10MB',
                'aadhar_card.max' => 'Maximum file size to upload is 10MB',
                'pan_card.max' => 'Maximum file size to upload is 10MB',
                'experience_letter.max' => 'Maximum file size to upload is 10MB',
                'salary_slip.max' => 'Maximum file size to upload is 10MB',
                'bank_statement.max' => 'Maximum file size to upload is 10MB'        
        ]);       
      
        if($request->hasfile('id_proof'))
         {           
            foreach($request->file('id_proof') as $file)
            {
                $name = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/id_proof/'.$user->id.'/', $name);
                $data[] = 'user/id_proof/'.$user->id.'/'. $name;      
            }

            $Document->id_proof=implode($data,'|');
            $Document->save();
         }       

         if($request->hasfile('aadhar_card'))
         {           
            foreach($request->file('aadhar_card') as $file)
            {
                $aadhar_card = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/aadhar_card/'.$user->id.'/', $aadhar_card);
                $aadhar_carddata[] = 'user/aadhar_card/'.$user->id.'/'. $aadhar_card;      
            }

            $Document->aadhar=implode($aadhar_carddata,'|');
            $Document->save();
         }    

         if($request->hasfile('pan_card'))
         {           
            foreach($request->file('pan_card') as $file)
            {
                $pan_card = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/pan_card/'.$user->id.'/', $pan_card);
                $pan_carddata[] = 'user/pan_card/'.$user->id.'/'. $pan_card;      
            }

            $Document->pan=implode($pan_carddata,'|');
            $Document->save();
         }    


         if($request->hasfile('experience_letter'))
         {           
            foreach($request->file('experience_letter') as $file)
            {
                $experience_letter = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/experience_letter/'.$user->id.'/', $experience_letter);
                $experience_letterdata[] = 'user/experience_letter/'.$user->id.'/'. $experience_letter;      
            }

            $Document->exp_letter=implode($experience_letterdata,'|');
            $Document->save();
         }    

         if($request->hasfile('salary_slip'))
         {           
            foreach($request->file('salary_slip') as $file)
            {
                $salary_slip = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/salary_slip/'.$user->id.'/', $salary_slip);
                $salary_slipdata[] = 'user/salary_slip/'.$user->id.'/'. $salary_slip;      
            }

            $Document->salary_slip=implode($salary_slipdata,'|');
            $Document->save();
         }    

         if($request->hasfile('bank_statement'))
         {           
            foreach($request->file('bank_statement') as $file)
            {
                $bank_statement = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/bank_statement/'.$user->id.'/', $bank_statement);
                $bank_statementdata[] = 'user/bank_statement/'.$user->id.'/'. $bank_statement;      
            }

            $Document->bank_stat=implode($bank_statementdata,'|');
            $Document->save();
         }         
        
        Toastr::success('You Have Successfully Updated Your Personal Documents!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();

    }

    public function upload_academic_documents(Request $request)
    {
        $user = Auth::user(); 
        $time = date('m/d/Y h:i:s', time());
        $time = strtotime($time);   
        $Document = UserDocument::where('user_id',$user->id)->first();
       
        $request->validate([
                'sslc_cerf' => ['max:10240'],
                'puc_cerf' => ['max:10240'],
                'graduate_cerf' => ['max:10240'],
                'pg_cerf' => ['max:10240'],
                'other_cerf' => ['max:10240'],
                'cerf_course' => ['max:10240'] 
        ], [
                'sslc_cerf.max' => 'Maximum file size to upload is 10MB',
                'puc_cerf.max' => 'Maximum file size to upload is 10MB',
                'graduate_cerf.max' => 'Maximum file size to upload is 10MB',
                'pg_cerf.max' => 'Maximum file size to upload is 10MB',
                'other_cerf.max' => 'Maximum file size to upload is 10MB',
                'cerf_course.max' => 'Maximum file size to upload is 10MB'        
        ]);       
      
        if($request->hasfile('sslc_cerf'))
         {           
            foreach($request->file('sslc_cerf') as $file)
            {
                $name = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/sslc/'.$user->id.'/', $name);
                $data[] = 'user/sslc/'.$user->id.'/'.$name;      
            }

            $Document->sslc=implode($data,'|');
            $Document->save();
         }       

         if($request->hasfile('puc_cerf'))
         {           
            foreach($request->file('puc_cerf') as $file)
            {
                $puc_cerf = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/puc/'.$user->id.'/', $puc_cerf);
                $puc_cerfdata[] = 'user/puc/'.$user->id.'/'.$puc_cerf;      
            }

            $Document->puc=implode($puc_cerfdata,'|');
            $Document->save();
         }    

         if($request->hasfile('graduate_cerf'))
         {           
            foreach($request->file('graduate_cerf') as $file)
            {
                $graduate_cerf = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/graduate/'.$user->id.'/', $graduate_cerf);
                $graduate_cerfdata[] = 'user/graduate/'.$user->id.'/'.$graduate_cerf;      
            }

            $Document->graduate=implode($graduate_cerfdata,'|');
            $Document->save();
         }    


         if($request->hasfile('pg_cerf'))
         {           
            foreach($request->file('pg_cerf') as $file)
            {
                $pg_cerf = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/post_graduate/'.$user->id.'/', $pg_cerf);
                $post_graduatedata[] = 'user/post_graduate/'.$user->id.'/'.$pg_cerf;      
            }

            $Document->post_graduate=implode($post_graduatedata,'|');
            $Document->save();
         }    

         if($request->hasfile('other_cerf'))
         {           
            foreach($request->file('other_cerf') as $file)
            {
                $other_cerf = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/other_qualification/'.$user->id.'/', $other_cerf);
                $other_cerfdata[] = 'user/other_qualification/'.$user->id.'/'. $other_cerf;      
            }

            $Document->other_qualification=implode($other_cerfdata,'|');
            $Document->save();
         }    

         if($request->hasfile('cerf_course'))
         {           
            foreach($request->file('cerf_course') as $file)
            {
                $cerf_course = rand().$time.'.'.$file->extension();
                $file->move(public_path().'/user/certificate_course/'.$user->id.'/', $cerf_course);
                $cerf_coursedata[] = 'user/certificate_course/'.$user->id.'/'. $cerf_course;      
            }

            $Document->certificate_course=implode($cerf_coursedata,'|');
            $Document->save();
         }         
        
        Toastr::success('You Have Successfully Updated Your Academics Documents!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function career_objective(Request $request)
    {
        $user = Auth::user(); 
        $other_details = UserOtherDetails::where('user_id',$user->id)->first();
        $other_details->career_objective = $request->objective;
        $other_details->growth_plan = $request->growth_plan;
        $other_details->expectation = $request->expectation;
        $other_details->strength = $request->strength;
        $other_details->improvement = $request->improvement;
        $other_details->future_study = $request->future_study;       
        $other_details->save();

        Toastr::success('You Have Successfully Updated Your Career Objectives Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function user_other_activity(Request $request)
    {
        $user = Auth::user(); 
        $other_details = UserOtherDetails::where('user_id',$user->id)->first();
        $other_details->sports = $request->sports;
        $other_details->social_activity = $request->social_activity;
        $other_details->hobby = $request->hobby;
        $other_details->awards = $request->awards;
        $other_details->disability = $request->disability;
        $other_details->contact1_name = $request->contact1_name;
        $other_details->contact1_phone = $request->contact1_phone;
        $other_details->contact1_address = $request->contact1_address;    
        $other_details->contact2_name = $request->contact2_name;
        $other_details->contact2_phone = $request->contact2_phone;
        $other_details->contact2_address = $request->contact2_address;    
        $other_details->save();

        Toastr::success('You Have Successfully Updated Your Other Activities Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function user_references(Request $request)
    {
         $request->validate([
                'ref1_name' => ['required'],
                'ref1_company' => ['required'],
                'ref1_phone' => ['required'],
                'ref1_email' => ['required'],
                'ref2_name' => ['required'],    
                'ref2_company' => ['required'],
                'ref2_phone' => ['required'],
                'ref2_email' => ['required'],
        ], [
                'ref1_name.required' => 'First Reference Name Is Required.',
                'ref1_company.required' => 'First Reference Company Name Is Required',
                'ref1_phone.required' => 'First Reference Contact Number Is Required',
                'ref1_email.required' => 'First Reference Email Id Is Required',
                'ref2_name.required' => 'Second Reference Name Is Required',               
                'ref2_company.required' => 'Second Reference Company Name Is Required',
                'ref2_phone.required' => 'Second Reference Contact Number Is Required',
                'ref2_email.required' => 'Second Reference Email Id Is Required',     
        ]);

        $user = Auth::user(); 
        $other_details = UserOtherDetails::where('user_id',$user->id)->first();
        $other_details->reference1_name = $request->ref1_name;
        $other_details->reference1_company = $request->ref1_company;
        $other_details->reference1_phone = $request->ref1_phone;
        $other_details->reference1_email = $request->ref1_email;
        $other_details->reference2_name = $request->ref2_name;
        $other_details->reference2_company = $request->ref2_company;
        $other_details->reference2_phone = $request->ref2_phone;
        $other_details->reference2_email = $request->ref2_email;    
        $other_details->save();

        Toastr::success('You Have Successfully Updated Your Reference Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
    
    public function official_document()
    {
        $user = Auth::user(); 
        $official_document = UserOfficialDocument::where('user_id',$user->id)->first();
        return view('user.officialdocument.document',compact('user','official_document'));
    }


    public function document_download(Request $request)
    {   
        $UserID = Crypt::decrypt($request->EncryptedId);
        $Document = $request->EncryptedProof;   

        $Documents = UserDocument::where('user_id',$UserID);
        
        $Official_Documents = UserOfficialDocument::where('user_id',$UserID);

        $zip = new ZipArchive;

        switch ($Document) {
            case 'Id':
                    $fileName = rand().'IdDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Id_Proofs = $Documents->select('id_proof')->first();
                    $Id_Proof = explode('|',$Id_Proofs->id_proof);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Id_Proof as $Proof){                      
                     
                        $relativeNameInZipFile = basename($Proof);
                        $zip->addFile(public_path($Proof), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));                         
            break;
            case 'Aadhar':
                    $fileName = rand().'AadharDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Aadhars = $Documents->select('aadhar')->first();
                    $Aadhar = explode('|',$Aadhars->aadhar);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Aadhar as $aadhar){                      
                     
                        $relativeNameInZipFile = basename($aadhar);
                        $zip->addFile(public_path($aadhar), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Pan':
                    $fileName = rand().'PanDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Pans = $Documents->select('pan')->first();
                    $Pan = explode('|',$Pans->pan);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Pan as $pan){                      
                     
                        $relativeNameInZipFile = basename($pan);
                        $zip->addFile(public_path($pan), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Exp':
                    $fileName = rand().'ExpDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Exp_Letters = $Documents->select('exp_letter')->first();
                    $Exp_Letter = explode('|',$Exp_Letters->exp_letter);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Exp_Letter as $Letter){                      
                     
                        $relativeNameInZipFile = basename($Letter);
                        $zip->addFile(public_path($Letter), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));                   
                   
            break;
            case 'Salary':
                    $fileName = rand().'SalaryDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Salary_slips = $Documents->select('salary_slip')->first();
                    $Salary_slip = explode('|',$Salary_slips->salary_slip);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Salary_slip as $Slip){                      
                     
                        $relativeNameInZipFile = basename($Slip);
                        $zip->addFile(public_path($Slip), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));      

            break;
            case 'Bank':
                    $fileName = rand().'BankDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Bank_stats = $Documents->select('bank_stat')->first();
                    $Bank_stat = explode('|',$Bank_stats->bank_stat);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Bank_stat as $Bank){                      
                     
                        $relativeNameInZipFile = basename($Bank);
                        $zip->addFile(public_path($Bank), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Sslc':
                    $fileName = rand().'SslcDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Sslcs = $Documents->select('sslc')->first();
                    $Sslc = explode('|',$Sslcs->sslc);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Sslc as $sslc){                      
                     
                        $relativeNameInZipFile = basename($sslc);
                        $zip->addFile(public_path($sslc), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Puc':
                    $fileName = rand().'PucDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Pucs = $Documents->select('puc')->first();
                    $Puc = explode('|',$Pucs->puc);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Puc as $puc){                      
                     
                        $relativeNameInZipFile = basename($puc);
                        $zip->addFile(public_path($puc), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Grad':
                    $fileName = rand().'GradDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Graduates = $Documents->select('graduate')->first();
                    $Graduate = explode('|',$Graduates->graduate);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Graduate as $graduate){                      
                     
                        $relativeNameInZipFile = basename($graduate);
                        $zip->addFile(public_path($graduate), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Pg':
                    $fileName = rand().'PGDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Post_Graduates = $Documents->select('post_graduate')->first();
                    $Post_Graduate = explode('|',$Post_Graduates->post_graduate);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Post_Graduate as $Pg){                      
                     
                        $relativeNameInZipFile = basename($Pg);
                        $zip->addFile(public_path($Pg), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Other':
                    $fileName = rand().'OtherDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Other_Qualifications = $Documents->select('other_qualification')->first();
                    $Other_Qualification = explode('|',$Other_Qualifications->other_qualification);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Other_Qualification as $OQ){                      
                     
                        $relativeNameInZipFile = basename($OQ);
                        $zip->addFile(public_path($OQ), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;
            case 'Course':
                    $fileName = rand().'CourseDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Certificate_Courses = $Documents->select('certificate_course')->first();
                    $Certificate_Course = explode('|',$Certificate_Courses->certificate_course);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Certificate_Course as $Course){                      
                     
                        $relativeNameInZipFile = basename($Course);
                        $zip->addFile(public_path($Course), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break;  
            
            case 'Kra':
                    $fileName = rand().'KraDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $Kras = $Official_Documents->select('kra')->first();
                    $Kra = explode('|',$Kras->kra);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($Kra as $kra){                      
                     
                        $relativeNameInZipFile = basename($kra);
                        $zip->addFile(public_path($kra), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break; 
            case 'commitment':
                    $fileName = rand().'commitment.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $commitments = $Official_Documents->select('commitment')->first();
                    $commitment = explode('|',$commitments->commitment);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($commitment as $offerletter){                      
                     
                        $relativeNameInZipFile = basename($offerletter);
                        $zip->addFile(public_path($offerletter), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break; 
            case 'offer_letter':
                    $fileName = rand().'OfferLetterDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $offer_letters = $Official_Documents->select('offer_letter')->first();
                    $offerletters = explode('|',$offer_letters->offer_letter);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($offerletters as $offerletter){                      
                     
                        $relativeNameInZipFile = basename($offerletter);
                        $zip->addFile(public_path($offerletter), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break; 
            case 'appraisal':
                    $fileName = rand().'appraisalDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $appraisals = $Official_Documents->select('yearly_appraisal')->first();
                    $appraisal = explode('|',$appraisals->yearly_appraisal);  

                   if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                    {
                    foreach($appraisal as $Appraisal){                      
                     
                        $relativeNameInZipFile = basename($Appraisal);
                        $zip->addFile(public_path($Appraisal), $relativeNameInZipFile);
                    }                   
                     $zip->close();
                    }                
    
                    return response()->download(public_path($fileName));     
            break; 
           
        }

    }
}
