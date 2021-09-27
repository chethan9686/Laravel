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
use App\BillingInformation;
use App\Mail\UserBilling;
use App\Mail\UserApprovalBilling;
use App\Mail\UserReworkBilling;
use Log;
use App\Admin;
use App\UserBusinessRevion;

class BillingInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    } 


    public function billinglist()
    {
        $User = Auth::user();
      
        $Users = User::where('status','active')->get();

        if($User->user_position == 1 || $User->user_position == 2 || $User->user_position == 3){
            if($User->branch == 1 || $User->branch == 6 || $User->branch == 7){                               
                $Lists = BillingInformation::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();       
            }elseif($User->branch == 2 || $User->branch == 5){
                $Lists = BillingInformation::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
            }elseif($User->branch == 3){
                $Lists = BillingInformation::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();
            }elseif($User->branch == 4){
                $Lists = BillingInformation::where('user_id', $User->id)->orderBy('created_at', 'desc')->orwhere('tl',$User->id)->orwhere('rm',$User->id)->orwhere('rh',$User->id)->get();    
            }        
        }
        elseif($User->id == 19 || $User->id == 87)
        {
            $Lists = BillingInformation::orderBy('created_at', 'desc')->get();
        }
        else
        {
            $Lists = BillingInformation::where('user_id', $User->id)->orderBy('created_at', 'desc')->get();
        }
       
        return view('user.business.billing_list',compact('User','Lists','Users'));
    }

    public function billinginfo ($EncryptedId)
    {        
        $id = Crypt::decrypt($EncryptedId);    
        $billing = BillingInformation::find($id);
        $signup = BusinessSignup::find($billing->signup_id);
       
        return view('user.business.billinginfo',compact('billing','signup'));
    }

    public function billinginfocreate(Request $request)
    {
        $request->validate([
            'bs_number' => ['required'], 
            'final_invoice_file' => 'required|mimes:xls,xlsx|max:10240', 
            'company_status' => ['required'],
            'gst_certificate'=> ['required_if:company_status,new'],
         ], [
            'bs_number.required' => 'Please Enter Budget Sheet Number',      
            'final_invoice_file.max' => 'Maximum file size to upload is 10MB', 
            'final_invoice_file.required' => 'Please Upload Final Estimate Invoice Sheet',
            'company_status.required' => 'Please Select Company Type',
            'gst_certificate.required_if' =>'Please Upload Company Gst Certificate',
        ]);        

        $Businessbilling = BillingInformation::find($request->billing_id);        
        $Signup = BusinessSignup::find($Businessbilling->signup_id);

        $Businessbilling->po_address = $request->po_address;
        $Businessbilling->single_separate_billing = $request->single_separate_billing;
        $Businessbilling->company_status = $request->company_status;
        $Businessbilling->level = 2;    

        $po_file = $request->purchase_file;
        if(!is_null($po_file)){   

            $request->validate([
                'purchase_file' => 'required|max:10240',                                 
            ], [
                'purchase_file.required' => 'Please Upload The File',
                'purchase_file.max' => 'Maximum file size to upload is 10MB',                       
            ]); 

            foreach($po_file as $file)
            { 
                $FileName = $file->hashName();
                Storage::disk('Uploads')->putFile('user/business/po/'.$Businessbilling->signup_id.'/', ($file));
                $purchase_file[] = 'user/business/po/'.$Businessbilling->signup_id.'/'. $FileName;     
            }
            $Businessbilling->purchase_file=implode($purchase_file,'|');                   
        }        

        $client_mail = $request->client_approval_file;
        if(!is_null($client_mail)){       

            $request->validate([
                'client_approval_file' => 'required|max:10240',                                 
            ], [
                'client_approval_file.required' => 'Please Upload The File',
                'client_approval_file.max' => 'Maximum file size to upload is 10MB',                       
            ]); 

            $FileName = $client_mail->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$Businessbilling->signup_id.'/', ($client_mail));
            $Businessbilling->client_approval_file = 'user/business/clientapproval/'.$Businessbilling->signup_id.'/'. $FileName;            
        }        

        $invoice_sheet = $request->final_invoice_file;
        if(!is_null($invoice_sheet)){         
            $FileName = $invoice_sheet->hashName();
            Storage::disk('Uploads')->putFile('user/business/billinginvoicesheet/'.$Businessbilling->signup_id.'/', ($invoice_sheet));
            $Businessbilling->final_invoice_file = 'user/business/billinginvoicesheet/'.$Businessbilling->signup_id.'/'. $FileName;            
        } 

        $certificate = $request->gst_certificate;
        if(!is_null($certificate)){         
            $FileName = $certificate->hashName();
            Storage::disk('Uploads')->putFile('user/business/gst_certificate/'.$Businessbilling->signup_id.'/', ($certificate));
            $Businessbilling->gst_certificate = 'user/business/gst_certificate/'.$Businessbilling->signup_id.'/'. $FileName;            
        } 
       
        $Businessbilling->save();
        
        //////////////////////////Mail/////////////////////////
        $User = Auth::user();
        $User_details = UserDetails::where('user_id', $User->id)->first();
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

        //Mail::to($User)->send(new UserBilling($User,$cc,$Signup,$Businessbilling));
        //////////////////////////End Mail/////////////////////////

        Toastr::success('You Have Successfully Submitted Billing Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return redirect('/billing-list');
       
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
        $Signup->status = "Approved";
        $Signup->level = 3;
        $Signup->save(); 
        
        $Admin = User::first();
        $AuthUser = Auth::user();
        $Signup_User = User::find($Signup->user_id);
        $AuthUser_details = UserDetails::where('user_id', $AuthUser->id)->first();
        $AuthUser_Name = $AuthUser->first_name.' '.$AuthUser->last_name;
        $cc = '';
        //////////////////////////Mail/////////////////////////////

        //Mail::to($Admin)->send(new UserApprovalBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

        ///////////////////////End Mail////////////////////////////


        Toastr::success('You Have Successfully Approved Billing Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
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
        $Signup->status = "Redo";
        $Signup->level = 0;
        $Signup->save(); 
        
        $Admin = User::first();
        $AuthUser = Auth::user();
        $Signup_User = User::find($Signup->user_id);
        $AuthUser_details = UserDetails::where('user_id', $AuthUser->id)->first();
        $AuthUser_Name = $AuthUser->first_name.' '.$AuthUser->last_name;
        
        //////////////////////////Mail/////////////////////////////
        
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

       // Mail::to($Signup_User)->send(new UserReworkBilling($cc,$AuthUser,$AuthUser_details,$AuthUser_Name,$Signup_User,$Signup));

        ///////////////////////End Mail////////////////////////////

        Toastr::success('You Have Successfully Updated Billing Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }


    public function editbilling($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $Billing = BillingInformation::find($ID);
        $User =  User::find($Billing->user_id);    
        $AllUsers = User::where('status','active')->get();        

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::whereIn('branch',[1,4,6,7])->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::whereIn('branch',[2,5])->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }

        $Revision = 0;
       
        return view('user.business.edit_billing',compact('Users','Billing','AllUsers','Revision'));
    }

    public function editrevisionbilling($EncryptedId)
    {
        $ID = Crypt::decrypt($EncryptedId);
        $Billing = BillingInformation::find($ID);
        $User =  User::find($Billing->user_id);    
        $AllUsers = User::where('status','active')->get();        

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $Users = User::whereIn('branch',[1,4,6,7])->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Users = User::whereIn('branch',[2,5])->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }
        elseif($User->branch == 3)
        {               
            $Users = User::where('branch','=',$User->branch)->where('id','!=',$User->id)->where('status','=','active')->orderBY('first_name','ASC')->get();
        }

        $Revision = 1;
       
        return view('user.business.edit_billing',compact('Users','Billing','AllUsers','Revision'));
    }

    public function submiteditbilling(Request $request)
    {        
        $request->validate([
            'bs_number' => ['required'], 
            'final_invoice_file' => 'mimes:xls,xlsx|max:10240', 
            'company_status' => ['required'],            
         ], [
            'bs_number.required' => 'Please Enter Budget Sheet Number',      
            'final_invoice_file.max' => 'Maximum file size to upload is 10MB',            
            'company_status.required' => 'Please Select Company Type',        
        ]);        

        $Businessbilling = BillingInformation::find($request->billing_id);        
        $Signup = BusinessSignup::find($Businessbilling->signup_id);

        $Businessbilling->po_address = $request->po_address;
        $Businessbilling->single_separate_billing = $request->single_separate_billing;
        $Businessbilling->company_status = $request->company_status;

        if($request->revision == 0)
        {
            $Businessbilling->comment = "Pending";
            $Businessbilling->status = "Pending";    
            if($Businessbilling->level == 0)
            {
                $Businessbilling->level = 2;
            }
            elseif($Businessbilling->level == 4)   
            {
                $Businessbilling->level = 5;
            }
            elseif($Businessbilling->level == 7)   
            {
                $Businessbilling->level = 8;
            } 
        }
        else
        {
            $revision = UserBusinessRevion::where('signup_id',$Businessbilling->signup_id)->where('status',2)->first();

            $Businessbilling->status = "Revised";
            $Businessbilling->comment = "Revised";
            $Businessbilling->level = 2;

            if($revision->revision == 2)
            {
                $revision->status = 3;
                $revision->comment = "Uploaded";
                $revision->level = 2;
                $revision->save();
            }
            elseif($revision->revision == 3)
            {
                if($revision->level == 1)
                {
                    $revision->status = 3;
                    $revision->comment = "Uploaded";
                    $revision->level = 2;
                    $revision->save();
                }
                elseif($revision->level == 0)
                {
                    Toastr::error('Please Submit Signup Form Before Billing Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
                    return back();
                }                
            }
        }
        
           

        $po_file = $request->purchase_file;
        if(!is_null($po_file)){   

            $request->validate([
                'purchase_file' => 'required|max:10240',                                 
            ], [
                'purchase_file.required' => 'Please Upload The File',
                'purchase_file.max' => 'Maximum file size to upload is 10MB',                       
            ]); 

            foreach($po_file as $file)
            { 
                $FileName = $file->hashName();
                Storage::disk('Uploads')->putFile('user/business/po/'.$Businessbilling->signup_id.'/', ($file));
                $purchase_file[] = 'user/business/po/'.$Businessbilling->signup_id.'/'. $FileName;     
            }
            $Businessbilling->purchase_file=implode($purchase_file,'|');                   
        }        

        $client_mail = $request->client_approval_file;
        if(!is_null($client_mail)){       

            $request->validate([
                'client_approval_file' => 'required|max:10240',                                 
            ], [
                'client_approval_file.required' => 'Please Upload The File',
                'client_approval_file.max' => 'Maximum file size to upload is 10MB',                       
            ]); 

            $FileName = $client_mail->hashName();
            Storage::disk('Uploads')->putFile('user/business/clientapproval/'.$Businessbilling->signup_id.'/', ($client_mail));
            $Businessbilling->client_approval_file = 'user/business/clientapproval/'.$Businessbilling->signup_id.'/'. $FileName;            
        }        

        $invoice_sheet = $request->final_invoice_file;
        if(!is_null($invoice_sheet)){         
            $FileName = $invoice_sheet->hashName();
            Storage::disk('Uploads')->putFile('user/business/billinginvoicesheet/'.$Businessbilling->signup_id.'/', ($invoice_sheet));
            $Businessbilling->final_invoice_file = 'user/business/billinginvoicesheet/'.$Businessbilling->signup_id.'/'. $FileName;            
        } 

        if($Businessbilling->company_status == "exist")
        {
            $Businessbilling->gst_certificate = NULL;            
        }
        else
        {
            $certificate = $request->gst_certificate;
            if(!is_null($certificate)){         
                $FileName = $certificate->hashName();
                Storage::disk('Uploads')->putFile('user/business/gst_certificate/'.$Businessbilling->signup_id.'/', ($certificate));
                $Businessbilling->gst_certificate = 'user/business/gst_certificate/'.$Businessbilling->signup_id.'/'. $FileName;            
            } 
        }        
       
        $Businessbilling->save();

        Toastr::success('You Have Successfully Updated Billing Form!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return redirect('/billing-list');
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
