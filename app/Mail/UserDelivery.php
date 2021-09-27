<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDelivery extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Delivery,$CC,$UserDetails;

     public function __construct($User,$Delivery,$CC,$UserDetails)
    { 
        $this->User = $User;
        $this->Delivery = $Delivery;
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
       return $this->markdown('user.emails.userdelivery')
            ->from($this->User->email , $this->User->first_name.' '.$this->User->last_name)            
            ->with('Delivery',$this->Delivery)  
            ->with('User',$this->User)
            ->with('UserDetails',$this->UserDetails)
            ->cc($this->CC)
            ->subject($this->Delivery->delry_clientname.'- Delivery');
    }
}
