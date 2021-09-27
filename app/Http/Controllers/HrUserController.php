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
use App\ResignedUser;
use App\Branch;
use App\Department;

class HrUserController extends Controller
{
    public function useractivation()
    {   
    	$user = Auth::user();
    	if($user->user_position == 5)
    	{    		
    	if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
           {              
               $Users = User::whereIn('branch',[1,4,6,7])->whereNotNull('confirmation_code')->get();
           }
           elseif($user->branch == 2  || $user->branch == 3 || $user->branch == 5)
           {
               $Users = User::whereIn('branch',[2,3,5])->whereNotNull('confirmation_code')->get();
           }  

    	}else{
    		Toastr::error('Accessible Only For HR !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		 	return back();
    	}
    	$Positions = UserPosition::all();         	
    	return view('hr.employees.useractivation',compact('Users','Positions'));
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
          
        $user = Auth::user();
    	if($user->user_position == 5)
    	{    		
    		if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
    		{    			
				$Users = User::whereIn('branch',[1,4,6,7])->where('email_verify','=',1)->orderBy('first_name','ASC')->paginate(250);
    		}
    		elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5)
    		{
				$Users = User::whereIn('branch',[2,3,5])->where('email_verify','=',1)->orderBy('first_name','ASC')->paginate(250);
    		}
    	
    	}else{
    		Toastr::error('Accessible Only For HR !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		 	return back();
    	}
    
        $Positions = UserPosition::all(); 
        $Departments = Department::all(); 
        return view('hr.employees.employeelist',compact('Users','Positions','Departments'));
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
        /*$UserID = Crypt::decrypt($request->id);

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
        $user = Auth::user();
    	if($user->user_position == 5)
    	{    		
    	     if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
                {    
                $Users = User::whereIn('branch',[1,4,6,7])->where('email_verify','=',1)->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
                }
                elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5)
                {
            $Users = User::whereIn('branch',[2,3,5])->where('email_verify','=',1)->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
                }

    	}else{
    		Toastr::error('Accessible Only For HR !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
		 	return back();
    	}
               
        return view('hr.employees.newlyjoineduser',compact('Users'));
    }

    public function resignedemployeelist()
    {
        $user = Auth::user();
        if($user->user_position == 5)
        {           
            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7)
            {    
                $Emps = User::whereIn('branch',[1,4,6,7])->where('email_verify','=',1)->where('status','=','active')->get();          
                $Users = ResignedUser::whereIn('branch',[1,4,6,7])->get();
                $Branches = Branch::whereIn('id',[1,4,6,7])->get();
            }
            elseif($user->branch == 2 || $user->branch == 3 || $user->branch == 5)
            {
                $Emps = User::whereIn('branch',[2,3,5])->where('email_verify','=',1)->where('status','=','active')->get();
                $Users = ResignedUser::whereIn('branch',[2,3,5])->get();
                $Branches = Branch::whereIn('id',[2,3,5])->get();
            }

        }else{
            Toastr::error('Accessible Only For HR !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
      
        return view('hr.employees.resigneduser',compact('Users','Emps','Branches'));
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
