<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientUploadsTestResult extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $p_name;
    public $submission_date;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $p_name, $submission_date)
    {
        $this->name = $name;
        $this->p_name = $p_name;
        $this->submission_date = $submission_date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Test Results Submitted by Your Client",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professional.patient_uploads_test_result',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
