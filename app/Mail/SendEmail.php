<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(! $this->details['email-attachments'] == ''){
            return $this->subject($this->details['title'])->attach($this->details['email-attachments'])->view('layouts.email.sendemail');
        }

        return $this->subject($this->details['title'])->view('layouts.email.sendemail');
        
    }
}
