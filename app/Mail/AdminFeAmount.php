<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminFeAmount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    Protected $Auth,$User,$Month;

    public function __construct($Auth,$User,$Month)
    {
        $this->Auth = $Auth;
        $this->User = $User;
        $this->Month = $Month;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->Month == "Agust")
        {
            $this->Month == "August";
        }
        return $this->markdown('admin.emails.admin_feamount')
            ->from($this->Auth->email, $this->Auth->name)   
            ->with('Auth',$this->Auth)         
            ->with('User',$this->User)  
            ->with('Month',$this->Month)            
            ->subject($this->Month.' - '."FE Amount");
    }
}
