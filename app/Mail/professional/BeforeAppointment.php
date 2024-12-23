<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $name;
    public $p_name;
    public $age;
    public $appointment_date;
    public $appointment_time;
    public $time;
    /**
     * Create a new message instance.
     */
    public function __construct($professional, $name, $p_name, $age, $appointment_dat, $appointment_time, $time)
    {
        $this->professional = $professional;
        $this->name = $name;
        $this->p_name = $p_name;
        $this->age = $age;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Friendly Reminder - Get Ready to Make a Difference in ".$this->time."!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professional.before_appointment',
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
