<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\EventsBilling;
use Toastr;
use Carbon\Carbon;
use App\EventFeAmount;
use App\FeAmountAttachment;
use Response;
use App\Admin;
use App\Mail\AdminFeAmount;
use App\Mail\AdminFeAmountStatus;

class AdminEventsBilling extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function eventfe_report(){
      $Auth = Auth::user();
      $Today = Carbon::today();
      $Next = new Carbon('first day of next year');

      $Bng_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Bangalore')->select('January','February','March')->first();
      $Bng_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Bangalore')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
      $Bng_Amount = collect($Bng_This_Year)->merge(collect($Bng_Next_Year));
      $Bng_Amount->all();

      $Mum_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Mumbai')->select('January','February','March')->first();
      $Mum_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Mumbai')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
      $Mum_Amount = collect($Mum_This_Year)->merge(collect($Mum_Next_Year));
      $Mum_Amount->all();

      $Del_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Delhi')->select('January','February','March')->first();
      $Del_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Delhi')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
      $Del_Amount = collect($Del_This_Year)->merge(collect($Del_Next_Year));
      $Del_Amount->all();

      $Next_Attch_Year = FeAmountAttachment::where('year',$Next->year)->first();
      $This_Attch_Year = FeAmountAttachment::where('year',$Today->year)->first();
      $Attachment = collect($This_Attch_Year)->merge(collect($Next_Attch_Year));
      $Attachment->all();

      $current_month = $Today->format('F');     

