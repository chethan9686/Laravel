<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Event,$CC,$UserDetails;

     public function __construct($User,$Event,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Event = $Event;
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
       return $this->markdown('user.emails.userevent')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Event',$this->Event)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails)
            ->cc($this->CC)
            ->subject($this->Event->eventname.'- Event');
    }
}
