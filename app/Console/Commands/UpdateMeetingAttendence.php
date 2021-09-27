<?php

namespace App\Console\Commands;
use App\Custom\SendMail;
use App\Custom\ConvertNumber;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\UserDetails;
use App\UserMeeting;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Carbon\Carbon;
use Log;

class UpdateMeetingAttendence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Update:Meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Update Attendence For Meeting After 48 Hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $Meetings = UserMeeting::whereNull('meeting_status')->whereNull('referred_id')->where('attendence_update','=',0)->orderBy('created_at', 'desc')->get();       

         foreach($Meetings as $meeting)
         {
             $User = User::find($meeting->user_id);

            $Meeting_date = Carbon::parse($meeting->date);

            $day = $Meeting_date->day;

            $number = new ConvertNumber(); 
            $num_word = $number->numberTowords($day);

            $current = Carbon::now(); 

            $to = Carbon::createFromFormat('Y-m-d H:i:s',$meeting->date.' '.$meeting->time.':00');  

            $from = Carbon::createFromFormat('Y-m-d H:i:s',$current);

            $diff_in_Mins = $to->diffInMinutes($from);           

            if($diff_in_Mins >= '2880')
            {                
                if($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7)
                {
                    $User_Attendence = BangaloreAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$meeting->user_id)->first();
                    if($User_Attendence)
                    {                    
                        $User_Attendence->$num_word = 'ABM';
                        $User_Attendence->save();                    
                    }
                }
                elseif($User->branch == 2 || $User->branch == 5)
                {
                    $User_Attendence = MumbaiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$meeting->user_id)->first();
                    if($User_Attendence)
                    {
                        $User_Attendence->$num_word = 'ABM';
                        $User_Attendence->save();
                    }
                }
                elseif($User->branch == 3)
                {   
                    $User_Attendence = DelhiAttendence::where('year','=',$Meeting_date->year)->where('month','=',$Meeting_date->month)->where('user_id','=',$meeting->user_id)->first();
                    if($User_Attendence)
                    {
                        $User_Attendence->$num_word = 'ABM';
                        $User_Attendence->save();
                    }    
                }

                $meeting->attendence_update = 1;
                $meeting->save();
            } 
        }        
    }
}
