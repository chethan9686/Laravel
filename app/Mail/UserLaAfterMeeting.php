<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLaAfterMeeting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Date,$CC;
    public function __construct($User,$Date,$CC)
    {
        $this->User = $User;
        $this->Date = $Date;
        $this->CC = $CC;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.user_latearrivalaftermeeting')           
                    ->with('User',$this->User)
                    ->with('Date',$this->Date)            
                    ->cc($this->CC)
                    ->subject('Late Arrival After The Meeting');
    }
}
