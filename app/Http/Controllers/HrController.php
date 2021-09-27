<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Toastr;
use Carbon;
use App\Holidays;
use App\Appriciation;
use App\Notice;
use App\Branch;
use App\Appriciationwish;


class HrController extends Controller
{
    public function notice()
    {
    	$user = Auth::user();
        $notices = Notice::where('status',0)->get();
        $branches = Branch::orderBy('name','asc')->get();
        return view('hr.notice.notice_list',compact('notices','branches','user'));
    }   

    public function addnotice(Request $request)
    {
        $request->validate([
                'title' => ['required', 'string'],
                'branch' => ['required'],  
                'description' => ['required', 'string'],    
        ], [
                'title.required' => 'Notice Title Is Required.',
                'branch.required' => 'Please Select Atleast One Branch',     
                'description.required' => 'Please Enter Some Description',              
        ]);  
        
        Notice::create([
            'title' => $request->title,
            'branch' => implode($request->branch,'|'),
            'description' => $request->description,
        ]);

        Toastr::success('You Have Successfully Inserted Notice Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();   
    }


    public function editnotice(Request $request)
    {
        $Notice = Notice::find($request->notice_id);
        if(isset($request->edit_branch)){

            $Notice->title = $request->edit_title;
            $Notice->description = $request->edit_description;
            $Notice->branch = implode($request->edit_branch,'|');
            $Notice->save();

            Toastr::success('You Have Successfully Updated Notice Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();

        }
        elseif(isset($request->edit_title) && isset($request->edit_description))
        {
            $Notice->title = $request->edit_title;
            $Notice->description = $request->edit_description;   
            $Notice->save();

            Toastr::success('You Have Successfully Updated Notice Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        else{
            Toastr::error('Please Check Notice Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back(); 
        }
        
    }

    public function deletenotice(Request $request)
    {
        $Notice = Notice::find($request->id);
        $Notice->status = 1;
        $Notice->save();
        return response()->json("Success");
    }

    public function viewnotice($EncryptedID)
    {
        $ID = Crypt::decrypt($EncryptedID);
        $Notice = Notice::find($ID);
        return view('hr.notice.view_notice',compact('Notice'));
    }

    public function indexappriciation()
    {
        $appmailsall = Appriciation::orderBy('id', 'DESC')->get();
        return view('hr.appriciationmails.index',compact('appmailsall'));
    } 

    public function appriciationform(Request $request)
    {
        $request->validate([
                'companyname' => ['required', 'string', 'max:255'],
                'clientname' => ['required', 'string', 'max:255'],
                'eventname' => ['required'],
                'location' => ['required','string', 'max:255'],
                'eventdate' => ['required'],  
                'clientmail' => ['required']
        ], [
                'companyname.required' => 'Company Name Is Required.',
                'clientname.required' => 'Client Name Is Required',
                'eventname.required' => 'Event Name Is Required',
                'location.required' => 'Location Is Required',
                'eventdate.required' => 'Event Date Is Required',
                'clientmail.required' => 'Client Mail Details Is Required'     
        ]);  

        $appriciation = new Appriciation();
        $appriciation->companyname = $request->companyname;     
        $appriciation->clientname = $request->clientname;
        $appriciation->eventname = $request->eventname;
        $appriciation->location = $request->location;
        $appriciation->eventdate = date('Y-m-d', strtotime($request->eventdate));
        $appriciation->clientmail = $request->clientmail;
        $appriciation->save();
       
        Toastr::success('You Have Successfully Entered Appreciation Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function viewappriciation(Request $request)
    {
        $id = Crypt::decrypt($request->EncryptedId);
        $viewappriciation = Appriciation::orderBy('id', 'DESC')->where('id','=',$id)->first();
        $maildata = Appriciation::orderBy('id', 'DESC')->where('id','!=',$viewappriciation->id)->get();
        return view('hr.appriciationmails.viewappriciation', compact('viewappriciation', 'maildata'));
    }
    public function updateappriciation(Request $request)
    {   
        $id = $request->id;      
        $update = Appriciation::find($id);
        $update->companyname = $request->edit_companyname;   
        $update->clientname = $request->edit_clientname;
        $update->eventname = $request->edit_eventname;
        $update->location = $request->edit_location;
        $update->eventdate = date('Y-m-d', strtotime($request->edit_eventdate));
        $update->clientmail = $request->edit_clientmail;
        $update->save();

        Toastr::success('You Have Successfully Updated Appreciation Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }
 
    public function appreciation_delete(Request $request)
    {
        $id = $request->id;
        $appr = Appriciation::find($id);

        $wishes = Appriciationwish::where('appriciationmail_id',$appr->id)->get();
        if($wishes->isNotEmpty()){
        	foreach($wishes as $wish){
        		$wish->delete();
        	}        	
        }
        $appr->delete();

        Toastr::success('You Have Successfully Deleted Appreciation Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function appriciationwish(Request $request){
    	
    	$request->validate([
    		'appriciation_whishes' => 'required',
    	]);

    	$user = Auth::user();
        $appriciationwish = new Appriciationwish();
        $appriciationwish->name = $user->first_name.' '.$user->last_name; 
    	$appriciationwish->appriciationmail_id = $request->appriciationmail_id;
    	$appriciationwish->appriciation_whishes = $request->appriciation_whishes;
    	$appriciationwish->save();
    	return back();
    }

    public function holidaysfile()
    {
        $holidays = Holidays::first();              
        return view('hr.holidayslist.holidays',compact('holidays'));
    }
   
    public function importfile(Request $request)
    {        
        $holidays_pdf = $request->holidays_pdf;
        if(isset($holidays_pdf))
        {
            Validator::make($request->all(),[
                'holidays_pdf' =>'required|mimes:jpeg,png,jpg,pdf|max:10240',
            ])->validate();

            $FileName = $holidays_pdf->hashName();            
            Storage::disk('Uploads')->putFile('admin/Holidaysfile/', $holidays_pdf);
            $pdffile = 'admin/Holidaysfile/' . $FileName;

            $holidays = Holidays::first();
            if(is_null($holidays)){
				Holidays::create([
                	'holidays_pdf'=>$pdffile
            	]);
            }else{
            	$holidays->holidays_pdf = $pdffile;
            	$holidays->save();
            }    

            Toastr::success('You Have Successfully Uploaded Holiday List!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }else{
            Toastr::error('Please Upload Holiday List File!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
    }
}
