<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\MessageBag;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        // Retrieve the user model
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors(['email' => __('User not found.')]);
        }
        $resetLink = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            [
                'email' => $request->input('email'),
                'token' => Password::createToken($user),
                // Pass the user model
            ]
        );

        $status = Mail::send('emails.resetPasswordMail', ['resetLink' => $resetLink], function (Message $message) {
            $message->subject('Forgot your password? No problem, I got you!');
            $message->to(request()->input('email'));
        });

    return $status
        ? back()->with('status', __('We have emailed your password reset link!'))
        : back()->withInput($request->only('email'))->withErrors(new MessageBag(['email' => __('Unable to send reset password link.')]));

    }
}
