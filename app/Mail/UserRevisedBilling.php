<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRevisedBilling extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   protected $CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup,$Path;
    public function __construct($CC,$AuthUser,$AuthUser_details,$AuthUser_Name,$SignupUser,$Signup)
    {
        $this->CC = $CC;
        $this->AuthUser = $AuthUser; 
        $this->AuthUser_details = $AuthUser_details;
        $this->AuthUser_Name = $AuthUser_Name;
        $this->SignupUser = $SignupUser;  
        $this->Signup = $Signup;
        $this->Path = asset('public/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Attachments = array();

        $BusinessSignup = BusinessSignup::find($this->Signup->signup_id);

        array_push($Attachments,$this->Path.'/'.$BusinessSignup->budget_sheet);

        if( !is_null($BusinessSignup->purchase_file) ||  !is_null($this->Signup->purchase_file))
        {
            if(is_null($this->Signup->purchase_file))
            {
                foreach($BusinessSignup->purchase_file as $file)
                {
                   array_push($Attachments,$this->Path.'/'.$file);
                }              
            }
            else
            {
                foreach($this->Signup->purchase_file as $file)
                {
                   array_push($Attachments,$this->Path.'/'.$file);
                }             
            }
        }

        if( !is_null($BusinessSignup->client_approval_file) ||  !is_null($this->Signup->client_approval_file))
        {
            if(is_null($this->Signup->client_approval_file))
            {
              array_push($Attachments,$this->Path.'/'.$BusinessSignup->client_approval_file);
            }
            else
            {
              array_push($Attachments,$this->Path.'/'.$this->Signup->client_approval_file);
            }
        }

        array_push($Attachments,$this->Path.'/'.$this->Signup->final_invoice_file);

        if($this->Signup->company_status == "new")
        {
          array_push($Attachments,$this->Path.'/'.$this->Signup->gst_certificate);
        }
        
        if(empty($this->CC))
        {
        $Result = $this->markdown('user.emails.business.user_revised_billing')  
            ->from($this->AuthUser->email , $this->AuthUser_Name) 
            ->with('AuthUser',$this->AuthUser)
            ->with('AuthUser_details',$this->AuthUser_details)
            ->with('AuthUser_Name',$this->AuthUser_Name)
            ->with('SignupUser',$this->SignupUser)
            ->with('Signup',$this->Signup)             
            ->subject($this->SignupUser->first_name.' '.$this->SignupUser->last_name.' - '."Revised Approval Billing");
            
            foreach($Attachments as $file)
            {
                $Result->attach($file);
            }
          
            return $Result;
        }
        else
        {
        $Result = $this->markdown('user.emails.business.user_revised_billing')  
            ->from($this->AuthUser->email , $this->AuthUser_Name) 
            ->with('AuthUser',$this->AuthUser)
            ->with('AuthUser_details',$this->AuthUser_details)
            ->with('AuthUser_Name',$this->AuthUser_Name)
            ->with('SignupUser',$this->SignupUser)
            ->with('Signup',$this->Signup)             
            ->cc($this->CC)   
            ->subject($this->SignupUser->first_name.' '.$this->SignupUser->last_name.' - '."Revised Approval Billing");   
            
            foreach($Attachments as $file)
            {
               $Result->attach($file);
            }
          
            return $Result;
        }
    }
}
