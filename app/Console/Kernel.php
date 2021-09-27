<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MonthlyEmployees::class,
        Commands\UpdateMeetingAttendence::class,
        Commands\MoMReminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Monthly:Employees')->monthlyOn(1, '01:00');
        $schedule->command('Update:Meeting')->twiceDaily(12, 21);
        $schedule->command('MOM:Reminder')->hourly();
        $schedule->command('Daily:Wishes')->dailyAt('02:00');
       // $schedule->command('Update:Attendence')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
