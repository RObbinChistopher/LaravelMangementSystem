<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageContent;

    public function __construct($subject, $messageContent)
    {
        $this->subject = $subject; // Assign the subject passed to the constructor
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        // Use the passed subject in the email
        return $this->subject($this->subject)
            ->view('emails.template')
            ->with([
                'messageContent' => $this->messageContent,
            ]);
    }
}
