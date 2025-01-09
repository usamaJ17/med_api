<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayForMeReceiptForPayeeBeneficiary extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $appointment_date;
    public $appointment_time;
    public $consultation_type;
    public $b_name;
    public $amount;
    public $transaction_id;
    public $payment_date;
    /**
     * Create a new message instance.
     */
    public function __construct($professional,$appointment_date, $appointment_time, $consultation_type, $b_name, $amount, $transaction_id, $payment_date)
    {
        $this->professional = $professional;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->consultation_type = $consultation_type;
        $this->b_name = $b_name;
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
            subject: "Exciting News: Your Appointment Receipt with ".$this->professional."!" ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patient.pay_for_me_receipt_for_beneficiary',
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