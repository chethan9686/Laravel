<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $Signup,$Res;
    public function __construct($Signup)
    {
        $this->Signup = $Signup;
        //$this->Res = asset('public/'.$this->Signup->budget_sheet);
        $this->Res = asset('public/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Files = array();
        if(!is_null($this->Signup->budget_sheet))
        {
            $Sheet = $this->Res.'/'.$this->Signup->budget_sheet;
            array_push($Files,$Sheet);
           
        }
        if(!is_null($this->Signup->client_approval_file))
        {
            $File = $this->Res.'/'.$this->Signup->client_approval_file;
            array_push($Files,$File);
        }
        
        $Result  = $this->markdown('user.emails.business.user_mail_test')  
                ->with('Signup',$this->Signup);
        
        foreach($Files as $file)
        {
             $Result->attach($file);
        }
        
        return $Result;
                
    }
}
