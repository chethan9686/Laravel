<?php

namespace App\Http\Controllers;
use App\Custom\SendMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessSignupDetails;
use Response;
use ZipArchive;
use Toastr;
use App\User;
use App\UserDetails;
use App\Branch;
use App\BusinessClients;
use App\BusinessSignup;
use App\BusinessSignupSplit;
use App\Mail\UserSignup;
use App\Mail\UserApprovalSignup;
use App\Mail\UserReworkSignup;
use Log;
use App\Admin;
use App\Mail\MailTest;
use App\Mail\ReplyComment;
use App\BillingInformation;
use App\UserBusinessRevion;

class ClientBusinessController extends Controller
{
     
    public function __construct()
    {
        $this->middleware('auth');       
    } 

    public function signupclient()
    {
        
    	$User = Auth::user();    	
        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::whereIn('branch',[1,4,6,7])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::whereIn('branch',[2,5])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        $Branches = Branch::orderBy('name','asc')->get();

    	return view('user.business.eventsignup',compact('Users','Branches'));
    }

    public function budgetamount(Request $request)
    {
        $estimate_amount = $request->estimate;
        $budget = $request->budget;

        $profit = ($estimate_amount - $budget);

        if($profit<0)
        {
            $profit = 0;
            $percentage = 0;
            $data = array(
                "profit" =>  $profit,
                "percentage" => $percentage,           
            ); 
        }
        else
        {
            $percentage = (($profit * 100)/$estimate_amount);
            $percentage = number_format($percentage, 2);
            $data = array(
                "profit" =>  $profit,
                "percentage" => $percentage,           
            ); 
        }
        echo json_encode($data);  
    }

