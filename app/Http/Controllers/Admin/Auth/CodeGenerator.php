<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailCode;
use App\Models\Admin;
use App\Models\UserIPCode;
use Exception;
use Illuminate\Support\Facades\Mail;

class CodeGenerator extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Generate a new code for the given user and IP address.
     *
     * @param  \App\Models\Admin  $user
     * @param  string  $ipAddress
     * @return void
     */
    public static function generateCode(Admin $user, $ipAddress)
    {
        $code = rand(1000, 9999);

        $userIPCode = UserIPCode::where('user_id', $user->id)->where('ip_address', $ipAddress)->first();
        if ($userIPCode) {
            $userIPCode->code = $code;
            $userIPCode->expires_at = now()->addMonth();
            $userIPCode->verified = false;
            $userIPCode->save();
        } else {
            UserIPCode::create([
                'user_id' => $user->id,
                'ip_address' => $ipAddress,
                'code' => $code,
                'expires_at' => now()->addMonth(),
            ]);
        }

        try {
            $details = [
                'title' => 'OTP from Speak2Impact',
                'code' => $code
            ];

            Mail::to($user->email)->send(new SendEmailCode($details));
        } catch (Exception $e) {
            info("Error: " . $e->getMessage());
        }
    }
}
