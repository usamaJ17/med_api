<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayForMeReceiptForPayee extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $appointment_date;
    public $appointment_time;
    public $consultation_type;
    public $p_name;
    public $b_name;
    public $amount;
    /**
     * Create a new message instance.
     */
    public function __construct($professional,$appointment_date, $appointment_time, $consultation_type, $p_name, $b_name, $amount)
    {
        $this->professional = $professional;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->consultation_type = $consultation_type;
        $this->p_name = $p_name;
        $this->b_name = $b_name;
        $this->amount = $amount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Exciting News: Appointment Successfully Booked and Paid For!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.pay_for_me_receipt_for_payee',
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
