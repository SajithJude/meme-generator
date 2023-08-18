<?php

namespace App\Listeners;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class CustomSendEmailVerificationNotification extends SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $this->sendCustomEmailVerificationNotification($event->user);
        }
    }

    /**
     * Send the custom email verification notification.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function sendCustomEmailVerificationNotification($user)
    {
        $verificationUrl = $this->getEmailVerificationUrl($user);
        Mail::send('emails.verifyEmail', ['url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify Email Address');
        });
    }

    /**
     * Get the email verification URL for the given user.
     *
     * @param  mixed  $user
     * @return string
     */
    protected function getEmailVerificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }
}
