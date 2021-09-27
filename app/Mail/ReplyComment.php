<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyComment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $User,$Signup,$Request,$CC;
    public function __construct($User,$Signup,$Request,$CC)
    {
        $this->User = $User;
        $this->Signup = $Signup;
        $this->Request = $Request;
        $this->CC = $CC;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('user.emails.business.reply_comment')
            ->from($this->User->email, $this->User->first_name.' '.$this->User->last_name)
            ->with('User',$this->User)
            ->with('Signup',$this->Signup)
            ->with('Request',$this->Request)
            ->cc($this->CC) 
            ->subject($this->Signup->company_name.' - '.'Reply For Comment');
    }
}
