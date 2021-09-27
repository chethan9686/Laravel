<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDismantle extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Dismantle,$CC,$UserDetails;

     public function __construct($User,$Dismantle,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Dismantle = $Dismantle;
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
       return $this->markdown('user.emails.userdismantle')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Dismantle',$this->Dismantle) 
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject($this->Dismantle->dis_clientname.' - Dismantle');
    }
}
