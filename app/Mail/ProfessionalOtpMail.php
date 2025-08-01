<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ProfessionalOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $verification_url;
    public $name;
    public $register;
    /**
     * Create a new message instance.
     */
    public function __construct($otp,$verification_url,$name,$register=false)
    {
        $this->otp = $otp;
        $this->verification_url = $verification_url;
        $this->name = $name;
        $this->register = $register;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('otp@deluxehospital.com', 'Deluxe Hospital'),
            subject: 'Welcome to Deluxe Hospital! Verify Your Email to Begin Your Exciting Journey!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.professional.professional_otp',
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
