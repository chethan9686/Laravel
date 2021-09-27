<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use Carbon\Carbon;
use App\User;
use App\UserMeeting;
use App\States;
use App\Clients;
use App\UserNetworking;

class AdminUserMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function usermeeting()
    {
    	$Bang_Users = UserMeeting::whereIn('branch',[1,6,7])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Mum_Users = UserMeeting::whereIn('branch',[2,5])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Del_Users = UserMeeting::whereIn('branch',[3])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
    	$Hyd_Users = UserMeeting::whereIn('branch',[4])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get(); 
       	
    	return view('admin.meeting.meeting',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users'));
    }

    public function viewcompleted(Request $request)
    {
        $States = States::all();
        $meeting = UserMeeting::where('id','=',$request->id)->first();

        if(is_null($meeting->referred_id)){
            $parent_id = $meeting->id;
        }else{
            $parent_id = $meeting->referred_id;
        }  

        $details = Clients::where('parent_mom_id','=',$parent_id)->first(); 
       
        $add_client_email = explode(",",$details->extra_email);

        $data = ' <div class="modal-content">';
        $data .='<div class="modal-header justify-content-center">';
        $data .='<h4 class="title" id="largeModalLabel">Meeting - '. $details->company_name .'</h4>';
        $data .=' </div>';
        $data .='<div class="modal-body"> ';
        $data .=   ' <div class="row">  ';                                                     
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 ">';
        $data .=           ' <label>Company Name</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=               ' <div class="input-group-prepend">';
        $data .=                   ' <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>';
        $data .=               ' </div>';
        $data .=               ' <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" value="'.$details->company_name .'"> ';       
        $data .=           ' </div>   ';                                            
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 ">';
        $data .=           ' <label for="email_address">Client Status</label>';
        $data .=            '<div class="form-group gender-bottom"> ';
        $data .=                '<div class="radio inlineblock m-r-20">  ';      
        if(is_null($details->alternate_client_email))   {                                                                           
        $data .=                   ' <input type="radio" class="with-gap" value="exist" checked>';
        $data .=                   ' <label ><i class="zmdi zmdi-star-circle"></i> Exist</label>  ';     
        }else{                   
        $data .=                    '<input type="radio" class="with-gap" value="new" checked>';
        $data .=                   ' <label ><i class="zmdi zmdi-plus-circle"></i> New</label>  ';
        }                                   
        $data .=                '</div>   ';
        $data .=            '</div>  ';
        $data .=        '</div>';
        $data .=    '</div>';  
        if(is_null($details->alternate_client_email))   {        
        $data .=    '<div class="row exist">';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-6 mb-3">';
        $data .=               ' <label>Client Name</label>';
        $data .=               ' <div class="input-group masked-input">';
        $data .=                   ' <div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" name="exist_company_name" id="exist_company_name" placeholder="Client Name" value="'.$details->client_name .'">    ';
        $data .=                '</div>         ';                                      
        $data .=            '</div>';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-6 mb-3">';
        $data .=                '<label>Client Email</label>';
        $data .=                '<div class="input-group masked-input">';
        $data .=                   ' <div class="input-group-prepend">';
        $data .=                    '    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" name="exist_company_email" id="exist_company_email" placeholder="Client Email" value="'.$details->client_email .'" >';
        $data .=                 '</div>         ';                                      
        $data .=            '</div>';
        $data .=    '</div>';  
        }else{              
        $data .=   ' <div class="row alternate">';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-6 mb-3">';
        $data .=                '<label>Alternate Name</label>';
        $data .=                '<div class="input-group masked-input">';
        $data .=                   ' <div class="input-group-prepend">';
        $data .=                        '<span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" name="alt_company_name" id="alt_company_name" placeholder="Alternate Name" value="'.$details->alternate_client_name .'" >   ';    
        $data .=                '</div>         ';                                      
        $data .=            '</div>';
        $data .=            '<div class="col-lg-6 col-md-6 col-sm-6 mb-3">';
        $data .=               '<label>Alternate Email</label>';
        $data .=                '<div class="input-group masked-input">';
        $data .=                    '<div class="input-group-prepend">';
        $data .=                      '  <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>';
        $data .=                    '</div>';
        $data .=                    '<input type="text" class="form-control" name="alt_company_email" id="alt_company_email" placeholder="Alternate Email" value="'.$details->alternate_client_email .'"> ';              
        $data .=                '</div>   ';                                            
        $data .=       '</div>';
        $data .=    '</div>';   
        }            
        $data .=    '<div class="row">';
        $data .=       ' <div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=           ' <label>Date Of Meeting</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                   ' <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>';
        $data .=                '</div>';
        $data .=               ' <input type="text" class="form-control" name="date" placeholder="Date Of Meeting" value="'.$details->date .'" >  ';                           
        $data .=            '</div>    ';                                           
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=           ' <label>Time Of Meeting</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-time"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="time" placeholder="Time Of Meeting" value="'.$details->time .'" >   ';                            
        $data .=           '</div>       ';                                        
        $data .=        '</div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>Location Of Meeting</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="location" placeholder="Location Of Meeting" value="'.$details->location .'" >  ';                 
        $data .=            '</div>          ';                                     
        $data .=        '</div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>Total No Of Persons Involved In Meeting</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-accounts-add"></i></span>';
        $data .=                '</div>';
        $data .=               ' <input type="number" class="form-control" name="person_involved" placeholder="Persons Involved In Meeting" value="'.$details->person_involved   .'" > ';                   
        $data .=            '</div> ';                                              
        $data .=        '</div>';                    
        $data .=             '<div class="col-lg-12 col-md-12 col-sm-12 mb-3">';
        $data .=                '<div class="row">';
        $data .=                    '<div class="col-lg-12 col-md-12 col-sm-12  field_wrapper">';
        $data .=                       ' <label>Additional Client Email</label>';   
                                    foreach ($add_client_email as $mail) {
        $data .=                        '<div class="input-group masked-input mb-3">';
        $data .=                           ' <div class="input-group-prepend">';
        $data .=                              ' <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>';
        $data .=                            '</div>';
        $data .=                          ' <input type="text" class="form-control" name="additional_email[]" placeholder="Additional Client Email" value="'.$mail.'" > ';
        $data .=                        '</div> '; 
                                    }                             
        $data .=                    '</div>             ';               
        $data .=                '</div>           ';                              
        $data .=            '</div>';                   
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>From The Client</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-accounts"></i></span>';
        $data .=               ' </div>';
        $data .=                '<input type="text" class="form-control" name="from_client" placeholder="From The Client" value="'.$details->from_client   .'" > ';           
        $data .=            '</div>                            ';                   
        $data .=        '</div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>From The Agency</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-airline-seat-recline-normal"></i></span>';
        $data .=                '</div>';                      
        $data .=                 '<input type="text" class="form-control" name="from_agency" placeholder="From The Agency" value="'.$details->from_agency   .'">   ';       
        $data .=            '</div>    ';                                           
        $data .=        '</div>'; 
        $data .=  '<div class="col-lg-12 col-md-12 col-sm-12 mb-3">';
        $data .=            '<label>Key Points</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<textarea class="form-control summernote"  name="key_points" rows="3" placeholder="Key Points">'. $details->key_points .'</textarea>   ';
        $data .=            '</div>                ';                               
        $data .=        '</div>';
        $data .=      ' <div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>Mobile Number</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-smartphone-iphone"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="mobile" placeholder="Mobile Number" value="'.$details->mobile   .'" >      ';    
        $data .=          ' </div>                   ';                            
        $data .=        '</div>';
        $data .=        '<div class="col-lg-6 col-md-6 col-sm-12 mb-3">';
        $data .=            '<label>Landline Number</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-phone-ring"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="landline" placeholder="Landline Number" value="'.$details->landline   .'" >  ';
        $data .=           ' </div>                                               ';
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=            '<label>Address Line 1</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                 '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="address_1" placeholder="Address Line 1" value="'.$details->address_1   .'" >  ';
        $data .=            '</div>        ';                                       
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=            '<label>Address Line 2</label>';
        $data .=             '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>';
        $data .=               ' </div>';
        $data .=               ' <input type="text" class="form-control" name="address_2" placeholder="Address Line 2" value="'.$details->address_2   .'">  ';        
        $data .=            '</div>                                             ';  
        $data .=        '</div>';
        $data .=        ' <div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=            '<label>Address Line 3</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="address_3" placeholder="Address Line 3" value="'.$details->address_3   .'" >  ';       
        $data .=           ' </div>                  ';                             
        $data .=        '</div>';
        $data .=        '<div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=            ' <label>State</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<select class="form-control" name="state">';
        $data .=                    '<option value="">Please Select State</option>      ';    
                            foreach($States as $state)   {                                   
                                if($details->state == $state->id){
        $data .=                              '<option value="'.$state->id.'" selected>'.$state->state_name.'</option>  ';                                              
                                    }                                                                                                                            
                            }                   
        $data .=               ' </select>                 ';    
        $data .=           ' </div>                ';                               
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=           '<label>City</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=                '<div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-city"></i></span>';
        $data .=                '</div>';
        $data .=                '<input type="text" class="form-control" name="city" placeholder="City" value="'.$details->city   .'" >  ';                       
        $data .=            '</div>                                               ';
        $data .=       ' </div>';
        $data .=        '<div class="col-lg-4 col-md-4 col-sm-12 mb-3">';
        $data .=            '<label>Zip Code</label>';
        $data .=            '<div class="input-group masked-input">';
        $data .=               ' <div class="input-group-prepend">';
        $data .=                    '<span class="input-group-text"><i class="zmdi zmdi-home"></i></span>';
        $data .=                '</div> ';
        $data .=               ' <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" value="'.$details->zipcode   .'" >     ';         
        $data .=           ' </div>                  ';                             
        $data .=       ' </div>';                 
        $data .=     '</div>';
        $data .=  '</div>';
        $data .=  ' <div class="modal-footer">         ';      
        $data .=   ' <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>';
        $data .=  '</div>';
        $data .= '</div>';

        return response()->json($data);
    }
    
    public function usernetworkingmeeting()
    {
        $Bang_Users = UserNetworking::whereIn('branch',[1,6,7])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        $Mum_Users = UserNetworking::whereIn('branch',[2,5])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        $Del_Users = UserNetworking::whereIn('branch',[3])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        $Hyd_Users = UserNetworking::whereIn('branch',[4])->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get(); 
        
        return view('admin.meeting.networking_meeting',compact('Bang_Users','Mum_Users','Del_Users','Hyd_Users'));
    }
}
