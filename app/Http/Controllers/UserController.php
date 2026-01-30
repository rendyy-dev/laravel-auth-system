<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAccess();

        $search = $request->search;

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

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

        $request->merge([
            'username' => strtolower(trim($request->username)),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9_-]+$/',
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
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
            'role' => ['required', 'in:admin,user'],
        ]);

        if (auth()->user()->role === 'admin' && $validated['role'] !== 'user') {
            abort(403);
        }

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
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

        $request->merge([
            'username' => strtolower(trim($request->username)),
        ]);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
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

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();

        if ($user->id === $authUser->id) {
            abort(403, 'Tidak bisa menghapus akun sendiri');
        }

        if ($authUser->role === 'admin' && $user->role !== 'user') {
            abort(403);
        }

        if ($authUser->role === 'user') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    public function trash()
    {
        $authUser = auth()->user();

        if ($authUser->role === 'super_admin') {
            $users = User::onlyTrashed()->latest()->get();
        } elseif ($authUser->role === 'admin') {
            // Admin hanya lihat user biasa
            $users = User::onlyTrashed()
                ->where('role', 'user')
                ->latest()
                ->get();
        } else {
            abort(403);
        }

        return view('users.trash', compact('users'));
    }

    public function restore($id)
    {
        $authUser = auth()->user();
        $user = User::withTrashed()->findOrFail($id);

        if ($authUser->role === 'admin' && $user->role !== 'user') {
            abort(403);
        }

        if ($authUser->role === 'user') {
            abort(403);
        }

        $user->restore();

        return back()->with('success', 'Akun berhasil dikembalikan');
    }

    public function forceDelete($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        User::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Akun telah dihapus permanen');
    }

    private function authorizeAccess()
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
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
            'is_active' => !$user->is_active,
        ]);

        return back()->with('success', 'Status user berhasil diubah');
    }
}
