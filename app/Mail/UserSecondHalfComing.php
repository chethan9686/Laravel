<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UserSecondHalfComing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$punch_in,$CC,$Var;
    public function __construct($User,$punch_in,$CC,$Var)
    {
        $this->User = $User;
        $this->punch_in = $punch_in;
        $this->CC = $CC;
        $this->Var = $Var;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::parse($this->punch_in->date);
        return $this->markdown('user.emails.user_secondhalfcoming')           
                    ->with('User',$this->User)
                    ->with('punch_in',$this->punch_in)   
                    ->with('date',$date)   
                    ->with('Var',$this->Var)         
                    ->cc($this->CC)
                    ->subject('Late Arrival'.' - '.'Full Day');
    }
}
