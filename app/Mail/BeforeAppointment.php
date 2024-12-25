<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BeforeAppointment extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $appointment_date;
    public $appointment_time;
    public $consultation_type;
    public $name;
    public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct($professional,$appointment_date, $appointment_time, $consultation_type, $name, $subject)
    {
        $this->professional = $professional;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->consultation_type = $consultation_type;
        $this->name = $name;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:  $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.before_appointment',
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
