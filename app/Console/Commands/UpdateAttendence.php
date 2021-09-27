<?php

namespace App\Console\Commands;
use App\Custom\ConvertNumber;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\UserDetails;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use Log;

class UpdateAttendence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Update:Attendence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update Monthly Employees data to attendence table';

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
        $BUsers =  User::where('status','=','active')->whereIn('branch',[1,4,6,7])->where('email_verify','=','1')->orderBy('first_name','asc')->get();

        $MUsers =  User::where('status','=','active')->whereIn('branch',[2,5])->where('email_verify','=','1')->orderBy('first_name','asc')->get();

        $DUsers =  User::where('status','=','active')->whereIn('branch',[3])->where('email_verify','=','1')->orderBy('first_name','asc')->get();

        $date = Carbon::today();

        $month  = date('06');
        $year  = date('Y');
        $days = date('t', mktime(0, 0, 0, $month, 1, $year));
                
        $number = new ConvertNumber(); 
        for($i = 1; $i<= $days; $i++){
          $day  = date('Y-06-'.$i);
          $result = date("l", strtotime($day));
          if($result != "Sunday"){
                $day = date("d", strtotime($day));
                $num_word = $number->numberTowords($day);
                $data[$i] = $num_word;
          }
        }

        Log::info($data);
       
      
        /////////////////Bangalore Employees////////////////////
        // foreach ($BUsers as $key => $user) {
            
        //     $details = UserDetails::where('user_id','=',$user->id)->first();

        //     $latest = BangaloreAttendence::where('user_id',$user->id)->where('year',$date->year)->where('month',5)->first();

        //     foreach ($data as $key => $value) {
        //         if(is_null($latest->$value))
        //         {
        //             $latest->$value = "P";
        //             $latest->save();
        //         }        
        //     }
        // }

        /////////////////Mumbai Employees////////////////////
        // foreach ($MUsers as $key => $user) {
            
        //     $details = UserDetails::where('user_id','=',$user->id)->first();
           
        //     $latest = MumbaiAttendence::where('user_id',$user->id)->where('year',$date->year)->where('month',5)->first();

        //     foreach ($data as $key => $value) {
        //         if(is_null($latest->$value))
        //         {
        //             $latest->$value = "P";
        //             $latest->save();
        //         }   
        //     }
        // }

        /////////////////Delhi Employees////////////////////
        // foreach ($DUsers as $key => $user) {
            
        //     $details = UserDetails::where('user_id','=',$user->id)->first();           

        //     $latest = DelhiAttendence::where('user_id',$user->id)->where('year',$date->year)->where('month',5)->first();

        //     foreach ($data as $key => $value) {
        //         if(is_null($latest->$value))
        //         {
        //             $latest->$value = "P";
        //             $latest->save();
        //         } 
        //     }
        // }
        
        Log::info("done");
    }
}
