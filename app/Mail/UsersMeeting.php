<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersMeeting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   protected $User,$Meeting,$CC,$UserDetails;

    public function __construct($User,$Meeting,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Meeting = $Meeting;
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
       return $this->markdown('user.emails.usermeeting')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Meeting',$this->Meeting)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject($this->Meeting->company_name.' - Meeting');
    }
}
