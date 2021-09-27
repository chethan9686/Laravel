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
use App\BsNumber;
use Log;
use App\Mail\UserSignup;
use App\Mail\UserApprovalSignup;
use App\Mail\UserReworkSignup;
use App\Mail\UserCancelSignup;
use App\Mail\UserRevisedSignup;
use App\Admin;
use App\UserBusinessRevion;

class AdminBusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function viewbusinesslist()
    {
        $User = Auth::user();
    	$Bang_Signups = BusinessSignup::whereIn('branch',[1,6,7])->orderBy('level', 'asc')->get();
    	$Mum_Signups = BusinessSignup::whereIn('branch',[2,5])->orderBy('level', 'asc')->get();
    	$Del_Signups = BusinessSignup::whereIn('branch',[3])->orderBy('level', 'asc')->get();
    	$Hyd_Signups = BusinessSignup::whereIn('branch',[4])->orderBy('level', 'asc')->get(); 

    	return view('admin.business.business_list',compact('User','Bang_Signups','Mum_Signups','Del_Signups','Hyd_Signups'));
    }

    public function viewsignup(Request $request)
    {

        $List = BusinessSignup::find($request->id);

        $Users = User::where('status','active')->get();

        $splits = BusinessSignupSplit::where('signup_id',$List->id)->get();        
        $EncryptedId = Crypt::encrypt($List->id);  

        if(is_null($List->production_employee))
        {
            $production = $List->production_employee;
        }
        else
        {
            $PAllocation = $List->production_employee;
            $PExplode = explode(',',$PAllocation);
            $data=array();
            foreach($PExplode as $res)
            {                            
                $User = \App\User::where('id',$res)->first();                    
                array_push($data,$User['first_name']);   
            }
            $production = implode(' , ',$data);
        }

        if(is_null($List->creative_employee))
        {
            $creative = $List->creative_employee;
        }
        else
        {
            $CAllocation = $List->creative_employee;                        
            $CExplode = explode(',',$CAllocation);             
            $data1=array();                        
            foreach($CExplode as $res1)
            {                            
                $User = \App\User::where('id',$res1)->first();                    
                array_push($data1,$User['first_name']);   
            }
            $creative = implode(' , ',$data1);
        }   

        if(is_null($List->parent_id)) {
            $data = '<div class="modal-content">';
            $data .=    '<div class="modal-header justify-content-center">';
            $data .=        '<h4 class="title" id="largeModalLabel">Signup - '.$List->company_name.'</h4>';
            $data .=    '</div>';
        }else{
            $data = '<div class="modal-content">';
            $data .=    '<div class="modal-header justify-content-center">';
            $data .=        '<h4 class="title" id="largeModalLabel">Additional Signup - '.$List->company_name.'</h4>';
            $data .=    '</div>';
        }
        $data .=    '<div class="modal-body">'; 
        $data .=        '<div class="row">';                        
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label for="email_address">Company</label>';
        $data .=                '<div class="form-group gender-bottom">'; 
        $data .=            '<div class="radio inlineblock m-r-20">';    
                                    if($List->company_status == "exist") {                                                            
        $data .=                            '<input type="radio" class="with-gap" value="exist"  checked>';
        $data .=                            '<label ><i class="zmdi zmdi-case-check"></i> Exist</label>';
                                    }else{
        $data .=                            '<input type="radio" class="with-gap" value="new" checked>';
        $data .=                            '<label ><i class="zmdi zmdi-case"></i> New</label>';  
                                    }        
        $data .=                    '</div>';   
        $data .=                '</div>';  
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-4 col-sm-12">';
        $data .=                '<label>Company Name</label>';                        
        $data .=                '<div class="input-group masked-input" >';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>';
        $data .=                    '</div>';
        $data .=                   '<input type="text" class="form-control" value="'.$List->company_name.'">';                                         
        $data .=                '</div>';             
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12 client">';
        $data .=                '<label>Client/User Name</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->client_name.'">';                           
        $data .=                '</div>';
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Client Email</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->client_email.'">';                          
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Client Mobile Number</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->client_mobile .'">';                           
        $data .=                '</div>';                                       
        $data .=            '</div>';
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Event Name</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-view-carousel"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->event_name.'">';                          
        $data .=                '</div>';                                       
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Event Signed in (City)</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                         '<span class="input-group-text"><i class="zmdi zmdi-city-alt"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->event_city.'">';                          
        $data .=                '</div>';                                        
        $data .=            '</div>';                                   
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Starting Date of Event</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->event_startdate.'">';      
        $data .=                '</div>';                                       
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Closing Date of Event</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->event_enddate.'">';              
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Date event will be billed</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->event_billeddate.'">';    
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=             '<div class="col-lg-4 col-md-4 col-sm-12">';
        $data .=                '<label> <b>Download Budget Sheet HERE</b></label>';
        $data .=                '<label class="download"><a href="'.route('admin.signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'BSheet']).'"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label> ';                                                              
        $data .=            '</div>'; 
        if($List->service == "event") {  
            if(!is_null($List->creative_amount)){
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Creative Cost</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->creative_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>'; 
            }
        }
        $data .=    '<div class="col-lg-4 col-md-4 col-sm-12">';
        $data .=        '<label for="email_address">Service</label>';
        $data .=                 '<div class="form-group gender-bottom">';
        $data .=                     '<div class="radio inlineblock m-r-20">';    
        if($List->service == "event") {                         
        $data .=                         '<input type="radio"  class="with-gap" value="event" checked>';
        $data .=                         '<label for="event"><i class="zmdi zmdi-case-check"></i> Event</label>';
        }
        else{
        $data .=                         '<input type="radio" class="with-gap" value="payment" checked>';
        $data .=                         '<label for="payment"><i class="zmdi zmdi-case"></i> Pass Through Payment</label>';               
        }                
        $data .=                     '</div>';  
        $data .=                 '</div>';  
        $data .=             '</div>';
        if($List->service == "event") {
        if(!is_null($List->estimate_amount) && !is_null($List->budget_amount)){
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Estimate Amount(without GST)</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->estimate_amount.'">';   
        $data .=                '</div>';                                        
        $data .=            '</div>';  
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Budget Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->budget_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>';    
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Profit Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                   '<input type="text" class="form-control" value="'.$List->profit_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Profit%</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->profit_percentage.'" >';    
        $data .=                '</div>';                                        
        $data .=            '</div>';
        }
         if(!is_null($List->actual_estimate_amount) && !is_null($List->actual_budget_amount)){
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Actuals Estimate Amount(without GST)</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->actual_estimate_amount.'">';   
        $data .=                '</div>';                                        
        $data .=            '</div>';  
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Actuals Budget Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->actual_budget_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>'; 
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Actuals Profit Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                   '<input type="text" class="form-control" value="'.$List->actual_profit_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Actuals Profit%</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i> </span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->actual_profit_percentage.'" >';    
        $data .=                '</div>';                                        
        $data .=            '</div>';   
        }  }else{ 
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>P-Estimate Amount(without GST)</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->payment_estimate_amount.'">';   
        $data .=                '</div>';                                        
        $data .=            '</div>';  
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>P-Budget Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->payment_budget_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>'; 
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>P-Profit Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>';
        $data .=                    '</div>';
        $data .=                   '<input type="text" class="form-control" value="'.$List->payment_profit_amount.'">';         
        $data .=                '</div>';                                        
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>P-Profit%</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->payment_profit_percentage.'" >';    
        $data .=                '</div>';                                        
        $data .=            '</div>';   
      }
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Advance Payment Status</label>';
        $data .=                '<div class="input-group masked-input mb-3">';                                       
        $data .=                    '<select class="form-control show-tick" >';   
                                    if($List->advance_payment_status == "yes"){
        $data .=                        '<option value="yes" selected="">Yes</option>';
                                    }
                                    else{
        $data .=                        '<option value="no" selected="">No</option>';
                                    }                                                       
        $data .=                    '</select>';                          
        $data .=                '</div>';                                         
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12" id="advancedate"';
                                if($List->advance_payment_status == "yes") {
        $data .=               'style="display: block;"';
                                }else{
        $data .=               ' style="display: none"';
                                }
        $data .=                '>';
        $data .=                '<label>Advance Payment Date</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->advance_payment_date.'">';   
        $data .=                '</div>';                                         
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12" id="advanceammount"';
                                if($List->advance_payment_status == "yes") {
        $data .=                'style="display: block;"';
                                 }else{
        $data .=                'style="display: none"';
                                }
        $data .=                '>';
        $data .=                '<label>Advance Amount</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="fa fa-rupee"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->advance_payment_amount.'">';                         
        $data .=                '</div>'; 
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Purchase Order</label>';
        $data .=                '<div class="input-group masked-input mb-3">';                                       
        $data .=                    '<select class="form-control show-tick" >';    
                                    if($List->purchase_status == "Yes"){
        $data .=                            '<option value="Yes" selected="">Yes</option>';
                                    }
                                    else{
        $data .=                            '<option value="No" selected="">No</option>';
                                    }
        $data .=                    '</select>';                          
        $data .=                '</div>';                                         
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-4 col-sm-12"';
                                if($List->purchase_status == "Yes") {
        $data .=                'style="display: block;"';
                                }else{
        $data .=                'style="display: none"';
                                }
        $data .=                '>';
        $data .=                '<label> <b>Download Purchase Order HERE</b></label>';
        $data .=                '<label class="download"> <a href="'.route('admin.signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'Po']).'"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a> </label>';                                                               
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Client Approvel Mail</label>';
        $data .=                '<div class="input-group masked-input mb-3">';                                       
        $data .=                    '<select class="form-control show-tick" >';  
                                    if($List->client_approval_status == "Yes"){
        $data .=                           '<option value="Yes" selected="">Yes</option>';
                                    }
                                    else{
        $data .=                           '<option value="No" selected="">No</option>';
                                    }        
        $data .=                    '</select>';                         
        $data .=                '</div>';                                         
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Payment terms as per contract with client</label>';
        $data .=                '<div class="input-group masked-input mb-3">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" value="'.$List->payment_contract.'"> ';                          
        $data .=               '</div>'; 
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Budget Made By</label>';
        $data .=                '<div class="input-group masked-input mb-3">';                                           
        $data .=                    '<select class="form-control show-tick">';    
                                    foreach($Users as $user) {     
                                        if($user->id == $List->budget_made_by) {   
        $data .=                               '<option value="'.$user->id.'" selected>'.$user->first_name.' '.$user->last_name .'</option>';   
                                        } 
                                    }           
        $data .=                    '</select>';                        
        $data .=               '</div>';
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-4 col-sm-12" id="mailupload"';
                            if($List->client_approval_status == "Yes") {
        $data .=           'style="display: block;"';
                            }else{
        $data .=           'style="display: none"';
                            }
        $data .=            '>';
        $data .=                '<label><b>Download Client Approvel Mail HERE</b></label>';        
        $data .=                '<label  class="download"> <a href="'.route('admin.signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'Client']).'"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a> </label>';                                                    
        $data .=            '</div>';
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                '<label>Event Signed up</label>';
        $data .=                '<div class="input-group masked-input mb-3">';                                            
        $data .=                    '<select class="form-control show-tick">'; 
                                    foreach($Users as $user) {     
                                        if($user->id == $List->event_signed_up) {   
        $data .=                                '<option value="'.$user->id.'" selected>'.$user->first_name.' '.$user->last_name .'</option>';   
                                        } 
                                    }   
        $data .=                    '</select>';                            
        $data .=                '</div>';
        $data .=            '</div>'; 
            if(!is_null($production)){
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                 '<label>Resource Allocation (Production)</label>';
        $data .=                 '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group masked-input mb-3">';
        $data .=                         '<input type="text" class="form-control" value="'.$production.'">';
        $data .=                     '</div>';
        $data .=                 '</div>';                                        
        $data .=             '</div>';
            }
            if(!is_null($creative)){
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                 '<label>Resource Allocation (Creative - Internal)</label>';
        $data .=                 '<div class="input-group masked-input mb-3">';
        $data .=                     '<div class="input-group masked-input mb-3">';                                                      
        $data .=                         '<input type="text" class="form-control" value="'.$creative.'">';                                                 
        $data .=                     '</div>'; 
        $data .=                 '</div>';                                        
        $data .=             '</div>';
            }
            if(!is_null($List->outside_employee)){
        $data .=             '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                 '<label>Resource Allocation (Creative - Outside)</label>';
        $data .=                 '<div class="input-group masked-input mb-3">';
        $data .=                       '<div class="input-group-prepend">';
        $data .=                           '<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i> </span>';
        $data .=                       '</div>';
        $data .=                       '<input type="text" class="form-control" value="'.$List->outside_employee.'">';
        $data .=                 '</div>';                                        
        $data .=             '</div>'; 
            }
                            foreach($splits as $split) {
        $data .=            '<div class="col-lg-4 col-md-6 col-sm-12">';
        $data .=                 '<div class="row"> ';                           
        $data .=                    '<span class="col-lg-12 col-md-12 col-sm-12">';
        $data .=                        '<div class="row">';
        $data .=                            '<div class="col-lg-9 col-md-9 col-sm-9">';
        $data .=                                '<label>Event Sign up split</label>';
        $data .=                                '<div class="input-group masked-input mb-3"> ';                                                     
        $data .=                                   '<select class="form-control show-tick">';
                                                    foreach($Users as $user) {     
                                                        if($user->id == $split->employee_id) {   
        $data .=                                        '<option value="'.$user->id.'" selected>'.$user->first_name.' '.$user->last_name .'</option>';  
                                                        } 
                                                    }                                       
        $data .=                                    '</select>';                                                                
        $data .=                                '</div> ';
        $data .=                            '</div> ';
        $data .=                            '<div class="col-lg-3 col-md-3 col-sm-3">';    
        $data .=                                '<label style="margin-bottom: 0.6em"> %</label> ';                                   
        $data .=                                '<input type="text" class="form-control" value="'.$split->percentage .'"> ';                                               
        $data .=                            '</div>';
        $data .=                        '</div>';
        $data .=                    '</span>';                                                    
        $data .=               '</div>'; 
        $data .=            '</div> '; 
                            }                             
        $data .=        '</div>';
        $data .=    '</div>';
        $data .= '</div>';

         return response()->json($data);
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

        $Split = BusinessSignupSplit::where('signup_id',$Signup->id)->get();

        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }

        $Info = BillingInformation::first();   
        $Recent = BsNumber::orderBy('created_at','Desc')->first();  
        
        if($Signup->branch == 1 || $Signup->branch == 4 || $Signup->branch == 6 || $Signup->branch == 7)
        {
            if(is_null($Info))
            {
                if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                {
                    $BS = "BNG-P9001";
                }
                else
                {
                    $BS = "BNG9001";
                }    
            } 
            else
            {
                if(is_null($Signup->parent_id))
                {
                    $BS_Number = $Recent->bs_number;               
                    $BS_Number = ++$BS_Number;
                    $BS_Number = substr($BS_Number,-4,4);
                    if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                    {
                        $BS_Number = "BNG-P".$BS_Number;                   
                    }
                    else
                    {
                        $BS_Number = "BNG".$BS_Number;                    
                    }    
                    $BS = $BS_Number;
                }
                else
                {
                    $Parent_Signup = BusinessSignup::find($Signup->parent_id);
                    $Number = BsNumber::where('signup_id',$Signup->parent_id)->first(); 
                    if(!is_null($Parent_Signup->payment_budget_amount) && !is_null($Parent_Signup->payment_estimate_amount))
                    {
                        $Number = $Number->bs_number;                   
                    }
                    else
                    {
                        if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                        {
                            $BS_Number = substr($Number->bs_number,-4,4);
                            $Number ="BNG-P". $BS_Number;
                        }   
                        else{
                            $Number = $Number->bs_number;
                        }                 
                    }  
                    switch ($Parent_Signup->child) {
                        case '1':
                            $BS_Number = $Number."A";
                            break;
                        case '2':
                            $BS_Number = $Number."AA";
                            break;
                        case '3':
                            $BS_Number = $Number."AAA";
                            break;
                        case '4':
                            $BS_Number = $Number."AAAA";
                            break;
                        case '5':
                            $BS_Number = $Number."AAAAA";
                            break;
                        case '6':
                            $BS_Number = $Number."AAAAAA";
                            break;
                        case '7':
                            $BS_Number = $Number."AAAAAAA";
                            break;
                        case '8':
                            $BS_Number = $Number."AAAAAAAA";
                            break;
                        case '9':
                            $BS_Number = $Number."AAAAAAAAA";
                            break;
                        case '10':
                            $BS_Number = $Number."AAAAAAAAAA";
                            break;                      
                    }                   
                    $BS = $BS_Number;                    
                }
                
            }    
                        
        }
        elseif($Signup->branch == 2 || $Signup->branch == 5)
        {
            if(is_null($Info))
            {
                if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                {
                    $BS = "MUM-P9001";
                }
                else
                {
                    $BS = "MUM9001";
                }   
            } 
            else
            {
                if(is_null($Signup->parent_id))
                {
                    $BS_Number = $Recent->bs_number;               
                    $BS_Number = ++$BS_Number;
                    $BS_Number = substr($BS_Number,-4,4);
                    if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                    {
                        $BS_Number = "MUM-P".$BS_Number;
                    }
                    else
                    {
                        $BS_Number = "MUM".$BS_Number;
                    }   
                    $BS = $BS_Number;
                }
                else
                {
                    $Parent_Signup = BusinessSignup::find($Signup->parent_id);
                    $Number = BsNumber::where('signup_id',$Signup->parent_id)->first(); 
                    if(!is_null($Parent_Signup->payment_budget_amount) && !is_null($Parent_Signup->payment_estimate_amount))
                    {
                        $Number = $Number->bs_number;                   
                    }
                    else
                    {
                        if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                        {
                            $BS_Number = substr($Number->bs_number,-4,4);
                            $Number ="MUM-P". $BS_Number;
                        }   
                        else{
                            $Number = $Number->bs_number;
                        }                 
                    }  
                    switch ($Parent_Signup->child) {
                        case '1':
                            $BS_Number = $Number."A";
                            break;
                        case '2':
                            $BS_Number = $Number."AA";
                            break;
                        case '3':
                            $BS_Number = $Number."AAA";
                            break;
                        case '4':
                            $BS_Number = $Number."AAAA";
                            break;
                        case '5':
                            $BS_Number = $Number."AAAAA";
                            break;
                        case '6':
                            $BS_Number = $Number."AAAAAA";
                            break;
                        case '7':
                            $BS_Number = $Number."AAAAAAA";
                            break;
                        case '8':
                            $BS_Number = $Number."AAAAAAAA";
                            break;
                        case '9':
                            $BS_Number = $Number."AAAAAAAAA";
                            break;
                        case '10':
                            $BS_Number = $Number."AAAAAAAAAA";
                            break;
                      
                    }                   
                    $BS = $BS_Number;                    
                }
            }
        }
        elseif($Signup->branch == 3)
        {
            if(is_null($Info))
            {
                if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                {
                    $BS = "DEL-P9001";
                }
                else
                {
                    $BS = "DEL9001";
                }    
            } 
            else
            {
                if(is_null($Signup->parent_id))
                {
                    $BS_Number = $Recent->bs_number;               
                    $BS_Number = ++$BS_Number;
                    $BS_Number = substr($BS_Number,-4,4);
                    if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                    {
                        $BS_Number = "DEL-P".$BS_Number;
                    }
                    else
                    {
                        $BS_Number = "DEL".$BS_Number;
                    }    
                    $BS = $BS_Number;
                }
                else
                {
                    $Parent_Signup = BusinessSignup::find($Signup->parent_id);
                    $Number = BsNumber::where('signup_id',$Signup->parent_id)->first(); 
                    if(!is_null($Parent_Signup->payment_budget_amount) && !is_null($Parent_Signup->payment_estimate_amount))
                    {
                        $Number = $Number->bs_number;                   
                    }
                    else
                    {
                        if(!is_null($Signup->payment_budget_amount) && !is_null($Signup->payment_estimate_amount))
                        {
                            $BS_Number = substr($Number->bs_number,-4,4);
                            $Number ="DEL-P". $BS_Number;
                        }   
                        else{
                            $Number = $Number->bs_number;
                        }                 
                    }  

                    switch ($Parent_Signup->child) {
                        case '1':
                            $BS_Number = $Number."A";
                            break;
                        case '2':
                            $BS_Number = $Number."AA";
                            break;
                        case '3':
                            $BS_Number = $Number."AAA";
                            break;
                        case '4':
                            $BS_Number = $Number."AAAA";
                            break;
                        case '5':
                            $BS_Number = $Number."AAAAA";
                            break;
                        case '6':
                            $BS_Number = $Number."AAAAAA";
                            break;
                        case '7':
                            $BS_Number = $Number."AAAAAAA";
                            break;
                        case '8':
                            $BS_Number = $Number."AAAAAAAA";
                            break;
                        case '9':
                            $BS_Number = $Number."AAAAAAAAA";
                            break;
                        case '10':
                            $BS_Number = $Number."AAAAAAAAAA";
                            break;
                      
                    }                   
                    $BS = $BS_Number;                    
                }
            } 
        }
        
        $Signup->comment = $Comment;

        if($request->user_id == 1)
        {
            $Signup->status = "Approved";
            $Signup->level = 5;
            $Signup->save(); 
            
            $Sendto = Admin::skip(1)->take(1)->first();
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;
            $cc = '';
            $Billing = '';

            //////////////////////////Mail/////////////////////////////

           // Mail::to($Sendto)->send(new UserApprovalSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup,$Billing));

            ///////////////////////End Mail////////////////////////////
        }
        elseif($request->user_id == 2)
        {
            $Signup->status = "Approved";
            $Signup->level = 8;     
            $Signup->reply = 0;     
            $Signup->save(); 

            if($request->revision == 3)
            {
                $Billing = BillingInformation::where('signup_id',$Signup->id)->first();
            }
            else
            {
                if(is_null($Signup->parent_id))
                {
                    BsNumber::create([
                        'user_id' => $Signup->user_id,
                        'signup_id' => $Signup->id,
                        'bs_number' => $BS,  
                    ]);
                }

                $Billing = BillingInformation::create([
                    'user_id' => $Signup->user_id,
                    'signup_id' => $Signup->id,
                    'branch' => $Signup->branch,                                
                    'tl' => $Signup->tl,
                    'rm' => $Signup->rm,
                    'rh' => $Signup->rh,  
                    'bs_number' => $BS,  
                    'status' => "Pending",
                    'comment' => "Pending",     
                    'level' => 1,        
                ]); 

                if(!$Split->isEmpty())
                {   
                    $i=0;
                    $Data = array();
                    foreach($Split as $split)
                    {
                        $Data[$i] = $split->id;
                        $i++;
                    }
                    $Billing->signup_splitid = implode(",",$Data);
                    $Billing->save();
                }
             
            }

            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;

            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;      
            $kl = "fin-eve2@wingsevents.com";
            $finaceCC = "fin-blr@wings-promos.com";
            $finaceCC1 = "corp-fin@wings-promos.com";
            $finaceCC2 = "fin-eve@wingsevents.com";
            $finaceCC3 = "fin-eve1@wingsevents.com";
            $Admin2 = Admin::skip(1)->take(1)->first();
            $Admin = Admin::first();
            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$finaceCC,(array)$finaceCC1,(array)$finaceCC2,(array)$finaceCC3,(array)$tl,(array)$rm,(array)$rh); 

            if($request->revision == 3)
            {
              // Mail::to($Signup_User)->send(new UserRevisedSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup,$Billing));
            }
            else
            {
                 //  Mail::to($Signup_User)->send(new UserApprovalSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup,$Billing));
            }
         
            ///////////////////////End Mail////////////////////////////
            
        }        

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

        if($request->user_id == 1)
        {
            $Signup->status = "Redo";            
            $Signup->level = 3;
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;
            
            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;      
            $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();
            $Admin = Admin::first();
            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 

         //   Mail::to($Signup_User)->send(new UserReworkSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////
        }
        elseif($request->user_id == 2)
        {
            $Signup->status = "Redo";    
            $Signup->level = 6;   
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;
            
            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;      
            $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();
            $Admin =Admin::first();
            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 

        //    Mail::to($Signup_User)->send(new UserReworkSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////
        }        
        
        $Signup->save(); 

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function cancelsignup(Request $request)
    {
        $Signup = BusinessSignup::find($request->list_id);
        $Comment = $request->comment;
        if(is_null($Comment))
        {
            Toastr::error('Please Enter The Comments!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        if($request->user_id == 2)
        {
            $Signup->comment = $Comment;
            $Signup->status = "Signup Cancelled";    
            $Signup->level = 9;
            $Signup->save();    
            
            $AuthUser = Auth::user();
            $Signup_User = User::find($Signup->user_id);
            $AuthUser_details = Auth::user();
            $AuthUser_Name = $AuthUser->name;
            
            //////////////////////////Mail/////////////////////////////
            
            $SignupUser_details = UserDetails::where('user_id', $Signup_User->id)->first();
            $User_tl = User::find($SignupUser_details->tl);
            $User_rm = User::find($SignupUser_details->rm);
            $User_rh = User::find($SignupUser_details->rh);
            
            $tl = $User_tl->email;
            $rm = $User_rm->email; 
            $rh = $User_rh->email;      
            // $kl = "fin-eve2@wingsevents.com";   
            $Admin2 = Admin::skip(1)->take(1)->first();
            $Admin =Admin::first();
           // $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$kl,(array)$tl,(array)$rm,(array)$rh); 

            $cc = array_merge((array)$Admin->email,(array)$Admin2->email,(array)$tl,(array)$rm,(array)$rh); 

            Mail::to($Signup_User)->send(new UserCancelSignup($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

            ///////////////////////End Mail////////////////////////////
        }         

        Toastr::success('You Have Successfully Updated Signup Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
}
