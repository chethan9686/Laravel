<?php

namespace App\Http\Controllers;

use App\Custom\ConvertNumber;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DownloadBangalore;
use App\Imports\DownloadDelhi;
use App\Imports\DownloadMumbai;
use App\BangaloreAttendence;
use App\DelhiAttendence;
use App\MumbaiAttendence;
use Carbon\Carbon;

class AdminAttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function bangaloreattendencelist()
    {
        $Current = NULL;
        $Month = Carbon::now();
        $LastMonth = $Month->subMonth()->format('F');

        $today = Carbon::now();
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }
        
        $attendence_datas = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get(); 

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"bangalore");
        }

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get(); 

        return view('admin.attendence.bangalore_attendence_list',compact('users','calendar','Current','LastMonth'));
    }
    
    public function previousbangaloreattendencelist()
    {
        $Current = Carbon::now();
        $Month = Carbon::now();
        $today = $Month->subMonth();

        $LastMonth = NULL;
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }
        
        $attendence_datas = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get(); 

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"bangalore");
        }

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get(); 

        return view('admin.attendence.bangalore_attendence_list',compact('users','calendar','Current','LastMonth'));
    }

    public function delhiattendencelist()
    {
        $Current = NULL;
        $Month = Carbon::now();
        $LastMonth = $Month->subMonth()->format('F');
        
        $today = Carbon::now();
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

         for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }

        $attendence_datas = DelhiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get();

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"delhi");
        }

        $users = DelhiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get();

        return view('admin.attendence.delhi_attendence_list',compact('users','calendar','Current','LastMonth'));
    }
    
    public function previousdelhiattendencelist()
    {
        $Current = Carbon::now();
        $Month = Carbon::now();
        $today = $Month->subMonth();

        $LastMonth = NULL;
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

         for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }

        $attendence_datas = DelhiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get();

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"delhi");
        }

        $users = DelhiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get();

        return view('admin.attendence.delhi_attendence_list',compact('users','calendar','Current','LastMonth'));
    }

    public function mumbaiattendencelist()
    {
        $Current = NULL;
        $Month = Carbon::now();
        $LastMonth = $Month->subMonth()->format('F');

        $today = Carbon::now();
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

         for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }

        $attendence_datas = MumbaiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get();

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"mumbai");
        }

        $users = MumbaiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get();

        return view('admin.attendence.mumbai_attendence_list',compact('users','calendar','Current','LastMonth'));
    }
    
    public function previousmumbaiattendencelist()
    {
        $Current = Carbon::now();
        $Month = Carbon::now();
        $today = $Month->subMonth();

        $LastMonth = NULL;
        $dates = []; 
        $calendar = [];
        array_push($dates,'id','user_id','emp_id','emp_name','year','month','present','meeting','event','outstation','comp','paid_leave','cut_leave','working');

         for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $calendar[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);
            $dates[] = $num_word;
        }

        $attendence_datas = MumbaiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->orderBy('emp_name','ASC')->get();

        foreach($attendence_datas as $data)
        {           
            $this->calculate_admin_attendence($data->id,"mumbai");
        }

        $users = MumbaiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->distinct()->select($dates)->orderBy('emp_name','ASC')->get();

        return view('admin.attendence.mumbai_attendence_list',compact('users','calendar','Current','LastMonth'));
    }

    public function calculate_admin_attendence($data,$location)
    {        
        if($location == "bangalore")
        {
            $Attendence = BangaloreAttendence::find($data);
        }
        elseif($location == "delhi")
        {
            $Attendence = DelhiAttendence::find($data);
        }
        elseif($location == "mumbai")
        {
            $Attendence = MumbaiAttendence::find($data);
        }        

        $data = array($Attendence->one,$Attendence->two,$Attendence->three,$Attendence->four,$Attendence->five,$Attendence->six,$Attendence->seven,$Attendence->eight,$Attendence->nine,$Attendence->ten,$Attendence->eleven,$Attendence->twelve,$Attendence->thirteen,$Attendence->fourteen,$Attendence->fifteen,$Attendence->sixteen,$Attendence->seventeen,$Attendence->eighteen,$Attendence->nineteen,$Attendence->twenty,$Attendence->twentyone,$Attendence->twentytwo,$Attendence->twentythree,$Attendence->twentyfour,$Attendence->twentyfive,$Attendence->twentysix,$Attendence->twentyseven,$Attendence->twentyeight,$Attendence->twentynine,$Attendence->thirty,$Attendence->thirtyone); 
        
        $P = array();
        $SUN = array();
        $H = array();
        $AB = array();
        $L = array();
        $M = array();
        $E = array();
        $OS = array();
        $CO = array();
        $COF = array();
        $LC = array();
        $NJ = array();
        $NHD = array();
        $HD = array();
        $LL = array();

        foreach($data as $dt)
        {
            if($dt == "SUN")
            {
                $dt = 1;
                array_push($SUN,$dt);
            }
            elseif($dt == "H")
            {
                $dt = 1;
                array_push($H,$dt);
            }
            elseif($dt == "NJ")
            {
                $dt = 1;
                array_push($NJ,$dt);
            }
            elseif($dt == "P")
            {
                $dt = 1;
                array_push($P,$dt);
            }   
            elseif($dt > '09:46' && $dt < '10:16' || $dt > '10:16' && $dt < '10:46')
            {
                $dt = 1;
                array_push($LC,$dt);
            }           
            elseif($dt == "M")
            {
                $dt = 1;
                array_push($M,$dt);
            }
            elseif($dt == "E")
            {
                $dt = 1;
                array_push($E,$dt);
            }
            elseif($dt == "OS")
            {
                $dt = 1;
                array_push($OS,$dt);
            }
            elseif($dt == "HDCO" || $dt == "FDCO")
            {
                if($dt == "HDCO")
                {
                    $dt = 0.5;
                    $dtc = 1;
                }
                if($dt == "FDCO")
                {
                    $dt = 1;
                    $dtc = 1;
                }
                array_push($CO,$dt);
                array_push($COF,$dtc);
            }
            elseif($dt == "AB" || $dt == "ABM")
            {
                if($dt == "AB" || $dt == "ABM")
                {
                    $dt = 1;
                }               
                array_push($AB,$dt);
            }
            elseif($dt == "HDL" || $dt == "FDL")
            {
                if($dt == "HDL")
                {
                    $dt = 0.5;
                    $dtl = 1;                    
                }
                if($dt == "FDL")
                {
                    $dt = 1;
                    $dtl = 1;  
                }               
                array_push($L,$dt);
                array_push($LL,$dtl);
            }
            elseif($dt == "NHD")
            {
                $dt = 0.5;
                array_push($NHD,$dt);
            }
            elseif($dt == "HD")
            {            
                $dt = 0.5;
                array_push($HD,$dt);      
            }
        }
        $P = array_sum($P);
        $M = array_sum($M);
        $E = array_sum($E);
        $OS = array_sum($OS);
        $CO = array_sum($CO);
        $COF = array_sum($COF);
        $L = array_sum($L);
        $AB = array_sum($AB);
        $SUN = array_sum($SUN);
        $H = array_sum($H);
        $LC = array_sum($LC);
        $NJ = array_sum($NJ);
        $NHD = array_sum($NHD);
        $HD = array_sum($HD);
        $LL = array_sum($LL);

        $Total = $SUN+$H+$P+$M+$E+$OS+$COF+$LL+$LC+$NJ+$NHD+$HD;

        $Attendence->present = $P;
        $Attendence->meeting = $M;
        $Attendence->event = $E;
        $Attendence->outstation = $OS;
        $Attendence->comp = $CO;
        $Attendence->paid_leave = $L+$HD;
        $Attendence->cut_leave = $AB+$NHD+$HD;
        $Attendence->working = $Total;
        $Attendence->save();    

        return back();   
    }
    
    public function bangalore_download_attendence()
    {
        $today = Carbon::now();      
        $dates = []; 
        $heading = [];
        array_push($dates,'emp_name');
        
        array_push($heading,'Employeee Name');
        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $heading[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');

            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);

            $dates[] = $num_word;
        }   
        
        array_push($dates,'present','meeting','event','outstation','comp','paid_leave','cut_leave','working');
        array_push($heading,'Present','Meeting','Event','Outstation','Comp','Paid_leave','Cut_leave','Working Days');

        $users = BangaloreAttendence::where('year','=',$today->year)->where('month','=',$today->month)->select($dates)->orderBy('emp_name','ASC')->get(); 
        return Excel::download(new DownloadBangalore($users,$heading), 'Bangalore_Employees.xlsx');
    }

    public function delhi_download_attendence()
    {
        $today = Carbon::now();      
        $dates = []; 
        $heading = [];
        array_push($dates,'emp_name');
        
        array_push($heading,'Employeee Name');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $heading[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');

            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);

            $dates[] = $num_word;
        }   
        
        array_push($dates,'present','meeting','event','outstation','comp','paid_leave','cut_leave','working');
        array_push($heading,'Present','Meeting','Event','Outstation','Comp','Paid_leave','Cut_leave','Working Days');

        $users = DelhiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->select($dates)->orderBy('emp_name','ASC')->get(); 
        return Excel::download(new DownloadDelhi($users,$heading), 'Delhi_Employees.xlsx');
    }

    public function mumbai_download_attendence()
    {
        $today = Carbon::now();      
        $dates = []; 
        $heading = [];
        array_push($dates,'emp_name');
        
        array_push($heading,'Employeee Name');

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $heading[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');

            $day = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);

            $dates[] = $num_word;
        }   
        
        array_push($dates,'present','meeting','event','outstation','comp','paid_leave','cut_leave','working');
        array_push($heading,'Present','Meeting','Event','Outstation','Comp','Paid_leave','Cut_leave','Working Days');

        $users = MumbaiAttendence::where('year','=',$today->year)->where('month','=',$today->month)->select($dates)->orderBy('emp_name','ASC')->get(); 
        return Excel::download(new DownloadMumbai($users,$heading), 'Mumbai_Employees.xlsx');
    }
}
