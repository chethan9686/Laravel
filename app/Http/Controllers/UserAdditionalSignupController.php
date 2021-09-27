<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;

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
use App\BsNumber;
use App\Mail\UserAdditionalSignup;
use App\Admin;
use App\UserBusinessRevion;

class UserAdditionalSignupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function additional_signup()
    {
    	return view('user.business.additional_signup');
    }

    function bsnumberlist(Request $request)
    {
        $User = Auth::user();
        
        if($request->get('query'))
        {
            $query = $request->get('query');        

            $data = BsNumber::select('bs_number')->distinct('bs_number')->where('bs_number', 'LIKE', '%'.$query.'%')->where('user_id',$User->id)->orderBy('bs_number', 'desc')->get();             

            $collection = collect($data);

            $unique_data = $collection->unique()->values()->all();

            if(count($unique_data) > 0)
            {
                $output = '<ul class="dropdown-menu bsnumberList" style="display:block;position:relative;width: 100%;">';

                foreach($unique_data as $row)
                {
                  $output .= '<li><a>'.$row->bs_number.'</a></li>'; 
                }   
    
                $output .='</ul>';
    
                echo $output;
            }else{
                $msg ="No search result found";
                
                $output = '<ul class="dropdown-menu bsnumberList" style="display:block;position:relative;width: 100%;pointer-events: none;">';
                $output .= '<li><a>'.$msg.'</a></li>';

                $output .='</ul>';
                
                echo $output;
            }       
        }
    }

    public function fetchbsdata(Request $request)
    {
        $bs_number = $request->bs_number;
        
        $bsdata = BillingInformation::where('bs_number',$bs_number)->first();
       
        $signup = BusinessSignup::find($bsdata->signup_id); 

        $data = array(
            "signup_id" =>  $signup->id,
            "company_name" =>  $signup->company_name,
            "client_name" => $signup->client_name,    
            "client_email" => $signup->client_email,
            "client_mobile" => $signup->client_mobile,
            "event_name" => $signup->event_name,
            "event_city" => $signup->event_city,
        );     
        echo json_encode($data);  
    }

    public function submitadditionalsignup(Request $request)
    {
    	if($request->purchaseorder == 'No' && $request->clientmail == 'No')
        {
            Toastr::error('Please Select Yes For PurchaseOrder Or Client Mail Approval and Upload Particular File!.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }
        
        if(is_null($request->estimate_amount) && is_null($request->budget_amount) && is_null($request->actual_estimate_amount) && is_null($request->actual_budget_amount) && is_null($request->payment_estimate_amount) && is_null($request->payment_budget_amount))
        {
            Toastr::error('Please Enter Any Budget , Estimate Amount and Profit Percentage Details!.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }        
        elseif ($request->purchaseorder == 'Yes' || $request->clientmail == 'Yes') 
        {        
           if($request->purchaseorder == 'Yes' && $request->clientmail == 'Yes')
           {
                $request->validate([
                    'po_pic' => 'required|max:10240',
                    'approval_mail' => 'required|max:10240',                   
                ], [
                    'po_pic.max' => 'Maximum file size to upload is 10MB',
                    'approval_mail.max' => 'Maximum file size to upload is 10MB',      
                    'po_pic.required' => 'Please Upload The File',
                    'approval_mail.required' => 'Please Upload The File',                      
                ]); 
           }
           elseif($request->purchaseorder == 'Yes')
           {
                $request->validate([
                    'po_pic' => 'required|max:10240',                                          
                ], [
                    'po_pic.max' => 'Maximum file size to upload is 10MB', 
                    'po_pic.required' => 'Please Upload The File',                                                 
                ]); 
           }
           elseif ($request->clientmail == 'Yes') 
           {
                $request->validate([                    
                    'approval_mail' => 'required|max:10240',                   
                ], [                       
                    'approval_mail.max' => 'Maximum file size to upload is 10MB',     
                    'approval_mail.required' => 'Please Upload The File',                         
                ]); 
           }             
        }

        $request->validate([  
            'bs_number' => ['required'],  
            'budget_sheet' => 'required|mimes:xls,xlsx|max:10240',
            'advancepayment' => ['required'],
            'dateofadvance' =>['required_if:advancepayment,yes'],
            'advance_amount' =>['required_if:advancepayment,yes'],
            'purchaseorder' => ['required'],
            'clientmail' => ['required'],                   
        ], [            
            'bs_number.required' => 'Please Search and Select BS Number',
            'budget_sheet.max' => 'Maximum file size to upload is 10MB', 
            'budget_sheet.required' => 'Please Upload The Excel Budget Sheet',
            'advancepayment.required' => 'Please Select Advance Payment Status',
            'dateofadvance.required_if' =>'Please Select Advance Payment Date',
            'advance_amount.required_if' => 'Please Enter Advance Payment Amount',
            'purchaseorder.required' => 'Please Select Status For Purchase Order',
            'clientmail.required' => 'Please Select Status For Client Approval Mail',                 
        ]); 

        $signup = BusinessSignup::find($request->signup_id); 
        $signup->child = $signup->child + 1;
        $signup->save();

        $aditional = BusinessSignup::create([
            'user_id' => $signup->user_id,  
            'parent_id' => $signup->id,
            'branch' => $signup->branch,                                
            'tl' => $signup->tl,
            'rm' => $signup->rm,
            'rh' => $signup->rh,
            'company_status' => $signup->company_status,
            'company_name' => $signup->company_name,
            'client_name' => $signup->client_name,
            'client_email' => $signup->client_email,
            'client_mobile' => $signup->client_mobile,
            'event_name' => $signup->event_name,
            'event_city' => $signup->event_city,
            'event_startdate' => $signup->event_startdate,
            'event_enddate'=> $signup->event_enddate,
            'event_billeddate' => $signup->event_billeddate,
            'service' => $request->service,
            'budget_amount' => $request->budget_amount,
            'estimate_amount' => $request->estimate_amount,
            'profit_amount' => $request->profit_amount,
            'profit_percentage' => $request->profit_percentage,
            'actual_budget_amount' => $request->actual_budget_amount,
            'actual_estimate_amount' => $request->actual_estimate_amount,
            'actual_profit_amount' => $request->actual_profit_amount,
            'actual_profit_percentage' => $request->actual_profit_percentage,
            'payment_budget_amount' => $request->payment_budget_amount,
            'payment_estimate_amount' => $request->payment_estimate_amount,
            'payment_profit_amount' => $request->payment_profit_amount,
            'payment_profit_percentage' => $request->payment_profit_percentage,
            'advance_payment_status' => $request->advancepayment,
            'advance_payment_date' => $request->dateofadvance,
            'advance_payment_amount' => $request->advance_amount,
            'purchase_status' => $request->purchaseorder,     
            'client_approval_status' => $request->clientmail,
            'payment_contract' => $signup->payment_contract,
            'budget_made_by' => $signup->budget_made_by,
            'event_signed_up' => $signup->event_signed_up,
            'production_employee' => $signup->production_employee, 
            'creative_employee' => $signup->creative_employee, 
            'outside_employee' => $signup->outside_employee,
            'status' => "Pending",
            'comment' => "Pending",
            'level' => 1,
        ]);

        $Business = BusinessSignup::find($aditional->id);

        $Sheet = $request->budget_sheet;
        if(!is_null($Sheet)){         
            $FileName = $Sheet->hashName();
            Storage::disk('Uploads')->putFile('user/business/budget_sheet/'.$aditional->id.'/', ($Sheet));
            $Business->budget_sheet = 'user/business/budget_sheet/'.$aditional->id.'/'. $FileName;            
        }

        $Po_pic = $request->po_pic;
        if(!is_null($Po_pic)){ 
            foreach($Po_pic as $file)
            { 
                $FileName = $file->hashName();
                Storage::disk('Uploads')->putFile('user/business/po/'.$aditional->id.'/', ($file));
                $purchase_file[] = 'user/business/po/'.$aditional->id.'/'. $FileName;     
            }
            $Business->purchase_file=implode('|',$purchase_file);           
        }

        $Approval = $request->approval_mail;
        if(!is_null($Approval)){   
            $File = $Approval->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$aditional->id.'/', ($Approval));
            $Business->client_approval_file = 'user/business/clientapproval/'.$aditional->id.'/'. $File;        
        }

        $Business->save();
        
        $split = BusinessSignupSplit::where('signup_id',$signup->id)->get();
        
        foreach ($split as $key) {                
            BusinessSignupSplit::create([
                'signup_id' => $aditional->id,
                'employee_id' => $key->employee_id,
                'percentage' => $key->percentage,
            ]);               
        }        

        //////////////////////////Mail/////////////////////////
        $Signup_User = User::find($signup->user_id);
        $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();

        $Admin = User::first();
        $User_tl = User::find($SignupUser_details->tl);
        $User_rm = User::find($SignupUser_details->rm);
        $User_rh = User::find($SignupUser_details->rh);
        
        $tl = $User_tl->email;
        $rm = $User_rm->email; 
        $rh = $User_rh->email;      
        $kl = "fin-eve2@wingsevents.com";   
        $Admin2 = Admin::skip(1)->take(1)->first();

        $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 

        Mail::to($Signup_User)->send(new UserAdditionalSignup($Signup_User,$cc,$Business));
        ////////////////////////////End Mail//////////////////////

        Toastr::success('You Have Successfully Submitted Additional Business Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
    
    public function editadditionalsignup($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $AdditionalSignup = BusinessSignup::find($ID);
        $User = Auth::user();   
        $BSNumber = BsNumber::where('signup_id',$AdditionalSignup->parent_id)->first();
        $Revision = 0;
        return view('user.business.edit_additional_signup',compact('AdditionalSignup','User','BSNumber','Revision'));
    }

    public function editadditionalrevisionsignup($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $AdditionalSignup = BusinessSignup::find($ID);
        $User = Auth::user();   
        $BSNumber = BsNumber::where('signup_id',$AdditionalSignup->parent_id)->first();
        $Revision = 1;
        return view('user.business.edit_additional_signup',compact('AdditionalSignup','User','BSNumber','Revision'));
    }

    public function submiteditadditionalsignup(Request $request)
    {
        if($request->purchaseorder == 'No' && $request->clientmail == 'No')
        {
            Toastr::error('Please Select Yes For PurchaseOrder Or Client Mail Approval and Upload Particular File!.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }
        elseif ($request->purchaseorder == 'Yes' || $request->clientmail == 'Yes') 
        {        
           if($request->purchaseorder == 'Yes' && $request->clientmail == 'Yes')
           {
                $request->validate([
                    'po_pic' => 'max:10240',
                    'approval_mail' => 'max:10240',                   
                ], [
                    'po_pic.max' => 'Maximum file size to upload is 10MB',
                    'approval_mail.max' => 'Maximum file size to upload is 10MB',                             
                ]); 
           }
           elseif($request->purchaseorder == 'Yes')
           {
                $request->validate([
                    'po_pic' => 'max:10240',                                          
                ], [
                    'po_pic.max' => 'Maximum file size to upload is 10MB',                              
                ]); 
           }
           elseif ($request->clientmail == 'Yes') 
           {
                $request->validate([                    
                    'approval_mail' => 'max:10240',                   
                ], [                       
                    'approval_mail.max' => 'Maximum file size to upload is 10MB',     
                ]); 
           }             
        }


        $request->validate([  
            'bs_number' => ['required'],  
            'budget_sheet' => 'mimes:xls,xlsx|max:10240',
            'advancepayment' => ['required'],
            'dateofadvance' =>['required_if:advancepayment,yes'],
            'advance_amount' =>['required_if:advancepayment,yes'],
            'purchaseorder' => ['required'],
            'clientmail' => ['required'],                   
        ], [            
            'bs_number.required' => 'Please Search and Select BS Number',
            'budget_sheet.max' => 'Maximum file size to upload is 10MB',
            'advancepayment.required' => 'Please Select Advance Payment Status',
            'dateofadvance.required_if' =>'Please Select Advance Payment Date',
            'advance_amount.required_if' => 'Please Enter Advance Payment Amount',
            'purchaseorder.required' => 'Please Select Status For Purchase Order',
            'clientmail.required' => 'Please Select Status For Client Approval Mail',                 
        ]);

        $EID = Crypt::decrypt($request->signup_id);

        $Business = BusinessSignup::find($EID);
        $Business->user_id = $Business->user_id; 
        $Business->branch = $Business->branch;   
        $Business->tl = $Business->tl;
        $Business->rm = $Business->rm;
        $Business->rh = $Business->rh;
        $Business->company_status = $Business->company_status;
        $Business->company_name = $request->company_name;
        $Business->client_name = $request->client_name;
        $Business->client_email = $request->client_email;
        $Business->client_mobile = $request->client_mobile;
        $Business->event_name = $request->event_name;
        $Business->event_city = $request->city_signedup;
        $Business->event_startdate = $Business->event_startdate;
        $Business->event_enddate = $Business->event_enddate;
        $Business->event_billeddate = $Business->event_billeddate;
        $Business->service = $request->service;
        $Business->budget_amount = $request->budget_amount;
        $Business->estimate_amount = $request->estimate_amount;
        $Business->profit_amount = $request->profit_amount;
        $Business->profit_percentage = $request->profit_percentage;
        $Business->actual_budget_amount = $request->actual_budget_amount;
        $Business->actual_estimate_amount = $request->actual_estimate_amount;
        $Business->actual_profit_amount = $request->actual_profit_amount;
        $Business->actual_profit_percentage = $request->actual_profit_percentage;
        $Business->payment_budget_amount = $request->payment_budget_amount;
        $Business->payment_estimate_amount = $request->payment_estimate_amount;
        $Business->payment_profit_amount = $request->payment_profit_amount;
        $Business->payment_profit_percentage = $request->payment_profit_percentage;
        $Business->advance_payment_status = $request->advancepayment;
        $Business->advance_payment_date = $request->dateofadvance;
        $Business->advance_payment_amount = $request->advance_amount;
        $Business->purchase_status = $request->purchaseorder; 
        $Business->client_approval_status = $request->clientmail;
        $Business->payment_contract =  $Business->payment_contract;
        $Business->budget_made_by = $Business->budget_made_by;
        $Business->event_signed_up = $Business->event_signed_up;
        $Business->production_employee = $Business->production_employee;
        $Business->creative_employee = $Business->creative_employee; 
        $Business->outside_employee = $Business->outside_employee;

        $User = Auth::user();

        if($request->revision == 0){
            $Business->status = "Reworked";
            $Business->comment = "Reworked";
            
            if($Business->level == 0)
            {
                $Business->level = 1;
            }
            elseif($Business->level == 3)   
            {
                $Business->level = 4;
            }
            elseif($Business->level == 6)   
            {
                $Business->level = 7;
            }
        }
        else
        {
            $revision = UserBusinessRevion::where('signup_id',$EID)->where('status',2)->first();

            $Business->status = "Revised";
            $Business->comment = "Revised";
            $Business->level = 1;

            if($revision->revision == 1)
            {
                $revision->status = 3;
                $revision->comment = "Uploaded";
                $revision->level = 2;
                $revision->save();
            }
            elseif($revision->revision == 3)
            {
                $revision->status = 2;
                $revision->comment = "Uploaded";
                $revision->level = 1;
                $revision->save();
            }   
        }

        $Sheet = $request->budget_sheet;
        if(!is_null($Sheet)){         
            $FileName = $Sheet->hashName();
            Storage::disk('Uploads')->putFile('user/business/budget_sheet/'.$Business->id.'/', ($Sheet));
            $Business->budget_sheet = 'user/business/budget_sheet/'.$Business->id.'/'. $FileName;            
        }

        $Po_pic = $request->po_pic;
        if(!is_null($Po_pic)){ 
            foreach($Po_pic as $file)
            { 
                $FileName = $file->hashName();
                Storage::disk('Uploads')->putFile('user/business/po/'.$Business->id.'/', ($file));
                $purchase_file[] = 'user/business/po/'.$Business->id.'/'. $FileName;     
            }
            $Business->purchase_file=implode('|',$purchase_file);           
        }

        $Approval = $request->approval_mail;
        if(!is_null($Approval)){   
            $File = $Approval->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$Business->id.'/', ($Approval));
            $Business->client_approval_file = 'user/business/clientapproval/'.$Business->id.'/'. $File;        
        }
       
        $Business->save(); 

        Toastr::success('You Have Successfully Updated Additional Business Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return redirect('/signup-list');        

    }
}