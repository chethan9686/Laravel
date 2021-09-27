<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersLeave extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Leave,$CC,$UserDetails;

    public function __construct($User,$Leave,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Leave = $Leave;
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
        return $this->markdown('user.emails.userleave')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Leave',$this->Leave)  
            ->with('User',$this->User)           
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject($this->Leave->emp_name.' - '.$this->Leave->leave_type);
    }
}
