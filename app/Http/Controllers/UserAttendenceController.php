<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserDetails;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserAttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    }   

   public function index()
    {
    	$User = Auth::user();

        $Current = NULL;
    	$today = Carbon::now();
        $Month = Carbon::now();
        $LastMonth = $Month->subMonth()->format('F');
        
        $dates = []; 

	    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
	        $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
	    }

	 	if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7 )
        {               
           	$Data = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();  
           	$Taken_Leave = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave'); 

            if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }    
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Data = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            $Taken_Leave = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave');

            if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }  
        }
        elseif($User->branch == 3)
        {               
            $Data = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            $Taken_Leave = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave'); 

            if($today->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $today->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }  
        }  

        $Attendence = array_sum($attend);
        
        if(!is_null($User->confirme_date))
        {
            $Date = Carbon::parse($User->confirme_date);

            $Current = Carbon::now();    
            $Datas = array();
            $i=0;

            if($Current->month < 4)
            {
                $Last = new Carbon('last year');
                $Current = $Current->year.'-03';
                $Last = $Last->year.'-04';
                $period = CarbonPeriod::create($Last, '1 month', $Current);
                foreach ($period as $dt) {    
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }                        
            }
            else
            {
                $Next = new Carbon('next year');
                $Current = $Current->year.'-04';
                $Next = $Next->year.'-03';
                $period = CarbonPeriod::create($Current, '1 month', $Next);
                foreach ($period as $dt) {
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }
            }

            if(in_array($Date->format("Y-m"), $Datas))
            {
               $Key = array_search($Date->format("Y-m"), $Datas);
               $Res = array_slice($Datas,$Key);
               $Days = count($Res) * 1.5;          
            }
            else
            {
                $Days = 18;
            }
        }
        else
        {
            $Days = 0;
        }          

    	return view('user.attendence.index',compact('dates','today','Data','Taken_Leave','LastMonth','Current','Days','Attendence'));
    }
    
    public function previousmonth()
    {
        $User = Auth::user();
        
        $Current = Carbon::now();
        $month = Carbon::now();
        $today = $month->subMonth();       
        $LastMonth = NULL;
        
        $dates = []; 

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
        }

        if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7 )
        {               
            $Data = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();  
            $Taken_Leave = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave');

            if($month->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $month->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = BangaloreAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }                          
        }
        elseif($User->branch == 2 || $User->branch == 5)
        {
            $Data = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            $Taken_Leave = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave');    

            if($month->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $month->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = MumbaiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }   
        }
        elseif($User->branch == 3)
        {               
            $Data = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->first();
            $Taken_Leave = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->where('month',$today->month)->sum('paid_leave');    

            if($month->month < 4)
            {
                $Last = new Carbon('first day of last year');
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_Last_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                $bangalore->all();

            }
            elseif(4 <= $month->month)
            {
                $Next = new Carbon('first day of next year');
                $bang_next_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                $bang_This_Year = DelhiAttendence::where('user_id',$User->id)->where('year',$today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                $bangalore->all();
            }

            $attend = array();

            foreach ($bangalore as $key ) {
                array_push($attend, $key->paid_leave);
            }  
        }   

        $Attendence = array_sum($attend);
        
        if(!is_null($User->confirme_date))
        {
            $Date = Carbon::parse($User->confirme_date);

            $Currents = Carbon::now();    
            $Datas = array();
            $i=0;

            if($Current->month < 4)
            {
                $Last = new Carbon('last year');
                $Currents = $Currents->year.'-03';
                $Last = $Last->year.'-04';
                $period = CarbonPeriod::create($Last, '1 month', $Currents);
                foreach ($period as $dt) {    
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }                        
            }
            else
            {
                $Next = new Carbon('next year');
                $Currents = $Currents->year.'-04';
                $Next = $Next->year.'-03';
                $period = CarbonPeriod::create($Currents, '1 month', $Next);
                foreach ($period as $dt) {
                    $Datas[$i]=$dt->format("Y-m");
                    $i++;
                }
            }

            if(in_array($Date->format("Y-m"), $Datas))
            {
               $Key = array_search($Date->format("Y-m"), $Datas);
               $Res = array_slice($Datas,$Key);
               $Days = count($Res) * 1.5;          
            }
            else
            {
                $Days = 18;
            }
        }
        else
        {
            $Days = 0;
        }          
       
       
        return view('user.attendence.index',compact('dates','today','Data','Taken_Leave','LastMonth','Current','Days','Attendence'));
    }
}
