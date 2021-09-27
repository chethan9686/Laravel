<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessSignupDetails;
use ZipArchive;
use Response;
use Toastr;
use App\User;
use App\UserDetails;
use App\Branch;
use App\BusinessClients;
use App\BusinessSignup;
use App\BusinessSignupSplit;
use App\BillingInformation;
use App\BsNumber;
use Log;
use App\Mail\UserSignup;
use App\Mail\UserApprovalSignup;
use App\Mail\UserReworkSignup;
use App\Mail\UserApprovalSignup;
use App\Mail\UserRevisedApproval;
use App\Mail\UserRevisedReject;
use App\Admin;
use App\UserBusinessRevion;

class AdminBusinessRevionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function viewbusinessrevionlist()
    {
        $User = Auth::user();
    	$Bang_Signupsrevision = UserBusinessRevion::whereIn('branch',[1,6,7])->orderBy('created_at', 'desc')->get();
    	$Mum_Signupsrevision = UserBusinessRevion::whereIn('branch',[2,5])->orderBy('created_at', 'desc')->get();
    	$Del_Signupsrevision = UserBusinessRevion::whereIn('branch',[3])->orderBy('created_at', 'desc')->get();
    	$Hyd_Signupsrevision = UserBusinessRevion::whereIn('branch',[4])->orderBy('created_at', 'desc')->get();     	
    	return view('admin.business.business_revisionlist',compact('User','Bang_Signupsrevision','Mum_Signupsrevision','Del_Signupsrevision','Hyd_Signupsrevision'));
    }

    public function businessrevionapproval(Request $request){

    	$Signuprevision = UserBusinessRevion::find($request->revision_id);

    	$Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comment! Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }

        $Signuprevision->comment = $Comment;
        $Signuprevision->status = "2";
        $Signuprevision->save(); 

        Toastr::success('You Have Successfully Approved Business Revision!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function businessrevionreject(Request $request){
    	$Signuprevisionreject = UserBusinessRevion::find($request->revision_id);

    	$Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        $Signuprevisionreject->comment = $Comment;
        $Signuprevisionreject->status = "0";
        $Signuprevisionreject->save(); 
        
        Toastr::success('You Have Successfully Approved Business Revision!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
}
