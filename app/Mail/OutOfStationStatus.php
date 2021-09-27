<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutOfStationStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$OutStation,$CC,$UserHead,$UserDetails;

    public function __construct($User,$OutStation,$CC,$UserHead,$UserDetails)
    {
        $this->User = $User;
        $this->OutStation = $OutStation;
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
        return $this->markdown('user.emails.out_ofstation_status')
            ->from($this->User->email, $this->UserHead)
            ->with('User',$this->User)
            ->with('OutStation',$this->OutStation)
            ->with('UserDetails',$this->UserDetails)   
            ->cc($this->CC)
            ->subject('Status On Out Of Station');
    }
}
