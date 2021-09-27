<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAdditionalSignup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     protected $User,$CC,$Signup;

    public function __construct($User,$CC,$Signup)
    {
        $this->User = $User;       
        $this->CC = $CC;
        $this->Signup = $Signup;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.business.user_additional_signup')   
            ->with('User',$this->User)
            ->with('Signup',$this->Signup) 
            ->cc($this->CC)
            ->subject($this->User->first_name.' '.$this->User->last_name.' - '."Additional Signup");
    }
}
