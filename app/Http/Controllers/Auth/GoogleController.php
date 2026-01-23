<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        $request->validate(
            [
                'g-recaptcha-response' => 'required',
            ],
            [
                'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA dulu.',
            ]
        );

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (! $response->json('success')) {
            return back()->withErrors([
                'captcha' => 'Captcha tidak valid, silakan coba lagi.',
            ]);
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'username' => $this->generateUsername($googleUser->getEmail()),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => null,
                'email_verified_at' => null,
                'profile_complete' => false,
                'is_active' => true,
            ]);

            event(new Registered($user));

            \Illuminate\Support\Facades\Notification::route('mail', env('ADMIN_EMAIL'))
                ->notify(new \App\Notifications\NewGoogleUserJoined($user));
        }

        if (! $user->isActive()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun kamu dinonaktifkan oleh Admin.',
            ]);
        }
        if (!$user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->route('verification.notice');
        }

        Auth::login($user, true);

        if (! $user->profile_complete) {
            return redirect()->route('profile_complete');
        }

        return redirect()->route('dashboard');
    }

    private function generateUsername(string $email): string
    {
        $base = Str::before($email, '@');
        $username = $base;

        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }
}
