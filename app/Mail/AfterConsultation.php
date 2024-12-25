<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AfterConsultation extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $p_name;
    public $appointment_date;
    public $appointment_time;
    public $amount;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $appointment_date, $appointment_time, $amount, $p_name)
    {
        $this->name = $name;
        $this->p_name = $p_name;
        $this->amount = $amount;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Payment is Ready for Withdrawal!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professional.after_consultation',
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
