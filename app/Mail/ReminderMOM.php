<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMOM extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $Meeting,$CC,$Calulation;
    public function __construct($Meeting,$CC,$Calulation)
    {
        $this->Meeting = $Meeting;
        $this->CC = $CC;
        $this->Calulation = $Calulation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->markdown('user.emails.mom_reminder')           
                    ->with('Meeting',$this->Meeting)
                    ->with('Calulation',$this->Calulation)            
                    ->cc($this->CC)
                    ->subject($this->Meeting->company_name.' - '.'MOM Reminder');
    }
}
