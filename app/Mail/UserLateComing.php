<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UserLateComing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $User,$punch_in,$CC;

    public function __construct($User,$punch_in,$CC)
    {
        $this->User = $User;
        $this->punch_in = $punch_in;
        $this->CC = $CC;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::parse($this->punch_in->date);
        return $this->markdown('user.emails.user_latecoming')           
                    ->with('User',$this->User)
                    ->with('punch_in',$this->punch_in)            
                    ->cc($this->CC)
                    ->subject('LateComing'.' - '.$date->format('jS F,Y'));
    }
}
