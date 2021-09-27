<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserReworkBilling extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup;
    public function __construct($CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup)
    {
        $this->CC = $CC;
        $this->AuthUser = $AuthUser; 
        $this->AuthUser_details = $AuthUser_details;
        $this->AuthUser_Name = $AuthUser_Name;
        $this->SignupUser = $SignupUser;  
        $this->Signup = $Signup;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.business.user_rework_billing')  
            ->from($this->AuthUser->email , $this->AuthUser_Name) 
            ->with('AuthUser',$this->AuthUser)
            ->with('AuthUser_details',$this->AuthUser_details)
            ->with('AuthUser_Name',$this->AuthUser_Name)
            ->with('SignupUser',$this->SignupUser)
            ->with('Signup',$this->Signup)   
            ->cc($this->CC) 
            ->subject($this->SignupUser->first_name.' '.$this->SignupUser->last_name.' - '."Rework Billing");
    }
}
