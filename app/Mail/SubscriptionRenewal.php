<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewal extends Mailable
{
    use Queueable, SerializesModels;

    private $payload;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Summary of build
     * @return SubscriptionRenewal
     */
    public function build()
    {
        return $this->subject('Subscription Renewal Notification')->view('emails.subscriptionRenewal', ['payload' => $this->payload]);
    }
}
