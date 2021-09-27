<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ReviewClientMoM extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Client,$CC,$UserDetails,$BCC;

    public function __construct($User,$Client,$CC,$UserDetails,$BCC)
    { 
        $this->User = $User;
        $this->Client = $Client;
        $this->CC = $CC;
        $this->UserDetails = $UserDetails; 
        $this->BCC = $BCC;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {     
        $date = Carbon::parse($this->Client->date);    
        if(empty($this->BCC))
        {
            return $this->markdown('user.emails.review_clientmom')
                        ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
                        ->with('Client',$this->Client)  
                        ->with('User',$this->User)
                        ->with('UserDetails',$this->UserDetails) 
                        ->cc($this->CC)
                        ->subject('Minutes Of Meeting'.' - '.$date->format('d-m-Y'));
        }
        else{
            return $this->markdown('user.emails.review_clientmom')
                        ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
                        ->with('Client',$this->Client)  
                        ->with('User',$this->User)
                        ->with('UserDetails',$this->UserDetails) 
                        ->cc($this->CC)
                        ->bcc($this->BCC)
                        ->subject('Minutes Of Meeting'.' - '.$date->format('d-m-Y'));
        }       
    }
}
