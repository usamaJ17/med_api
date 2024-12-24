<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $appointment_date;
    public $appointment_time;
    public $consultation_type;
    public $name;
    public $amount;
    public $transaction_id;
    public $payment_date;
    /**
     * Create a new message instance.
     */
    public function __construct($professional,$appointment_date, $appointment_time, $consultation_type, $name, $amount, $transaction_id, $payment_date)
    {
        $this->professional = $professional;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->consultation_type = $consultation_type;
        $this->name = $name;
        $this->amount = $amount;
        $this->transaction_id = $transaction_id;
        $this->payment_date = $payment_date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Appointment is Booked! Payment Receipt Inside",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.payment_receipt',
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
