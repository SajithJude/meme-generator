<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a class="navbar-brand" href="#">
                <h3 class="brand-text">Speak2Impact</h3>
            </a>
            <a href="/"></a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-otp-validation-errors  class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('2fa.store') }}">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}">
            <!-- CODE -->
            <div>
                <x-label for="code" :value="__('Enter OTP code sent to your email: ') . request()->email" />
                <x-input id="code" class="block mt-1 w-full @error('code') is-invalid @enderror" type="text" name="code" :value="old('code')" required autofocus />
                @error('code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="flex items-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('2fa.resend', ['email' => request()->email]) }}">
                    {{ __('Resend Code?') }}
                </a>

                <x-button class="ml-3">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
