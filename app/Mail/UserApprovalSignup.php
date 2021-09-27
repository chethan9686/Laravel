<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserApprovalSignup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup,$Billing;
    public function __construct($CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup,$Billing)
    {
        $this->CC = $CC;
        $this->AuthUser = $AuthUser; 
        $this->AuthUser_details = $AuthUser_details;
        $this->AuthUser_Name = $AuthUser_Name;
        $this->SignupUser = $SignupUser;  
        $this->Signup = $Signup;
        $this->Billing = $Billing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(empty($this->CC) && empty($this->Billing))
        {
            return $this->markdown('user.emails.business.user_approval_signup')  
            ->from($this->AuthUser->email , $this->AuthUser_Name) 
            ->with('AuthUser',$this->AuthUser)
            ->with('AuthUser_details',$this->AuthUser_details)
            ->with('AuthUser_Name',$this->AuthUser_Name)
            ->with('SignupUser',$this->SignupUser)
            ->with('Signup',$this->Signup)             
            ->subject($this->SignupUser->first_name.' '.$this->SignupUser->last_name.' - '."Approval Signup");
        }
        else
        {
            return $this->markdown('user.emails.business.user_approval_signup')  
            ->from($this->AuthUser->email , $this->AuthUser_Name) 
            ->with('AuthUser',$this->AuthUser)
            ->with('AuthUser_details',$this->AuthUser_details)
            ->with('AuthUser_Name',$this->AuthUser_Name)
            ->with('SignupUser',$this->SignupUser)
            ->with('Signup',$this->Signup)       
            ->with('Billing',$this->Billing)
            ->cc($this->CC)     
            ->subject($this->SignupUser->first_name.' '.$this->SignupUser->last_name.' - '."Approval Signup");
        }
    }
}
