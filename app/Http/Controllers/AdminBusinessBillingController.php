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
use Log;
use App\Mail\UserBilling;
use App\Mail\UserApprovalBilling;
use App\Mail\UserReworkBilling;
use App\Mail\UserCancelBilling;
use App\Mail\UserRevisedBilling;
use App\Admin;

class AdminBusinessBillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function viewbillinglist()
    {
        $User = Auth::user();
    	$Bang_Signups = BillingInformation::whereIn('branch',[1,6,7])->orderBy('updated_at', 'desc')->get();
    	$Mum_Signups = BillingInformation::whereIn('branch',[2,5])->orderBy('updated_at', 'desc')->get();  	
    	$Del_Signups = BillingInformation::whereIn('branch',[3])->orderBy('updated_at', 'desc')->get();
    	$Hyd_Signups = BillingInformation::whereIn('branch',[4])->orderBy('updated_at', 'desc')->get(); 

    	return view('admin.business.billing_list',compact('User','Bang_Signups','Mum_Signups','Del_Signups','Hyd_Signups'));
    }

    public function approvebilling(Request $request)
    {
        $Signup = BillingInformation::find($request->list_id);
        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        
        $Signup->comment = $Comment;

        if($request->user_id == 1)
        {
            $Signup->status = "Approved";            
            $Signup->level = 6;
            
            $Sendto = Admin::skip(1)->take(1)->first();
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;
            $cc ='';
            //////////////////////////Mail/////////////////////////////

          //  Mail::to($Sendto)->send(new UserApprovalBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////
        }
        elseif($request->user_id == 2)
        {
            $Signup->status = "Approved";    
            $Signup->level = 9;       
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;

            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $Admin = Admin::first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;         
            
            $finaceCC = "fin-blr@wings-promos.com";
            $finaceCC1 = "corp-fin@wings-promos.com";
            $finaceCC2 = "fin-eve@wingsevents.com";
            $finaceCC3 = "fin-eve1@wingsevents.com";
           
            $Admin2 = Admin::skip(1)->take(1)->first();
            $user = $Signup_User->email;

            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$finaceCC,(array)$finaceCC1,(array)$finaceCC2,(array)$finaceCC3,(array)$user,(array)$tl,(array)$rm,(array)$rh);
            
            // $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$finaceCC,(array)$finaceCC1,(array)$finaceCC2,(array)$finaceCC3);
           
            if($request->revision == 3)
            {
                // Mail::to($finaceCC)->send(new UserRevisedBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));
            }
            else
            {
                 //  Mail::to($finaceCC)->send(new UserApprovalBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));
            }
         

            ///////////////////////End Mail////////////////////////////     
        }        
        
        $Signup->save(); 

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function rejectbilling(Request $request)
    {
        $Signup = BillingInformation::find($request->list_id);
        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        $Signup->comment = $Comment;

        if($request->user_id == 1)
        {
            $Signup->status = "Redo";            
            $Signup->level = 4;
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;

            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $Admin = Admin::first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;         
            $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();

            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh);

           // Mail::to($Signup_User)->send(new UserReworkBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////
        }
        elseif($request->user_id == 2)
        {
            $Signup->status = "Redo";    
            $Signup->level = 7;    
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;

            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $Admin = Admin::first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;         
            $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();

            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh);

          //  Mail::to($Signup_User)->send(new UserReworkBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////   
        }        
        
        $Signup->save(); 

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }


    public function cancelbilling(Request $request)
    {
        $Signup = BillingInformation::find($request->list_id);
        $Comment = $request->comment;
        
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        $Signup->comment = $Comment;

        if($request->user_id == 2)
        {
            $Signup->status = "Billing Cancelled";    
            $Signup->level = 10;
            $Signup->save();     

            $BusinessSignup = BusinessSignup::find($Signup->signup_id);
            $BusinessSignup->comment = $Comment;
            $BusinessSignup->status = "Billing Cancelled";    
            $BusinessSignup->level = 10; 
            $BusinessSignup->save();     
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;

            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $Admin = Admin::first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;         
            $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();

           // $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh);

            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$tl,(array)$rm,(array)$rh);           

            Mail::to($Signup_User)->send(new UserCancelBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////   
        }          

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }


    public function viewbilling(Request $request)
    {
    	$Billing = BillingInformation::find($request->id);

    	$EncryptedId = Crypt::encrypt($Billing->id);  

    	$data = '<div class="modal-content">';
        $data .=    '<div class="modal-header justify-content-center">';
        $data .=        '<h4 class="title" id="largeModalLabel">Billing - '.$Billing->bs_number.'</h4>';
        $data .=    '</div>';
        $data .=    '<div class="modal-body">'; 
        $data .=        '<div class="row">';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=                '<label>Budget Sheet Number (B.S No)</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>';
        $data .=                    '</div>';                                                             
        $data .=                    '<input type="text" class="form-control" name="bs_number" placeholder="B.S No" value="'.$Billing->bs_number.'"> ';            
        $data .=                '</div> ';                                      
        $data .=            '</div>';
       			            if(!is_null($Billing->po_address)){
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=                '<label>Alternate TO address for PO</label>';
        $data .=              ' <div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<textarea class="form-control" name="po_address" id="po_address" rows="9" cols="50" placeholder="Type Altenate TO address for PO">'.$Billing->po_address.'';
        $data .=                    '</textarea>';   
        $data .=                '</div>';                                       
        $data .=            '</div>';
        		           	} 
                    		if(!is_null($Billing->purchase_file)){
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=               '<label><b>Download Purchase Order Here </b></label>';        
        $data .=               '<label class="download"> <a  href="'.route('admin.billing_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'PO']).'"><span class="input-group-text">';
        $data .=           		'<i class="zmdi zmdi-download"></i></span></a></label>';                                                    
        $data .=            '</div>';
    			           	}
    			            if(!is_null($Billing->client_approval_file)){
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=               '<label><b>Download Client Approval Mail Here </b></label>';        
        $data .=               '<label class="download"> <a  href="'.route('admin.billing_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'Client']).'"><span class="input-group-text">';
        $data .=						'<i class="zmdi zmdi-download"></i></span></a></label>';                                                    
        $data .=            '</div>';
        		            }
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=                '<label><b>Download Final Estimate Invoice Here </b></label>';        
        $data .=                '<label class="download"> <a  href="'.route('admin.billing_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'FEI']).'"><span class="input-group-text">';
        $data .=						'<i class="zmdi zmdi-download"></i></span></a></label>';                                                    
        $data .=            '</div>';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=                '<label for="email_address">Company Type</label>';
        $data .=                '<div class="form-group gender-bottom">'; 
        $data .=                    '<div class="radio inlineblock m-r-20">';    
        	                        	if($Billing->company_status == "exist"){                                                              
        $data .=                            '<input type="radio" class="with-gap" value="exist"  checked>';
        $data .=                            '<label ><i class="zmdi zmdi-case-check"></i> Exist</label>';
      			                      	}else{
        $data .=                             '<input type="radio" class="with-gap" value="new" checked>';
        $data .=                            '<label ><i class="zmdi zmdi-case"></i> New</label> '; 
        		                        }          
        $data .=                    '</div> ';  
        $data .=                '</div> '; 
        $data .=            '</div>';
        			        if(!is_null($Billing->gst_certificate)){
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';               
        $data .=               '<label><b>Download Company GST Certificate Here </b></label>';        
        $data .=               '<label  class="download"> <a  href="'.route('admin.billing_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'GST']).'"><span class="input-group-text">';
        $data .=   				'<i class="zmdi zmdi-download"></i></span></a></label>';
        $data .=            '</div>';
        		            }
        		            if(!is_null($Billing->single_separate_billing)){
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-12">';
        $data .=                '<label>Comment Box</label>';
        $data .=              ' <div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<textarea class="form-control" name="single_separate_billing" id="single_separate_billing" rows="9" cols="50" placeholder="Type Comment for single billing or separate billing for additional">'.$Billing->single_separate_billing.'';
        $data .=                    '</textarea>';   
        $data .=                '</div>';                                       
        $data .=            '</div>';
        		           	}
        $data .=        '</div>';
        $data .=      '</div>';
        $data .=	'</div>';

        return response()->json($data);
    }


    public function billing_download(Request $request)
    {
        $ID = Crypt::decrypt($request->EncryptedId);
        $Document = $request->EncryptedProof;   

        $Documents = BillingInformation::where('id',$ID);

        $zip = new ZipArchive;

        switch ($Document) {            
            case 'PO':
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
            case 'FEI':   
                    $Documents = $Documents->first();  
                  
                    if(!is_null($Documents->final_invoice_file))
                    {
                        $filepath = public_path($Documents->final_invoice_file);
                        return Response::download($filepath);
                    }else{
                        Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }                  
                                                             
            break;
            case 'GST':   
                    $Documents = $Documents->first();  
                    if(!is_null($Documents->gst_certificate))
                    {
                        $filepath = public_path($Documents->gst_certificate);
                        return Response::download($filepath);
                    }else{
                        Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                        return back();
                    }                  
                                                             
            break;
        }
    }
}
