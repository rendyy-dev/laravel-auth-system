<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:users,username',
                ],

                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    'min:8',

                    // huruf kecil
                    'regex:/[a-z]/',

                    // huruf besar
                    'regex:/[A-Z]/',

                    // angka
                    'regex:/[0-9]/',

                    // simbol
                    'regex:/[^A-Za-z0-9]/',
                ],
            ],
            [
                // username
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',

                // email
                'email.unique' => 'Email sudah terdaftar.',

                // password
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.regex' =>
                    'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
