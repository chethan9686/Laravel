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
use Carbon\Carbon;
use App\Holidays;
use App\Appriciation;
use App\Appriciationwish;
use App\Notice;
use App\Branch;
use App\User;
use App\EventsBilling;
use App\BusinessSignup;
use App\BusinessSignupSplit;
use App\BillingInformation;
use App\EventFeAmount;
use Log;
use App\FeAmountAttachment;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard(Request $request)
    {   
        /*$bangalorelist = User::where('branch','=',1)->where('status','=','active')->count();
        $hydrabadlist = User::where('branch','=',4)->where('status','=','active')->count();
        $kolkata = User::where('branch','=',6)->where('status','=','active')->count();
        $BangHyd = $bangalorelist + $hydrabadlist + $kolkata;
        $mumbai = User::where('branch','=',2)->where('status','=','active')->count();
        $pune = User::where('branch','=',5)->where('status','=','active')->count();
        $mumpune = $mumbai + $pune;
        $delhilist = User::where('branch','=',3)->where('status','=','active')->count();
        $totalemployees =  $BangHyd + $mumpune + $delhilist;*/
        
        $from = Carbon::parse("2020-04-01");
        $Carbon = Carbon::now();
       
        $Today = Carbon::today();

        if($Today->month < 4)
        {
            $Last = new Carbon('first day of last year');

            $bang_This_Year = EventsBilling::where('year',$Today->year)->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_Last_Year = EventsBilling::where('year',$Last->year)->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
            $bangalore->all();

            $mum_This_Year = EventsBilling::where('year',$Today->year)->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_Last_Year = EventsBilling::where('year',$Last->year)->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai= collect($mum_This_Year)->merge(collect($mum_Last_Year));
            $mumbai->all();

            $del_This_Year = EventsBilling::where('year',$Today->year)->where('branch','Delhi')->select('January','February','March')->first();
            $del_Last_Year = EventsBilling::where('year',$Last->year)->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi = collect($del_This_Year)->merge(collect($del_Last_Year));
            $delhi->all();          
           
        }
        elseif(4 <= $Today->month)
        {
            $Next = new Carbon('first day of next year');

            $bang_This_Year = EventsBilling::where('year',$Next->year)->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_Last_Year = EventsBilling::where('year',$Today->year)->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
            $bangalore->all();

            $mum_This_Year = EventsBilling::where('year',$Next->year)->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_Last_Year = EventsBilling::where('year',$Today->year)->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai = collect($mum_This_Year)->merge(collect($mum_Last_Year));
            $mumbai->all();

            $del_This_Year = EventsBilling::where('year',$Next->year)->where('branch','Delhi')->select('January','February','March')->first();
            $del_Last_Year = EventsBilling::where('year',$Today->year)->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi = collect($del_This_Year)->merge(collect($del_Last_Year));
            $delhi->all();            
        }

            /////////////////////////////////////////////////////////////////////////////For Graph///////////////////////////////////////////////////////////////////////
            ////////////////////////////////2015-2016//////////////////////////////
            $bang_2016 = EventsBilling::where('year','2016')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2015 = EventsBilling::where('year','2015')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_1516 = collect($bang_2016)->merge(collect($bang_2015));
            $bangalore_1516->all();

            $mum_2016 = EventsBilling::where('year','2016')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2015 = EventsBilling::where('year','2015')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_1516 = collect($mum_2016)->merge(collect($mum_2015));
            $mumbai_1516->all();

            $del_2016 = EventsBilling::where('year','2016')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2015 = EventsBilling::where('year','2015')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_1516 = collect($del_2016)->merge(collect($del_2015));
            $delhi_1516->all();  

            ////////////////////////////////2016-2017//////////////////////////////

            $bang_2017 = EventsBilling::where('year','2017')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2016 = EventsBilling::where('year','2016')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_1617 = collect($bang_2017)->merge(collect($bang_2016));
            $bangalore_1617->all();

            $mum_2017 = EventsBilling::where('year','2017')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2016 = EventsBilling::where('year','2016')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_1617 = collect($mum_2017)->merge(collect($mum_2016));
            $mumbai_1617->all();

            $del_2017 = EventsBilling::where('year','2017')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2016 = EventsBilling::where('year','2016')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_1617 = collect($del_2017)->merge(collect($del_2016));
            $delhi_1617->all();  

             ////////////////////////////////2017-2018//////////////////////////////

            $bang_2018 = EventsBilling::where('year','2018')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2017 = EventsBilling::where('year','2017')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_1718 = collect($bang_2018)->merge(collect($bang_2017));
            $bangalore_1718->all();

            $mum_2018 = EventsBilling::where('year','2018')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2017 = EventsBilling::where('year','2017')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_1718 = collect($mum_2018)->merge(collect($mum_2017));
            $mumbai_1718->all();

            $del_2018 = EventsBilling::where('year','2018')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2017 = EventsBilling::where('year','2017')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_1718 = collect($del_2018)->merge(collect($del_2017));
            $delhi_1718->all();  

            ////////////////////////////////2018-2019//////////////////////////////

            $bang_2019 = EventsBilling::where('year','2019')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2018 = EventsBilling::where('year','2018')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_1819 = collect($bang_2019)->merge(collect($bang_2018));
            $bangalore_1819->all();

            $mum_2019 = EventsBilling::where('year','2019')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2018 = EventsBilling::where('year','2018')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_1819 = collect($mum_2019)->merge(collect($mum_2018));
            $mumbai_1819->all();

            $del_2019 = EventsBilling::where('year','2019')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2018 = EventsBilling::where('year','2018')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_1819 = collect($del_2019)->merge(collect($del_2018));
            $delhi_1819->all();  

            ////////////////////////////////2019-2020//////////////////////////////

            $bang_2020 = EventsBilling::where('year','2020')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2019 = EventsBilling::where('year','2019')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_1920 = collect($bang_2020)->merge(collect($bang_2019));
            $bangalore_1920->all();

            $mum_2020 = EventsBilling::where('year','2020')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2019 = EventsBilling::where('year','2019')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_1920 = collect($mum_2020)->merge(collect($mum_2019));
            $mumbai_1920->all();

            $del_2020 = EventsBilling::where('year','2020')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2019 = EventsBilling::where('year','2019')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_1920 = collect($del_2020)->merge(collect($del_2019));
            $delhi_1920->all();  
            
            $bang_2021 = EventsBilling::where('year','2021')->where('branch','Bangalore')->select('January','February','March')->first();
            $bang_2020 = EventsBilling::where('year','2020')->where('branch','Bangalore')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $bangalore_2021 = collect($bang_2021)->merge(collect($bang_2020));
            $bangalore_2021->all();

            $mum_2021 = EventsBilling::where('year','2021')->where('branch','Mumbai')->select('January','February','March')->first();
            $mum_2020 = EventsBilling::where('year','2020')->where('branch','Mumbai')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $mumbai_2021 = collect($mum_2021)->merge(collect($mum_2020));
            $mumbai_2021->all();
           

            $del_2021 = EventsBilling::where('year','2021')->where('branch','Delhi')->select('January','February','March')->first();
            $del_2020 = EventsBilling::where('year','2020')->where('branch','Delhi')->select('April','May','June','July','Agust','September','October','November','December')->first();
            $delhi_2021 = collect($del_2021)->merge(collect($del_2020));
            $delhi_2021->all();
            
             if(is_null($request->signup_month))
        {
            $Ban_BusinessSignup = BusinessSignup::whereIn('branch',[1,4,6,7])->whereMonth('updated_at',$Carbon->month)->where('level',8)->get();
            $Mum_BusinessSignup = BusinessSignup::whereIn('branch',[2,5])->whereMonth('updated_at',$Carbon->month)->where('level',8)->get();
            $Del_BusinessSignup = BusinessSignup::whereIn('branch',[3])->whereMonth('updated_at',$Carbon->month)->where('level',8)->get();
    
            $Ban_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[1,4,6,7])->whereMonth('billing_information.updated_at',$Carbon->month)->where('billing_information.level',9)->get();
    
            $Mum_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[2,5])->whereMonth('billing_information.updated_at',$Carbon->month)->where('billing_information.level',9)->get();
    
            $Del_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[3])->whereMonth('billing_information.updated_at',$Carbon->month)->where('billing_information.level',9)->get();
        
            $MonthName = $Carbon;
            
            $month = $Today->format('F');
            if($month == "August")
            {
                $month = "Agust";
            }
            $sum_1920 = $bangalore_1920[$month] + $mumbai_1920[$month] + $delhi_1920[$month];
            $sum_2021 = $bangalore[$month] + $mumbai[$month] + $delhi[$month];
            $diff_billing = $sum_2021 - $sum_1920;
            
            $Next = new Carbon('first day of next year');
            $Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Bangalore')->select('January','February','March')->first();
            $This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Bangalore')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $FeAmt = collect($This_Year)->merge(collect($Next_Year));
            $FeAmt->all();                
            $FeAmount = $FeAmt->all(); 

            $bng_fe = $FeAmt[$month];  


            $Mum_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Mumbai')->select('January','February','March')->first();
            $Mum_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Mumbai')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Mum_FeAmt = collect($Mum_This_Year)->merge(collect($Mum_Next_Year));
            $Mum_FeAmt->all();

            $mum_fe = $Mum_FeAmt[$month];


            $Del_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Delhi')->select('January','February','March')->first();
            $Del_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Delhi')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Del_FeAmt = collect($Del_This_Year)->merge(collect($Del_Next_Year));
            $Del_FeAmt->all();

            $del_fe = $Del_FeAmt[$month];
            

            $Next_Attch_Year = FeAmountAttachment::where('year',$Next->year)->select('January','February','March')->first();
            $This_Attch_Year = FeAmountAttachment::where('year',$Today->year)->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Attachment = collect($This_Attch_Year)->merge(collect($Next_Attch_Year));
            $Attachment->all();
        }
        else
        {
            $Month = Carbon::createFromDate($Carbon->year,$request->signup_month,01);

            $Ban_BusinessSignup = BusinessSignup::whereIn('branch',[1,4,6,7])->whereMonth('updated_at',$Month->month)->where('level',8)->get();
            $Mum_BusinessSignup = BusinessSignup::whereIn('branch',[2,5])->whereMonth('updated_at',$Month->month)->where('level',8)->get();
            $Del_BusinessSignup = BusinessSignup::whereIn('branch',[3])->whereMonth('updated_at',$Month->month)->where('level',8)->get();

            $Ban_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[1,4,6,7])->whereMonth('billing_information.updated_at',$Month->month)->where('billing_information.level',9)->get();

            $Mum_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[2,5])->whereMonth('billing_information.updated_at',$Month->month)->where('billing_information.level',9)->get();

            $Del_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[3])->whereMonth('billing_information.updated_at',$Month->month)->where('billing_information.level',9)->get();
        
            $MonthName = $Month;
            
            $month = $MonthName->localeMonth;
            if($month == "August")
            {
                $month = "Agust";
            }
            $sum_1920 = $bangalore_1920[$month] + $mumbai_1920[$month] + $delhi_1920[$month];
            $sum_2021 = $bangalore[$month] + $mumbai[$month] + $delhi[$month];
            $diff_billing = $sum_2021 - $sum_1920;
            
            $Next = new Carbon('first day of next year');
            $Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Bangalore')->select('January','February','March')->first();
            $This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Bangalore')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $FeAmt = collect($This_Year)->merge(collect($Next_Year));
            $FeAmt->all();                
            $FeAmount = $FeAmt->all();   

            $bng_fe = $FeAmt[$month];

            $Mum_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Mumbai')->select('January','February','March')->first();
            $Mum_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Mumbai')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Mum_FeAmt = collect($Mum_This_Year)->merge(collect($Mum_Next_Year));
            $Mum_FeAmt->all();

            $mum_fe = $Mum_FeAmt[$month];


            $Del_Next_Year = EventFeAmount::where('year',$Next->year)->where('branch','Delhi')->select('January','February','March')->first();
            $Del_This_Year = EventFeAmount::where('year',$Today->year)->where('branch','Delhi')->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Del_FeAmt = collect($Del_This_Year)->merge(collect($Del_Next_Year));
            $Del_FeAmt->all();

            $del_fe = $Del_FeAmt[$month];       

            $Next_Attch_Year = FeAmountAttachment::where('year',$Next->year)->select('January','February','March')->first();
            $This_Attch_Year = FeAmountAttachment::where('year',$Today->year)->select('year','April','May','June','July','Agust','September','October','November','December')->first();
            $Attachment = collect($This_Attch_Year)->merge(collect($Next_Attch_Year));
            $Attachment->all();
        }
       
        $current_month = $Today->format('F');
        Switch($current_month)
        {
            case "April":
            $Total_Feamt = $FeAmt[$current_month];     
            $total_month = 1;        
            break;
            case "May":
            $Total_Feamt = $FeAmt['April'] + $FeAmt[$current_month];    
            $total_month = 2;                 
            break;
            case "June":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt[$current_month]; 
            $total_month = 3;                   
            break;
            case "July":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] + $FeAmt[$current_month];     
            $total_month = 4;                
            break;
            case "Agust":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt[$current_month];   
            $total_month = 5;                  
            break;
            case "September":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt[$current_month];  
            $total_month = 6;                  
            break;
            case "October":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt[$current_month];
            $total_month = 7;                     
            break;
            case "November":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $Feamt[$current_month];     
            $total_month = 8;     
            break;
            case "December":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $FeAmt['November'] + $FeAmt[$current_month];     
            $total_month = 9;                
            break;
            case "January":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $FeAmt['November'] + $FeAmt['December'] + $FeAmt[$current_month];    
            $total_month = 10;                
            break;
            case "February":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $FeAmt['November'] + $FeAmt['December'] + $FeAmt['January'] + $FeAmt[$current_month];  
            $total_month = 11;                   
            break;
            case "March":
            $Total_Feamt = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] +  $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $FeAmt['November'] + $FeAmt['December'] + $FeAmt['January'] + $FeAmt['February'] + $FeAmt[$current_month]; 
            $total_month = 12;                    
            break;
        }

        Switch($current_month)
        {
            case "April":
            $Total_Mum_Feamt = $Mum_FeAmt[$current_month];                
            break;
            case "May":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt[$current_month];                
            break;
            case "June":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt[$current_month];               
            break;
            case "July":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] + $Mum_FeAmt[$current_month];                
            break;
            case "Agust":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt[$current_month];                
            break;
            case "September":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt[$current_month];               
            break;
            case "October":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt[$current_month];                
            break;
            case "November":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt[$current_month];     
            break;
            case "December":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt['November'] + $Mum_FeAmt[$current_month];                
            break;
            case "January":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt['November'] + $Mum_FeAmt['December'] + $Mum_FeAmt[$current_month];               
            break;
            case "February":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt['November'] + $Mum_FeAmt['December'] + $Mum_FeAmt['January'] + $Mum_FeAmt[$current_month];                
            break;
            case "March":
            $Total_Mum_Feamt = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] +  $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt['November'] + $Mum_FeAmt['December'] + $Mum_FeAmt['January'] + $Mum_FeAmt['February'] + $Mum_FeAmt[$current_month];                
            break;
        }

        Switch($current_month)
        {
            case "April":
            $Total_Del_Feamt = $Del_FeAmt[$current_month];                
            break;
            case "May":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt[$current_month];                
            break;
            case "June":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt[$current_month];               
            break;
            case "July":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] + $Del_FeAmt[$current_month];                
            break;
            case "Agust":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt[$current_month];                
            break;
            case "September":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt[$current_month];               
            break;
            case "October":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt[$current_month];                
            break;
            case "November":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt[$current_month];     
            break;
            case "December":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt['November'] + $Del_FeAmt[$current_month];                
            break;
            case "January":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt['November'] + $Del_FeAmt['December'] + $Del_FeAmt[$current_month];               
            break;
            case "February":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt['November'] + $Del_FeAmt['December'] + $Del_FeAmt['January'] + $Del_FeAmt[$current_month];                
            break;
            case "March":
            $Total_Del_Feamt = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] +  $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt['November'] + $Del_FeAmt['December'] + $Del_FeAmt['January'] + $Del_FeAmt['February'] + $Del_FeAmt[$current_month];                
            break;
        }
                
        $Total_Ban_BusinessSignup = BusinessSignup::whereIn('branch',[1,4,6,7])->where('level',8)->where('updated_at', '>=', $from->format('Y-m-d'))->get();
        $Total_Mum_BusinessSignup = BusinessSignup::whereIn('branch',[2,5])->where('level',8)->where('updated_at', '>=', $from->format('Y-m-d'))->get();
        $Total_Del_BusinessSignup = BusinessSignup::whereIn('branch',[3])->where('level',8)->where('updated_at', '>=', $from->format('Y-m-d'))->get();

        $Total_Ban_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[1,4,6,7])->where('billing_information.level',9)->where('billing_information.updated_at', '>=', $from->format('Y-m-d'))->get();

        $Total_Mum_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[2,5])->where('billing_information.level',9)->where('billing_information.updated_at', '>=', $from->format('Y-m-d'))->get();
        
        $Total_Del_Billing = BillingInformation::join('business_signups','billing_information.signup_id','=','business_signups.id')->whereIn('billing_information.branch',[3])->where('billing_information.level',9)->where('billing_information.updated_at', '>=', $from->format('Y-m-d'))->get();
      
            
        return view('admin.dashboard.dashboard',compact('bangalore','mumbai','delhi','bangalore_1516','mumbai_1516','delhi_1516','bangalore_1617','mumbai_1617','delhi_1617','bangalore_1718','mumbai_1718','delhi_1718','bangalore_1819','mumbai_1819','delhi_1819','bangalore_1920','mumbai_1920','delhi_1920','Ban_BusinessSignup','Mum_BusinessSignup','Del_BusinessSignup','Total_Ban_BusinessSignup','Total_Mum_BusinessSignup','Total_Del_BusinessSignup','Ban_Billing','Mum_Billing','Del_Billing','Total_Ban_Billing','Total_Mum_Billing','Total_Del_Billing','MonthName','bangalore_2021','mumbai_2021','delhi_2021','sum_1920','sum_2021','diff_billing','Total_Feamt','FeAmount','Attachment','current_month','total_month','bng_fe','mum_fe','del_fe','Total_Feamt','Total_Mum_Feamt','Total_Del_Feamt','FeAmt','Mum_FeAmt','Del_FeAmt'));
    }
    
    public static function currency($data)
    {      
        if($data < 0)
        {
            $data = substr($data, 1); 
            $length = strlen($data);
        }
        else {
            $length = strlen($data);
        }
        
       
        $currency = '';

        if($data == 0)
        {
            $currency = 0;
        }
        elseif($length == 4 || $length == 5)
        {
            // Thousand
            $number = $data / 1000;
            $number = round($number,2);
            $ext = "Thousand";
            $currency = $number." ".$ext;
        }
        elseif($length == 6 || $length == 7)
        {
            // Lakhs
            $number = $data / 100000;
            $number = round($number,2);
            $ext = "Lac";
            $currency = $number." ".$ext;

        }
        elseif($length == 8 || $length == 9)
        {
            // Crores
            $number = $data / 10000000;
            $number = round($number,2);
            $ext = "Cr";
            $currency = $number.' '.$ext;
        }
        return $currency;
    }

    public function profile()
    {    	
    	$User = Auth::user();
        return view('admin.profile.profile',compact('User'));
    }

    public function updateprofilepicture(Request $request)
    {    	
    	Validator::make($request->all(),[
            'Admin_Name' =>'required',
        ])->validate();

        $User = Auth::user();
        $Profile_pic = $request->Admin_Image;

        if(isset($Profile_pic))
        {
            Validator::make($request->all(),[
                'Admin_Image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ])->validate();

            $FileName = $Profile_pic->hashName();
            Storage::disk('Uploads')->putFile('admin/ProfilePicture/', $Profile_pic);
            $User->profile_picture = 'admin/ProfilePicture/' . $FileName;
        }
        
        $User->name = $request->Admin_Name;
        $User->save();

        Toastr::success('You Have Successfully Updated',$title = null, $options = []);
        return back();
    }

    public function update_password(Request $request)
    {
        Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirm_password' =>'required|min:6|string|same:new_password'
        ])->validate();

        $AuthUser = Auth::user();

        if(Hash::check($request->input('old_password'),$AuthUser->password))
        {
            Auth::user()->fill([
                'password' => Hash::make($request->input('new_password'))
            ])->save();

            Toastr::success('You Have Successfully Changed The Password',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
        else
        {
            Toastr::error('Old Password! Is Not Matched With Us. Please Try Again ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();
        }
    } 

    public function notice()
    {
        $notices = Notice::where('status',0)->get();
        $branches = Branch::orderBy('name','asc')->get();
        return view('admin.notice.notice_list',compact('notices','branches'));
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
        return view('admin.notice.view_notice',compact('Notice'));
    }

    public function indexappriciation()
    {
        $appmailsall = Appriciation::orderBy('id', 'DESC')->get();
        return view('admin.appriciationmails.index',compact('appmailsall'));
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
        return view('admin.appriciationmails.viewappriciation', compact('viewappriciation', 'maildata'));
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

    public function holidaysfile()
    {
        $holidays = Holidays::first();      
        return view('admin.holidayslist.holidays',compact('holidays'));
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

    public function hrpolicies()
    {
        return view('admin.hrpolicies.hrpolicies');
    }

    public function aup()
    {
        return view('admin.companypolicy.aup');
    }
}