    function businesscompanylist(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');        

            $data = BusinessClients::select('company_name')->distinct('company_name')->where('company_name', 'LIKE', '%'.$query.'%') ->orderBy('company_name', 'asc')->get();

            $collection = collect($data);

            $unique_data = $collection->unique()->values()->all();

            if(count($unique_data) > 0)
            {
                $output = '<ul class="dropdown-menu businesscompanylist" style="display:block;position:relative;width: 100%;">';

                foreach($unique_data as $row)
                {
                  $output .= '<li><a>'.$row->company_name.'</a></li>'; 
                }   
    
                $output .='</ul>';
    
                echo $output;
            }else{
                $msg ="No search result found";
                
                $output = '<ul class="dropdown-menu businesscompanylist" style="display:block;position:relative;width: 100%;pointer-events: none;">';
                $output .= '<li><a>'.$msg.'</a></li>';

                $output .='</ul>';
                
                echo $output;
            }       
        }
    }

    public function businesssignup(Request $request)
    {      

        if(is_null($request->exist_company_name) && is_null($request->new_company_name))
        {
            Toastr::error('Please Select Or Enter Company Name!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        
        if(is_null($request->estimate_amount) && is_null($request->budget_amount) && is_null($request->actual_estimate_amount) && is_null($request->actual_budget_amount) && is_null($request->payment_estimate_amount) && is_null($request->payment_budget_amount))
        {
            Toastr::error('Please Enter Any Budget , Estimate Amount and Profit Percentage Details!.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }


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
        
        if(empty(array_filter($request->split_name)) || empty(array_filter($request->split_percentage)))
        {
            Toastr::error('Please Select Event Signup Split Employee Name and Enter Percentage !.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }

    	$request->validate([
            'client_name' => ['required'],
            'client_email' => ['required'],  
            'client_mobile' => ['required'],  
            'event_name' => ['required'], 
            'city_signedup' => ['required'],
            'eventstartdate' => ['required'],  
            'eventenddate' => ['required'],   
            'dateofbilled' => ['required'], 
            'budget_sheet' => 'required|mimes:xls,xlsx|max:10240',
            'advancepayment' => ['required'],
            'dateofadvance' =>['required_if:advancepayment,yes'],
            'advance_amount' =>['required_if:advancepayment,yes'],
            'purchaseorder' => ['required'],
            'clientmail' => ['required'],
            'payment_terms' => ['required'],
            'budgetmadeby' => ['required'],
            'eventsignedup' => ['required'],  
        ], [
            'client_name.required' => 'Please Enter Client Name',
            'client_email.required' => 'Please Enter Client Email',     
            'client_mobile.required' => 'Please Enter Client Mobile Number',   
            'event_name.required' => 'Please Enter Event Name',   
            'city_signedup.required' => 'Please Select City Of Event',
            'eventstartdate.required' =>'Please Select Event Start Date',  
            'eventenddate.required' => 'Please Select Event End Date',    
            'dateofbilled.required' => 'Please Select Date Of Bill',   
            'budget_sheet.max' => 'Maximum file size to upload is 10MB', 
            'budget_sheet.required' => 'Please Upload The Excel Budget Sheet',
            'advancepayment.required' => 'Please Select Advance Payment Status',
            'dateofadvance.required_if' =>'Please Select Advance Payment Date',
            'advance_amount.required_if' => 'Please Enter Advance Payment Amount',
            'purchaseorder.required' => 'Please Select Status For Purchase Order',
            'clientmail.required' => 'Please Select Status For Client Approval Mail',
            'payment_terms.required' =>'Please Enter No Of Days Of Contract',  
            'budgetmadeby.required' => 'Please Select Employee Who Has Made The Budget',    
            'eventsignedup.required' => 'Please Select Employee Who Has Signed Up For The Event',  
        ]); 

        $User = Auth::user();
        $User_details = UserDetails::where('user_id', $User->id)->first();

        if(!is_null($request->new_company_name))
        {
            $companyname = $request->new_company_name;
        }
        elseif(!is_null($request->exist_company_name))            
        {
            $companyname = $request->exist_company_name;
        } 

        if(is_null($request->production_employee))
        {
            $production = $request->production_employee;
        }
        else          
        {
            $production = implode(',',$request->production_employee);
        } 

        if(is_null($request->creative_employee))
        {
            $creative = $request->creative_employee;
        }
        else          
        {
            $creative = implode(',',$request->creative_employee);
        }
        
        $signup = BusinessSignup::create([
            'user_id' => $User->id,    
            'branch' => $User->branch,                                
            'tl' => $User_details->tl,
            'rm' => $User_details->rm,
            'rh' => $User_details->rh,
            'company_status' => $request->company,
            'company_name' => $companyname,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_mobile' => $request->client_mobile,
            'event_name' => $request->event_name,
            'event_city' => $request->city_signedup,
            'event_startdate' => $request->eventstartdate,
            'event_enddate'=> $request->eventenddate,
            'event_billeddate' => $request->dateofbilled,
            'service' => $request->service,
            'creative_amount' => $request->creative_amount,
            'advance_payment_status' => $request->advancepayment,
            'advance_payment_date' => $request->dateofadvance,
            'advance_payment_amount' => $request->advance_amount,
            'purchase_status' => $request->purchaseorder,     
            'client_approval_status' => $request->clientmail,
            'payment_contract' => $request->payment_terms,
            'budget_made_by' => $request->budgetmadeby,
            'event_signed_up' => $request->eventsignedup,
            'production_employee' => $production,  
            'creative_employee' => $creative, 
            'outside_employee' => $request->outside_employee,
            'status' => "Pending",
            'comment' => "Pending",
            'level' => 1,
        ]);

        $Business = BusinessSignup::find($signup->id);
        
        if($request->service == "event")
        {
            $Business->budget_amount = $request->budget_amount;
            $Business->estimate_amount = $request->estimate_amount;
            $Business->profit_amount = $request->profit_amount;
            $Business->profit_percentage = $request->profit_percentage;
            $Business->actual_budget_amount = $request->actual_budget_amount;
            $Business->actual_estimate_amount = $request->actual_estimate_amount;
            $Business->actual_profit_amount = $request->actual_profit_amount;
            $Business->actual_profit_percentage = $request->actual_profit_percentage;            
        }
        elseif($request->service == "payment")
        {
            $Business->payment_budget_amount = $request->payment_budget_amount;
            $Business->payment_estimate_amount = $request->payment_estimate_amount;
            $Business->payment_profit_amount = $request->payment_profit_amount;
            $Business->payment_profit_percentage = $request->payment_profit_percentage;
        }


        $Sheet = $request->budget_sheet;
        if(!is_null($Sheet)){         
            $FileName = $Sheet->hashName();
            Storage::disk('Uploads')->putFile('user/business/budget_sheet/'.$signup->id.'/', ($Sheet));
            $Business->budget_sheet = 'user/business/budget_sheet/'.$signup->id.'/'. $FileName;            
        }

        $Po_pic = $request->po_pic;
        if(!is_null($Po_pic)){ 
            foreach($Po_pic as $file)
            { 
                $FileName = $file->hashName();
                Storage::disk('Uploads')->putFile('user/business/po/'.$signup->id.'/', ($file));
                $purchase_file[] = 'user/business/po/'.$signup->id.'/'. $FileName;     
            }
            $Business->purchase_file=implode($purchase_file,'|');           
        }

        $Approval = $request->approval_mail;
        if(!is_null($Approval)){   
            $File = $Approval->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$signup->id.'/', ($Approval));
            $Business->client_approval_file = 'user/business/clientapproval/'.$signup->id.'/'. $File;        
        }

        $Business->save();

        if(!empty(array_filter($request->split_name)) && !empty(array_filter($request->split_percentage)))
        {
            foreach ($request->split_name as $key => $id) {                
                BusinessSignupSplit::create([
                    'signup_id' => $signup->id,
                    'employee_id' => $id,
                    'percentage' => $request->split_percentage[$key],
                ]);               
            }                
        }


      //////////////////////////Mail/////////////////////////
        $Admin = User::first();
        $User_tl = User::find($User_details->tl);
        $User_rm = User::find($User_details->rm);
        $User_rh = User::find($User_details->rh);
        
        $tl = $User_tl->email;
        $rm = $User_rm->email; 
        $rh = $User_rh->email;         
        $kl = "fin-eve2@wingsevents.com";   
        $Admin2 = Admin::skip(1)->take(1)->first();
        
        $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 

        //Mail::to($User)->send(new UserSignup($User,$cc,$signup));
        //////////////////////////End Mail/////////////////////////

        Toastr::success('You Have Successfully Submitted Business Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }


    public function businesignuplist()
    {
        $User = Auth::user();
      
        $Users = User::where('status','active')->get();

        if($User->user_position == 1 || $User->user_position == 2 || $User->user_position == 3){
            if($User->branch == 1 || $User->branch == 6 || $User->branch == 7){                               
                $Lists = BusinessSignup::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();       
            }elseif($User->branch == 2 || $User->branch == 5){
                $Lists = BusinessSignup::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
            }elseif($User->branch == 3){
                $Lists = BusinessSignup::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
            }elseif($User->branch == 4){
                $Lists = BusinessSignup::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();    
            }        
        }
        elseif($User->id == 19 || $User->id == 87)
        {
            $Lists = BusinessSignup::orderBy('created_at', 'desc')->get();
        }
        else
        {
            $Lists = BusinessSignup::where('user_id', $User->id)->orderBy('created_at', 'desc')->get();
        }

        return view('user.business.signup_list',compact('User','Lists','Users'));
    }

    public function signup_download(Request $request)
    {
        $ID = Crypt::decrypt($request->EncryptedId);
        $Document = $request->EncryptedProof;   

        $Documents = BusinessSignup::where('id',$ID);

        $zip = new ZipArchive;

        switch ($Document) {
            case 'BSheet':   
                    $Documents = $Documents->first();  
                    if(!is_null($Documents->budget_sheet))
                    {
                        $filepath = public_path($Documents->budget_sheet);
                        return Response::download($filepath);
                    }else{
                        Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }                                                                     
            break;
            case 'Po':
                    $fileName = rand(1000,9999).'PoDocuments.zip';   
                    $fileName = '/Documents/'.$fileName;   
                    $POS = $Documents->select('purchase_file')->first();
                    $PO = explode('|',$POS->purchase_file);  

                    if(!empty(array_filter($PO)))
                    {  
                        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                        {                       
                            foreach($PO as $po){          
                                $relativeNameInZipFile = basename($po);                        
                                $zip->addFile(public_path($po), $relativeNameInZipFile);
                            }                   
                            $zip->close();
                        }
                        return response()->download(public_path($fileName)); 

                    }else{
                        Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }     
            break;
            case 'Client': 
                    $Documents = $Documents->first();        
                    if(!is_null($Documents->client_approval_file))
                    {                  
                        $filepath = public_path($Documents->client_approval_file);
                        return Response::download($filepath);   
                    }else{
                        Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    } 
            break;
        }
    }

    public function approvesignup(Request $request)
    {        
        $Signup = BusinessSignup::find($request->list_id);
        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        $Signup->comment = $Comment;
        $Signup->status = "Approved";
        $Signup->level = 2;
        $Signup->save(); 
        
        $Admin = User::first();
        $AuthUser = Auth::user();
        $Signup_User = User::find($Signup->user_id);
        $AuthUser_details = UserDetails::where('user_id', $AuthUser->id)->first();
        $AuthUser_Name = $AuthUser->first_name.' '.$AuthUser->last_name;
        $cc = '';
        $Billing = '';
        //////////////////////////Mail/////////////////////////////

       // Mail::to($Admin)->send(new UserApprovalSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup,$Billing));

        ///////////////////////End Mail////////////////////////////

        Toastr::success('You Have Successfully Approved Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function rejectsignup(Request $request)
    {
        $Signup = BusinessSignup::find($request->list_id);
        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        $Signup->comment = $Comment;
        $Signup->status = "Redo";
        $Signup->level = 0;
        $Signup->save(); 
        
        $Admin = User::first();
        $AuthUser = Auth::user();
        $Signup_User = User::find($Signup->user_id);
        $AuthUser_details = UserDetails::where('user_id', $AuthUser->id)->first();
        $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
        $AuthUser_Name = $AuthUser->first_name.' '.$AuthUser->last_name;
        
        $User_tl = User::find($SignupUser_details->tl);
        $User_rm = User::find($SignupUser_details->rm);
        $User_rh = User::find($SignupUser_details->rh);
        
        $tl = $User_tl->email;
        $rm = $User_rm->email; 
        $rh = $User_rh->email;      
        $kl = "fin-eve2@wingsevents.com";   
        $Admin2 = Admin::skip(1)->take(1)->first();

        $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 
        
        //////////////////////////Mail/////////////////////////////

       // Mail::to($Signup_User)->send(new UserReworkSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

        ///////////////////////End Mail////////////////////////////

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function editsignup($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $Signup = BusinessSignup::find($ID);
        $User = Auth::user();   
        $AllUsers = User::where('status','active')->get(); 
        $Splits = BusinessSignupSplit::where('signup_id',$Signup->id)->get();  

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::whereIn('branch',[1,4,6,7])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::whereIn('branch',[2,5])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }

        $Revision = 0;

        return view('user.business.edit_eventsignup',compact('Users','Signup','AllUsers','Splits','Revision'));
    }

    public function editrevisionsignup($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $Signup = BusinessSignup::find($ID);
        $User = Auth::user();   
        $AllUsers = User::where('status','active')->get(); 
        $Splits = BusinessSignupSplit::where('signup_id',$Signup->id)->get();  

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::whereIn('branch',[1,4,6,7])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::whereIn('branch',[2,5])->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }

        $Revision = 1;

        return view('user.business.edit_eventsignup',compact('Users','Signup','AllUsers','Splits','Revision'));
    }

    public function deletesplit(Request $request)
    {
        BusinessSignupSplit::where('id',$request->id)->delete();
        echo json_encode('success');
    }

    public function submiteditsignup(Request $request)
    {              
        if(is_null($request->exist_company_name) && is_null($request->new_company_name))
        {
            Toastr::error('Please Select Or Enter Company Name!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        
        if(is_null($request->estimate_amount) && is_null($request->budget_amount) && is_null($request->actual_estimate_amount) && is_null($request->actual_budget_amount) && is_null($request->payment_estimate_amount) && is_null($request->payment_budget_amount))
        {
            Toastr::error('Please Enter Any Budget , Estimate Amount and Profit Percentage Details!.Thank You ',$title = null, $options = ["positionClass"=>"toast-top-center"]);
            return back();
        }

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
            'client_name' => ['required'],
            'client_email' => ['required'],  
            'client_mobile' => ['required'],  
            'event_name' => ['required'], 
            'city_signedup' => ['required'],
            'eventstartdate' => ['required'],  
            'eventenddate' => ['required'],   
            'dateofbilled' => ['required'],  
            'budget_sheet' => 'mimes:xls,xlsx|max:10240',
            'advancepayment' => ['required'],
            'dateofadvance' =>['required_if:advancepayment,yes'],
            'advance_amount' =>['required_if:advancepayment,yes'],
            'purchaseorder' => ['required'],
            'clientmail' => ['required'],
            'payment_terms' => ['required'],
            'budgetmadeby' => ['required'],
            'eventsignedup' => ['required'],
        ], [
            'client_name.required' => 'Please Enter Client Name',
            'client_email.required' => 'Please Enter Client Email',     
            'client_mobile.required' => 'Please Enter Client Mobile Number',   
            'event_name.required' => 'Please Enter Event Name',   
            'city_signedup.required' => 'Please Enter City Of Event',
            'eventstartdate.required' =>'Please Select Event Start Date',  
            'eventenddate.required' => 'Please Select Event End Date',    
            'dateofbilled.required' => 'Please Select Date Of Bill',       
            'budget_sheet.max' => 'Maximum file size to upload is 10MB', 
            'advancepayment.required' => 'Please Select Advance Payment Status',
            'dateofadvance.required_if' =>'Please Select Advance Payment Date',
            'advance_amount.required_if' => 'Please Enter Advance Payment Amount',
            'purchaseorder.required' => 'Please Select Status For Purchase Order',
            'clientmail.required' => 'Please Select Status For Client Approval Mail',
            'payment_terms.required' =>'Please Enter No Of Days Of Contract',  
            'budgetmadeby.required' => 'Please Select Employee Who Has Made The Budget',    
            'eventsignedup.required' => 'Please Select Employee Who Has Signed Up For The Event',   
        ]); 

        $User = Auth::user();
        $User_details = UserDetails::where('user_id', $User->id)->first();

        if(!is_null($request->new_company_name))
        {
            $companyname = $request->new_company_name;
        }
        elseif(!is_null($request->exist_company_name))            
        {
            $companyname = $request->exist_company_name;
        } 
       
        if(is_null($request->production_employee))
        {
            $production = $request->production_employee;
        }
        else          
        {
            $production = implode(array_unique($request->production_employee),',');
        } 

        if(is_null($request->creative_employee))
        {
            $creative = $request->creative_employee;
        }
        else          
        {
            $creative = implode(array_unique($request->creative_employee),','); 
        } 

        $EID = Crypt::decrypt($request->signup_id);

        $Business = BusinessSignup::find($EID);
        $Business->user_id = $Business->user_id; 
        $Business->branch = $Business->branch;   
        $Business->tl = $Business->tl;
        $Business->rm = $Business->rm;
        $Business->rh = $Business->rh;
        $Business->company_status = $request->company;
        $Business->company_name = $companyname;
        $Business->client_name = $request->client_name;
        $Business->client_email = $request->client_email;
        $Business->client_mobile = $request->client_mobile;
        $Business->event_name = $request->event_name;
        $Business->event_city = $request->city_signedup;
        $Business->event_startdate = $request->eventstartdate;
        $Business->event_enddate = $request->eventenddate;
        $Business->event_billeddate = $request->dateofbilled;
        $Business->service = $request->service;
        $Business->creative_amount = $request->creative_amount;
        $Business->advance_payment_status = $request->advancepayment;
        $Business->advance_payment_date = $request->dateofadvance;
        $Business->advance_payment_amount = $request->advance_amount;
        $Business->purchase_status = $request->purchaseorder; 
        $Business->client_approval_status = $request->clientmail;
        $Business->payment_contract =  $request->payment_terms;
        $Business->budget_made_by = $request->budgetmadeby;
        $Business->event_signed_up = $request->eventsignedup;
        $Business->production_employee = $production;
        $Business->creative_employee = $creative; 
        $Business->outside_employee = $request->outside_employee;
                
        if($request->service == "event")
        {
            $Business->budget_amount = $request->budget_amount;
            $Business->estimate_amount = $request->estimate_amount;
            $Business->profit_amount = $request->profit_amount;
            $Business->profit_percentage = $request->profit_percentage;
            $Business->actual_budget_amount = $request->actual_budget_amount;
            $Business->actual_estimate_amount = $request->actual_estimate_amount;
            $Business->actual_profit_amount = $request->actual_profit_amount;
            $Business->actual_profit_percentage = $request->actual_profit_percentage;            
        }
        elseif($request->service == "payment")
        {
            $Business->payment_budget_amount = $request->payment_budget_amount;
            $Business->payment_estimate_amount = $request->payment_estimate_amount;
            $Business->payment_profit_amount = $request->payment_profit_amount;
            $Business->payment_profit_percentage = $request->payment_profit_percentage;
        }

        if($request->revision == 0)
        {
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
            $Business->purchase_file=implode($purchase_file,'|');           
        }

        $Approval = $request->approval_mail;
        if(!is_null($Approval)){   
            $File = $Approval->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$Business->id.'/', ($Approval));
            $Business->client_approval_file = 'user/business/clientapproval/'.$Business->id.'/'. $File;        
        }
       
        $Business->save(); 

        BusinessSignupSplit::where('signup_id',$EID)->delete();       

        if(!empty(array_filter($request->split_name)) && !empty(array_filter($request->split_percentage)))
        {
            foreach ($request->split_name as $key => $id) {                
                BusinessSignupSplit::create([
                    'signup_id' => $Business->id,
                    'employee_id' => $id,
                    'percentage' => $request->split_percentage[$key],
                ]);               
            }                
        }

        Toastr::success('You Have Successfully Updated Business Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return redirect('/signup-list');        
    }
    
    public function replycomment(Request $request)
    {
        $User = Auth::user();
        $Signup = BusinessSignup::find($request->list_id);
        $Admin2 = Admin::skip(1)->take(1)->first();
        $Request = $request;
        $Admin = Admin::first()->email;
        $cc = array_merge((array)$Admin,(array)$User->email);
        
       // Mail::to($Admin2)->send(new ReplyComment($User,$Signup,$Request,$cc));

        $Signup->reply = 1;
        $Signup->save();

        Toastr::success('You Have Successfully Replied For Comment!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();

    }
    
    public function eventsignupsplit()
    {
        $User = Auth::user();
        $split_data = BillingInformation::join('business_signup_splits','billing_information.signup_id','=','business_signup_splits.signup_id')->where('business_signup_splits.employee_id','=',$User->id)->where('billing_information.bs_number','NOT LIKE', '%'.'A'.'%')->select('billing_information.signup_id AS Signup_ID','billing_information.bs_number AS BS_Number')->get();

        $add_split_data = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->where('billing_information.bs_number','LIKE', '%'.'A'.'%')->where('business_signups.user_id','=',$User->id)->select('business_signups.parent_id AS Signup_ID','billing_information.bs_number AS BS_Number')->get();        
        $splitdata = collect($split_data)->merge(collect($add_split_data));
        $splitdata->all();

        return view('user.business.split_percentage',compact('splitdata'));
    }
    
    public function mailtest()
    {
        $User = Auth::user();
        $Signup = BusinessSignup::first();       
        Mail::to($User)->send(new MailTest($Signup));
        dd("done");
    }

}
