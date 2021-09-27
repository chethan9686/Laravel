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
use App\Mail\ReminderMOM;
use Log;

class MoMReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MOM:Reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Remind That MoM is not Uploaded By User After The Meeting';

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
        $Meetings = UserMeeting::whereNull('meeting_status')->where('attendence_update','=',0)->orderBy('created_at', 'desc')->get();

        foreach($Meetings as $meeting)
        {
            $User = User::find($meeting->user_id);

            $Userinfo = UserDetails::where('user_id',$User->id)->first();

            $Meeting_date = Carbon::parse($meeting->date);

            $current = Carbon::now(); 

            $to = Carbon::createFromFormat('Y-m-d H:i:s',$meeting->date.' '.$meeting->time.':00');  

            $from = Carbon::createFromFormat('Y-m-d H:i:s',$current);            

            $Cal_Day_Time = $to->addHour(48);

            $Cal_Day_Time = $Cal_Day_Time->format('l jS \\of F Y \\, h:i:s A');

            $diff_in_Hours = $to->diffInHours($from); 

            $Mail = new SendMail();
            $cc = $Mail->getusers($User,$Userinfo); 

            $tl = User::find($Userinfo->tl);

            $cc = array_merge((array)$tl->email,$cc);

            array_splice($cc, 2, 1);            

            if($diff_in_Hours == 12 )
            {                
                Mail::to($User)->send(new ReminderMOM($meeting,$cc,$Cal_Day_Time));
            }
            elseif($diff_in_Hours == 26 )
            {
                Mail::to($User)->send(new ReminderMOM($meeting,$cc,$Cal_Day_Time));
            }
            elseif($diff_in_Hours == 40 )
            {
                Mail::to($User)->send(new ReminderMOM($meeting,$cc,$Cal_Day_Time));
            }

        }
    }
}
