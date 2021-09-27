<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutOfStation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Latest,$CC,$UserName,$UserDetails;

    public function __construct($User,$Latest,$CC,$UserDetails)
    {
        $this->User = $User;
        $this->Latest = $Latest;
        $this->CC = $CC;
        $this->UserName = $User->first_name .' '.$User->last_name;
        $this->UserDetails = $UserDetails; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.out_ofstation')
            ->from($this->User->email, $this->UserName)
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails) 
            ->with('Latest',$this->Latest)  
            ->cc($this->CC)
            ->subject($this->UserName.' - '.'Out Of Station');
    }
}
