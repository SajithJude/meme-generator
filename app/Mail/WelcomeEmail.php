<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    // private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->user = $data;
    }

    public function build()
    {
        return $this->subject('Welcome to the Speak2Impact Academy: Onboarding')->view('emails.welcome');
    }
}
