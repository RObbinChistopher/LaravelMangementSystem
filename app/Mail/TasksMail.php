<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TasksMail extends Mailable
{
    use Queueable, SerializesModels;
    public $task;
    /**
     * Create a new message instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tasks Mail From (Vise Tech)',
        );
    }

    public function build()
    {
        return $this->subject('Task Notification')
                    ->view('pdf.email_pdf') // Specify the view file for the email content
                    ->with('task', $this->task); // Pass task data to the view
    }
}
