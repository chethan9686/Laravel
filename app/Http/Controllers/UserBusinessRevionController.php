<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Response;
use ZipArchive;
use Toastr;
use App\User;
use App\UserDetails;
use App\Branch;
use App\BusinessClients;
use App\BusinessSignup;
use App\BusinessSignupSplit;
use App\BillingInformation;
use App\UserBusinessRevion;
use App\BsNumber;
use App\Mail\UserAdditionalSignup;
use App\Mail\UserRevised;
use App\Admin;

class UserBusinessRevionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function businessrevision(Request $request){
    	$User = Auth::user();
    	$query = $request->get('query');
    	$bsnodatalist = BillingInformation::select('bs_number')->distinct('bs_number')->where('bs_number', 'LIKE', '%'.$query.'%')->where('user_id',$User->id)->orderBy('bs_number', 'desc')->get();
        $BusinessRevionData = UserBusinessRevion::where('user_id',$User->id)->get();
       /*zz*/
        return view('user.business.signuprectification',compact('bsnodatalist','BusinessRevionData'));
    }

    public function businessrevisioncreate(Request $request){
    	$User = Auth::user();
		$user_id = $User->id;
		
    	$User_details = UserDetails::where('user_id', $User->id)->first();
        $signupinfo = BillingInformation::where('bs_number',$request->bs_number)->first();
        
    	$Businessrevision = new UserBusinessRevion();
        $Businessrevision->user_id = $user_id; 
        $Businessrevision->branch = $User->branch;   
        $Businessrevision->tl = $User_details->tl;
        $Businessrevision->rm = $User_details->rm;
        $Businessrevision->rh = $User_details->rh;
        $Businessrevision->bs_number = $request->bs_number;
        $Businessrevision->signup_id = $signupinfo->signup_id;
        $Businessrevision->biilling_id = $signupinfo->id;
        $Businessrevision->revision = $request->revision;
        $Businessrevision->invoice_no = $request->invoice_no;
        $Businessrevision->revision_reason = $request->revision_reason;
        $Businessrevision->status = 1;
        $Businessrevision->comment ="Pending";
       
        $Businessrevision->save();

        $Mail = new SendMail();
        $cc = $Mail->getusers($User,$User_details);

        $send_to = User::find($User_details->tl);

       // Mail::to($send_to)->send(new UserRevised($User,$Businessrevision,$cc,$User_details));

        return back();
    }
}
