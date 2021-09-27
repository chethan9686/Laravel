<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterVerification;
use Toastr;
use \Carbon;
use App\User;
use App\UserDetails;
use App\UserPosition;
use App\Branch;
use App\ResignedUser;
use App\Department;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function useractivation()
    {
    	$Bang_Users = User::whereIn('branch',[1,6,7])->whereNotNull('confirmation_code')->get();
    	$Mum_Users = User::whereIn('branch',[2,5])->whereNotNull('confirmation_code')->get();
    	$Del_Users = User::whereIn('branch',[3])->whereNotNull('confirmation_code')->get();
    	$Hyd_Users = User::whereIn('branch',[4])->whereNotNull('confirmation_code')->get(); 
    	$Positions = UserPosition::all();       	
    	return view('admin.employees.useractivation',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users','Positions'));
    }

    public function sendEmpActivation(Request $request)
    {
    	$Emp_id = $request->emp_id;
    	$gender = "gender$Emp_id";    	
    	$userposition = $request->$gender;

    	$user = User::find($Emp_id);
    	$branch = Branch::find($user->branch);
    	$position = UserPosition::find($userposition);
 
    	if(is_null($userposition)){
 			Toastr::error(' Please Select User Position and Try Again ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
    	}
    	else
    	{    	
			$user->user_position = $userposition;
			$user->save();
		 	Mail::to($user)->send(new RegisterVerification($user->confirmation_code,$user->first_name,$user->last_name,$user->phone,$branch->name,$position->position_name));

		 	Toastr::success('You Have Successfully Sent Verification Link To Employee!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		 	return back();
    	}

    }

    public function employeelist(){
        //Employee List Count
        $bangalorelist = User::where('branch','=',1)->where('status','=','active')->count();
        $hydrabadlist = User::where('branch','=',4)->where('status','=','active')->count();
        $kolkata = User::where('branch','=',6)->where('status','=','active')->count();
        $BangHyd = $bangalorelist + $hydrabadlist + $kolkata;
        $mumbai = User::where('branch','=',2)->where('status','=','active')->count();
        $pune = User::where('branch','=',5)->where('status','=','active')->count();
        $mumpune = $mumbai + $pune;
        $delhilist = User::where('branch','=',3)->where('status','=','active')->count();
        $totalemployees =  $BangHyd + $mumpune + $delhilist;
        
        $Bang_Users = User::whereIn('branch',[1,6,7])->where('email_verify','=',1)->where('status','=','active')->orderBy('first_name','ASC')->paginate(250);
        $Mum_Users = User::whereIn('branch',[2,5])->where('email_verify',1)->where('status','=','active')->orderBy('first_name','ASC')->paginate(250);
        $Del_Users = User::whereIn('branch',[3])->where('email_verify',1)->where('status','=','active')->orderBy('first_name','ASC')->paginate(250);
        $Hyd_Users = User::whereIn('branch',[4])->where('email_verify',1)->where('status','=','active')->orderBy('first_name','ASC')->paginate(250); 
        $Positions = UserPosition::all(); 
        $Departments = Department::all(); 
        $User = Auth::user();
        return view('admin.employees.employeelist',compact('BangHyd','bangalorelist','hydrabadlist','mumpune','delhilist','totalemployees','Bang_Users','Mum_Users','Del_Users','Hyd_Users','Positions','Departments','User'));
    }

    public function blockUser(Request $request)
    {
        $UserID = Crypt::decrypt($request->id);

        $user = User::find($UserID);
        $user->status = "inactive";
        $user->block_status = 1;
        $user->save();
        
        return response()->json("Success");
    }

    public function confirmUser(Request $request)
    {
       /* $UserID = Crypt::decrypt($request->id);

        $user = User::find($UserID);        
        $user->confirm_status = 1;
        $user->save();
        
        return response()->json("Success");*/
        
         $confirmedate = $request->confirme_date;
        $user = User::find($request->user_id);        
        $user->confirm_status = 1;
        $user->confirme_date = $confirmedate;
      
        $user->save();
        return back();
    }

    public function newemployeelist()
    {
        $Bang_Users = User::whereIn('branch',[1,6,7])->whereNull('confirmation_code')->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
        $Mum_Users = User::whereIn('branch',[2,5])->whereNull('confirmation_code')->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
        $Del_Users = User::whereIn('branch',[3])->whereNull('confirmation_code')->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
        $Hyd_Users = User::whereIn('branch',[4])->whereNull('confirmation_code')->whereMonth('created_at', \Carbon\Carbon::now()->month)->get(); 
               
        return view('admin.employees.newlyjoineduser',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users'));
    }


    public function resignedemployeelist()
    {
        $Emps = User::where('email_verify','=',1)->where('status','=','active')->get(); 
        $Branches = Branch::all();

        $Bang_Users = ResignedUser::whereIn('branch',[1,6,7])->get();
        $Mum_Users = ResignedUser::whereIn('branch',[2,5])->get();
        $Del_Users = ResignedUser::whereIn('branch',[3])->get();
        $Hyd_Users = ResignedUser::whereIn('branch',[4])->get(); 

         return view('admin.employees.resigneduser',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users','Emps','Branches'));
    }

    public function addresignedemployee(Request $request)
    {
        $request->validate([
                'emp_name' => ['required'],
                'location' => ['required'],  
                'date' => ['required'],  
                'designation' => ['required'],
                'reason' => ['required'],  
                'hired' => ['required'],   
        ], [
                'emp_name.required' => 'Please Select The Employee Name',
                'location.required' => 'Please Select The Branch',     
                'date.required' => 'Please Select Employee Resigned Date',   
                'designation.required' => 'Please Enter Designation Of Employee',
                'reason.required' =>'Please Enter Reason For Living',  
                'hired.required' => 'Please Select Employee Can Be Rehired or Not.',            
        ]); 

        $details = UserDetails::where('user_id' ,'=',$request->emp_name)->first();
        ResignedUser::create([
            'user_id' => $request->emp_name,
            'branch' => $request->location,
            'tl' => $details->tl,
            'rm' => $details->rm,
            'rh' => $details->rh,
            'resigned_date' => \Carbon\Carbon::parse($request->date)->format('d-m-Y'),
            'designation' => $request->designation,
            'reason_for_leaving' => $request->reason,
            'rehired' => $request->hired
        ]);

        Toastr::success('You Have Successfully Inserted Resigned Employee Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
}
