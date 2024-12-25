<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AfterBookingCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment_date;
    public $appointment_time;
    public $p_name;
    public $name;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $appointment_date, $appointment_time,  $p_name)
    {
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->p_name = $p_name;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Appointment Cancellation Notification",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professional.appointment_cancel',
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
