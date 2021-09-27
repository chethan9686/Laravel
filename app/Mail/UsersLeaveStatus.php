<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersLeaveStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Leave,$CC,$UserHead,$UserDetails;

    public function __construct($User,$Leave,$CC,$UserHead,$UserDetails)
    {
        $this->User = $User;
        $this->Leave = $Leave;
        $this->CC = $CC;       
        $this->UserHead = $UserHead; 
        $this->UserDetails = $UserDetails; 
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.userleave_status')
            ->from($this->User->email , $this->UserHead)
            ->with('User',$this->User)
            ->with('Leave',$this->Leave)  
            ->with('UserDetails',$this->UserDetails) 
            ->cc($this->CC)
            ->subject('Leave Status');
    }
}
