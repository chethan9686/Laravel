<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRevised extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Businessrevision,$CC,$UserDetails;

    public function __construct($User,$Businessrevision,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Businessrevision = $Businessrevision;
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
       return $this->markdown('user.emails.business.user_revised')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Businessrevision',$this->Businessrevision)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject($this->User->first_name.' '.$this->User->last_name.' - '.' - Revised Signup');
    }
}