      return view('admin.eventbillingreport.eventfe_report',compact('Amount','Attachment','current_month','Bng_Amount','Mum_Amount','Del_Amount','Auth'));
    }

    public function createfeamount(Request $request)
    {
      $request->validate([          
          'month' => ['required'],  
          'year' => ['required'],            
          'fe_sheet' => 'required|mimes:xlsx|max:10240',
          'bng_amount' => ['required'],
          'mum_amount' => ['required'],
          'del_amount' => ['required'],
      ], [          
          'month.required' => 'Please Select The Month',     
          'year.required' => 'Please Select The Year',          
          'fe_sheet.max' => 'Maximum file size to upload is 10MB', 
          'fe_sheet.required' => 'Please Upload The Excel FE Sheet',
          'bng_amount' => 'Please Enter The Bangalore Branch FE Amount',
          'mum_amount' => 'Please Enter The Mumbai Branch FE Amount',
          'del_amount' => 'Please Enter The Delhi Branch FE Amount',
      ]); 

      $user = Auth::user();
      $user_id = $user->id;         
      $month = $request->month;
      $year = $request->year;
      $branch1 = $request->branch1;
      $branch2 = $request->branch2;
      $branch3 = $request->branch3;

      $Status = $month.'_Status';
      $Comment = $month.'_Comment';

      if($branch1 == "Bangalore")
      {
        $bng_data = EventFeAmount::where('year',$year)->where('branch',$branch1)->first();
      }
      if($branch2 == "Mumbai")
      {
        $mum_data = EventFeAmount::where('year',$year)->where('branch',$branch2)->first();
      }
      if($branch3 == "Delhi")
      {
        $del_data = EventFeAmount::where('year',$year)->where('branch',$branch3)->first();
      }
        
      $Attachment = FeAmountAttachment::where('year',$year)->first();

      if(is_null($bng_data) && is_null($mum_data) && is_null($del_data))
      {
        $res1 = EventFeAmount::create([
                'user_id' => $user_id,   
                'branch' => $branch1,             
                'year' => $year,          
              ]);
        $res1->$month = $request->bng_amount;
        $res1->save();

        $res2 = EventFeAmount::create([
                'user_id' => $user_id,   
                'branch' => $branch2,             
                'year' => $year,          
              ]);
        $res2->$month = $request->mum_amount;
        $res2->save();

        $res3 = EventFeAmount::create([
                'user_id' => $user_id,   
                'branch' => $branch3,             
                'year' => $year,          
              ]);
        $res3->$month = $request->del_amount;
        $res3->save();
      }
      else
      {
        if(!is_null($Attachment->$month))
        {
          Toastr::error('You Have Already Submitted FE Amount!.. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);     
          return back(); 
        }

        $bng_data->$month = $request->bng_amount;
        $bng_data->save();

        $mum_data->$month = $request->mum_amount;
        $mum_data->save();

        $del_data->$month = $request->del_amount;
        $del_data->save();
      } 

      $Sheet = $request->fe_sheet;
      
      if(is_null($Attachment))
      {
        $res = FeAmountAttachment::create([
                'user_id' => $user_id,                
                'year' => $year,                          
              ]);  
        $res->$Status = 1;
        $res->$Comment = "Uploaded";

        $FileName = $Sheet->hashName();
        Storage::disk('Uploads')->putFile('user/business/fe_sheet/'.$year.'/'.$month.'/', $Sheet);
        $res->$month = 'user/business/fe_sheet/'.$year.'/'.$month.'/'.$FileName;
        $res->save();     
      }
      else
      {
        $Attachment->$Status = 1;
        $Attachment->$Comment = "Uploaded";

        $FileName = $Sheet->hashName();
        Storage::disk('Uploads')->putFile('user/business/fe_sheet/'.$year.'/'.$month.'/', $Sheet);
        $Attachment->$month = 'user/business/fe_sheet/'.$year.'/'.$month.'/'.$FileName;
        $Attachment->save();
      }

      $Sendto = Admin::first();      

      Mail::to($Sendto)->send(new AdminFeAmount($user,$Sendto,$month));

      Toastr::success('You Have Successfully Submitted FE Amount!.. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);     
      return back(); 
    }

    public function fe_download(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
       
        $Documents = FeAmountAttachment::where('year',$year);   
        $Documents = $Documents->first();   
        if(!is_null($Documents->$month))
        {
            $filepath = public_path($Documents->$month);            
            return Response::download($filepath);
        }else{
            Toastr::warning('There Is No File To Download !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }    
    }

    public function approvefe_sheet(Request $request)
    {
      $year = $request->year;
      $month = $request->month;

      $Status = $month.'_Status';
      $Comment = $month.'_Comment';

      $Attach = FeAmountAttachment::where('year',$year)->first();

      $Attach->$Status = 2;
      $Attach->$Comment = $request->comment;
      $Attach->save();

      $user = Auth::user();
      $Sendto = Admin::skip(1)->take(1)->first();

      Mail::to($Sendto)->send(new AdminFeAmountStatus($user,$Sendto,$month,$Attach));

      Toastr::success('You Have Successfully Submitted FE Comment !. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
      return back();
    }

    public function editfeamount(Request $request)
    {
      $user = Auth::user();
      $user_id = $user->id;         
      $month = $request->month;
      $year = $request->year;
      $branch1 = $request->branch1;
      $branch2 = $request->branch2;
      $branch3 = $request->branch3;

      $Status = $month.'_Status';
      $Comment = $month.'_Comment';      

      if($branch1 == "Bangalore")
      {
        $bng_data = EventFeAmount::where('year',$year)->where('branch',$branch1)->first();
      }
      if($branch2 == "Mumbai")
      {
        $mum_data = EventFeAmount::where('year',$year)->where('branch',$branch2)->first();
      }
      if($branch3 == "Delhi")
      {
        $del_data = EventFeAmount::where('year',$year)->where('branch',$branch3)->first();
      }
        
      $Attachment = FeAmountAttachment::where('year',$year)->first();

      $bng_data->$month = $request->bng_amount;
      $bng_data->save();

      $mum_data->$month = $request->mum_amount;
      $mum_data->save();

      $del_data->$month = $request->del_amount;
      $del_data->save();

      $Sheet = $request->fe_sheet;

      $Attachment->$Status = 1;
      $Attachment->$Comment = "Revised";

      $FileName = $Sheet->hashName();
      Storage::disk('Uploads')->putFile('user/business/fe_sheet/'.$year.'/'.$month.'/', $Sheet);
      $Attachment->$month = 'user/business/fe_sheet/'.$year.'/'.$month.'/'.$FileName;
      $Attachment->save();

      $Sendto = Admin::first();

      Mail::to($Sendto)->send(new AdminFeAmountStatus($user,$Sendto,$month,$Attachment));

      Toastr::success('You Have Successfully Updated FE Amount Details!.. Thank You',$title = null, $options = ["positionClass" => "toast-top-center"]);     
      return back(); 
    }
}
