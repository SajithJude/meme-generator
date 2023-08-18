<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCourseOpenEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->subject('Two new courses unlocked on the Speak2Impact Academy')->view('emails.newCourseOpenMail');
    }
}
