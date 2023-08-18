<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Listeners\SendEmailCode;
use App\Models\Admin;
use App\Models\UserEmailCode;
use App\Models\UserIPCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TwoFAController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('admin.auth.2fa');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = Admin::where('email', $request['email'])->first();
        $ipAddress = request()->ip();
        if ($this->isCodeValidForIp($request->code, $ipAddress, $user)) {
            $userIpcode = UserIPCode::where('user_id', $user->id)->where('ip_address', $ipAddress)->first();
            if ($userIpcode) {
                $userIpcode->verified = true;
                $userIpcode->save();
            } else {
                return back()->with('error', 'Either you entered the wrong code, your code has expired, or your IP address is not allowed.');

            }
            $user->last_login_2fa = now();
            $user->last_login_ip = $ipAddress;
            $user->save();
            Session::put('user_2fa', $user->id);
            Auth::guard('admin')->login($user);
            return redirect()->intended(route('admin.index'));
        }

        throw ValidationException::withMessages([
            'identity' => trans('auth.failed'),
        ]);

        return back()->with('error', 'Either you entered the wrong code, your code has expired, or your IP address is not allowed.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function resend(Request $request)
    {
        $user = Admin::where('email', $request['email'])->first();
        $ipAddress = request()->ip();

        CodeGenerator::generateCode($user, $ipAddress);
        return back()->with('success', 'We re-sent to code on your email.');
    }

    /**
     * Check if the 2FA code has expired.
     *
     * @param  \App\Models\Admin  $user
     * @return bool
     */
    protected function is2FAExpired(Admin $user)
    {
        $userIpcode = UserIPCode::where('user_id', $user->id)->where('ip_address', request()->ip())->where('verified', 1)->first();
        if ($userIpcode) {
            $rememberedTime = $userIpcode->expires_at->subMonths(1);

        } else {
            return true;
        }
        return now()->diffInDays($rememberedTime) >= 30;
    }

    /**
     * Show the 2FA form.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Http\Response
     */
    protected function show2FAForm(Admin $user)
    {
        // Reset the last login 2FA time
        $user->last_login_2fa = now();
        $user->save();

        return view('2fa');
    }

    /**
     * Check if the code is valid for the given IP address.
     *
     * @param  string  $code
     * @param  string  $ipAddress
     * @param  \App\Models\Admin  $user
     * @return bool
     */
    protected function isCodeValidForIp($code, $ipAddress, Admin $user)
    {
        $ipCodes = UserIPCode::where('user_id', $user->id)
            ->where('ip_address', $ipAddress)
            ->where('code', $code)
            ->where('expires_at', '>=', now()->subMinutes(5))
            ->toSql();

        return !is_null($ipCodes);
    }
}
