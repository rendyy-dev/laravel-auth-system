<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($request->hasFile('avatar')) {
            \Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')?->store('avatars', 'public');

        $user->avatar = $path;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        abort(403, 'Eitss jangan coba coba hapus akun yaa.');
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password'],
        // ]);

        // $user = $request->user();

        // Auth::logout();

        // $user->delete();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        // return Redirect::to('/');
    }

    // 🔥 GOOGLE USER ONLY
    public function complete(): View
    {
        $user = auth()->user();

        if ($user->profile_complete || ! $user->google_id) {
            return redirect()->route('dashboard');
        }

        return view('profile.complete');
    }

    public function storeComplete(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:users,username',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'profile_complete' => true,
        ]);

        return redirect()->route('dashboard');
    }
}
