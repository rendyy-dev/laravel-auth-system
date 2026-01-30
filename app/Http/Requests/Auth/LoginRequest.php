<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Rules untuk login manual
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required'], // wajib diisi
        ];
    }

    /**
     * Pesan error bahasa Indonesia
     */
    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA terlebih dahulu.',
        ];
    }

    /**
     * Proses autentikasi
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // ✅ Validasi reCaptcha manual
        $this->validateRecaptcha();

        $login = $this->input('login');

        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $login, 'password' => $this->password]
            : ['username' => $login, 'password' => $this->password];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('Email / Username atau password salah.'),
            ]);
        }

        if (! auth()->user()->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'login' => 'Akun kamu sedang dinonaktifkan oleh admin.'
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Mengecek limit login
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Key untuk rate limiter
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->input('login')) . '|' . $this->ip()
        );
    }

    /**
     * Validasi reCaptcha manual ke Google
     */
    protected function validateRecaptcha(): void
    {
        $token = $this->input('g-recaptcha-response');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => $this->ip(),
        ]);

        if (! $response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Captcha tidak valid, silakan coba lagi.'
            ]);
        }
    }
}
