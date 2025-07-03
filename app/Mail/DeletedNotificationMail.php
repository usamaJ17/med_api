<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeletedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $name;
    public $type;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $name, $type)
    {
        $this->email = $email;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->type == 'patient') {
            return new Envelope(
                subject: 'Finish Signing Up with Deluxe Hospital  🩺',
            );
        }else if ($this->type == 'incomplete_user') {
            return new Envelope(
                subject: 'Complete Your Deluxe Hospital Registration & Start Seeing Patients Online!',
            );
        } else { // Default case for other types, e.g., 'medical'
            return new Envelope(
                subject: 'Complete Your Registration with Deluxe Hospital 🌟',
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
         if ($this->type == 'patient') {
                return new Content(
                view: 'emails.deleted_notification_patient',
            );
        }else if ($this->type == 'incomplete_user') {
            return new Content(
                view: 'emails.incomplete_user_notification',
            );
        } else { // Default case for other types, e.g., 'medical'
            return new Content(
                view: 'emails.deleted_notification',
            );
        }
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
