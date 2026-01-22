<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
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
        }

        if (! $user->isActive()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun kamu dinonaktifkan oleh Admin.',
            ]);
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
