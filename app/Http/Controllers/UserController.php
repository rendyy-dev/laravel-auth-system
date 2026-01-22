<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAccess();

        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

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
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/[a-z]/',       // huruf kecil
                    'regex:/[A-Z]/',       // huruf besar
                    'regex:/[0-9]/',       // angka
                    'regex:/[^A-Za-z0-9]/' // simbol
                ],

                'role' => ['required', 'in:admin,user'],
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.regex' =>
                    'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ]
        );

        if (auth()->user()->role === 'admin' && $request->role !== 'user') {
            abort(403);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $this->authorizeAccess();

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAccess();

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            abort(403);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $user->id,
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'password' => [
                'nullable',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ];

        if (auth()->user()->role === 'super_admin') {
            $rules['role'] = ['required', 'in:admin,user'];
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (auth()->user()->role === 'super_admin') {
            $data['role'] = $validated['role'];
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
  
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            abort(403, 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }

    private function authorizeAccess()
    {
        if (! in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403);
        }
    }

    public function toggleActive(User $user)
    {
        $this->authorizeAccess();
        
        if (auth()->user()->role === 'admin' && $user->role === 'super_admin') {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            abort(403);
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return back()->with('success', 'Status user berhasil diubah');
    }
}
