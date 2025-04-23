<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BuyerInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $buyerName;
    public $buyerEmail;
    public $buyerPhone;
    public $buyerMessage;

    public function __construct($buyerName, $buyerEmail, $buyerPhone, $buyerMessage)
    {
        $this->buyerName = $buyerName;
        $this->buyerEmail = $buyerEmail;
        $this->buyerPhone = $buyerPhone;
        $this->buyerMessage = $buyerMessage;
    }

    public function build()
    {
        return $this->subject('New Inquiry from ' . $this->buyerName)
                    ->view('buyer-inquiry');
    }
}
