<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Controllers\Admin\Auth\CodeGenerator;
use App\Listeners\SendEmailCode;
use App\Models\Admin;
use App\Models\UserEmailCode;
use App\Models\UserIPCode;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Determine login column name based on input (username or email)
     *
     * @return string
     */
    public function identity()
    {
        return filter_var($this->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::guard('admin')->validate([$this->identity() => $this->string('identity'), 'password' => $this->string('password')], false)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identity' => trans('auth.failed'),
            ]);
        }

        $user = Admin::where($this->identity(), $this->string('identity'))->first();
        RateLimiter::clear($this->throttleKey());

        if ($this->is2FAExpired($user)) {
            $ipAddress = request()->ip();

            CodeGenerator::generateCode($user, $ipAddress);
            return true;
        } else {
            Auth::guard('admin')->login($user);
            return false;
        }
    }

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
     * Write code on Method
     *
     * @return response()
     */
    public function generateCode($user)
    {
        $code = rand(1000, 9999);
        UserEmailCode::updateOrCreate(
            ['user_id' => $user->id],
            ['code' => $code]
        );
        try {
            $details = [
                'title' => 'Mail Sent from Speak2Impact',
                'code' => $code
            ];
            Mail::to($user->email)->send(new SendEmailCode($details));
        } catch (Exception $e) {
            info("Error: " . $e->getMessage());
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identity' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('identity')) . '|' . $this->ip();
    }
}
