<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEventSetup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Setup,$CC,$UserDetails;

     public function __construct($User,$Setup,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Setup = $Setup;
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
       return $this->markdown('user.emails.userevent_setup')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Setup',$this->Setup)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails)
            ->cc($this->CC)
            ->subject($this->Setup->setup_clientname.'- Event Setup');
    }
}
