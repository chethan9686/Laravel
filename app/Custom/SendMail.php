<?php
namespace App\Custom;

use App\User;

class SendMail
{
	public function getusers($User,$User_details)
	{
        $Admin = User::first();
		$User_email = $User->email;
        $User_rm = User::find($User_details->rm);
        $User_rh = User::find($User_details->rh);
        
        $rm = $User_rm->email;            
       
        $rh = $User_rh->email;      

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
        {               
            $hrs = User::where('branch','=',1)->where('user_position',5)->where('status','=','active')->get();
        }
        elseif($User->branch == 2 || $User->branch == 3 || $User->branch == 5)
        {
            $hrs = User::where('branch','=',2)->where('user_position',5)->where('status','=','active')->get();
        }       
        
        foreach($hrs as $key => $Hr)
        {
            $hr[$key] = $Hr->email;
        }

        return array_merge((array)$Admin->email,(array)$User_email,(array)$rm,(array)$rh); 
	}
}
 