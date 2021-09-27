<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LateWorking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$LateWorking,$CC,$UserDetails;

    public function __construct($User,$LateWorking,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->LateWorking = $LateWorking;
        $this->CC = $CC;
        $this->UserDetails = $UserDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->markdown('user.emails.user_lateworking')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('LateWorking',$this->LateWorking)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject($this->User->first_name.' '.$this->User->last_name.' - '."LateWorking");
    }
}
