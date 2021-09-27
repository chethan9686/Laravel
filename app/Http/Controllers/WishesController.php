<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\FileImport;
use App\User;
use App\UserDetails;
use Carbon\Carbon;
use App\Wishes;
use Toastr;

class WishesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    }     

    public function birthdaywish(Request $request)
    {
    	$User = Auth::user();
    	$User_Details = UserDetails::where('user_id',$User->id)->first();    	

    	$Wishes = Wishes::create([
			'user_id' => $User->id,
			'branch' => $User->branch,
			'tl' => $User_Details->tl,
			'rm' => $User_Details->rm,
			'rh' => $User_Details->rh,
			'comment' => $request->comment,			
		]);

		if($request->wish == "Bday")
    	{
    		$Wishes->level = 1;
    	}
    	else
    	{
    		$Wishes->level = 2;
    	}
    	
		$Wishes->save();

    	Toastr::success('You Have Submitted Successfully!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();
    }

    public function viewtest()
    {
        return view('user.test.test');
    }
   
    public function submitfile(Request $request)
    {      
        if($request->hasFile('profile_pic'))
        {             
           Excel::import(new FileImport ,request()->file('profile_pic'));

           dd("done");           
        }
        dd('Request data does not have any files to import.');      
    } 

    public function file_display()
    {
        $Collection = collect();       
        $exists = Storage::disk('Uploads')->exists('1'.'.json');

        if($exists == true)
        {
            $JSONContent = Storage::disk('Uploads')->get('1'.'.json');
            $JSONDecodeData = json_decode($JSONContent, true);

            foreach ($JSONDecodeData as $Data)
            {
                $Collection->push($Data);
            }           
        }
        else
        {
            $Collection = NULL;
        }
                
        return view('user.test.file-list',compact('Collection'));
    }
}