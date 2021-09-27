<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBilling extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$CC,$Signup,$Businessbilling;

    public function __construct($User,$CC,$Signup,$Businessbilling)
    {
        $this->User = $User;       
        $this->CC = $CC;
        $this->Signup = $Signup;
        $this->Businessbilling = $Businessbilling;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.business.user_billing')   
            ->with('User',$this->User)
            ->with('Signup',$this->Signup) 
            ->with('Businessbilling',$this->Businessbilling) 
            ->cc($this->CC)
            ->subject($this->User->first_name.' '.$this->User->last_name.' - '."Billing");
    }

}
