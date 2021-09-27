<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $Confirmation,$FirstName,$LastName,$Phone,$Branch,$Position;

    public function __construct($Confirmation,$FirstName,$LastName,$Phone,$Branch,$Position)
    {
        $this->Confirmation = $Confirmation;
        $this->FirstName = $FirstName;
        $this->LastName =$LastName;
        $this->Phone = $Phone;
        $this->Branch = $Branch;
        $this->Position = $Position;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admin.emails.registerverification')
            ->with('Confirmation',$this->Confirmation)
            ->with('FirstName',$this->FirstName)
            ->with('LastName',$this->LastName)
            ->with('Phone',$this->Phone)
            ->with('Branch',$this->Branch)
            ->with('Position',$this->Position)
            ->subject('Welcome to Wings! Confirm Your Email');
    }
}
