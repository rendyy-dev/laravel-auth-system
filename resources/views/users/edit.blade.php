<x-app-layout>
    <div x-data="{ show: {{ $errors->any() ? 'true' : 'false' }}, password: '', confirmPassword: '' }"
         x-init="if(show) setTimeout(() => show = false, 4000)">

        <!-- Popup Error -->
        <div x-show="show" x-transition class="fixed inset-0 flex items-center justify-center bg-black/30 z-50">
            <div class="bg-gray-900 text-white p-4 rounded-lg shadow-lg max-w-sm w-full">
                <div class="flex justify-between items-start gap-3">
                    <div>
                        <h3 class="font-semibold">Error</h3>
                        <p class="text-sm mt-1">{{ $errors->first() }}</p>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-white">✕</button>
                </div>
            </div>
        </div>

        <div class="max-w-xl mx-auto space-y-6">

            <h1 class="text-2xl font-semibold">Edit User</h1>

            <form action="{{ route('users.update', $user) }}" method="POST"
                  class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
                @csrf
                @method('PUT')

                <input name="name" value="{{ old('name', $user->name) }}" placeholder="Name"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />

                <input name="username" value="{{ old('username', $user->username) }}" placeholder="Username"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
                <x-input-error :messages="$errors->get('username')" class="mt-1" />

                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />

                <input id="password" type="password" name="password"
                       placeholder="New Password (optional)"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                       x-model="password">

                <input id="password_confirmation" type="password" name="password_confirmation"
                       placeholder="Confirm New Password"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                       x-model="confirmPassword">

                <!-- Rules (show only if password typed) -->
                <div class="text-xs space-y-1" x-show="password.length > 0" x-cloak>
                    <p :class="password.length >= 8 ? 'text-green-400' : 'text-gray-400'">• Minimal 8 karakter</p>
                    <p :class="/[A-Z]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Huruf besar</p>
                    <p :class="/[a-z]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Huruf kecil</p>
                    <p :class="/[0-9]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Angka</p>
                    <p :class="/[^A-Za-z0-9]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Simbol</p>
                    <p :class="password === confirmPassword ? 'text-green-400' : 'text-gray-400'">• Password cocok</p>
                </div>

                @if(auth()->user()->role === 'super_admin')
                    <select name="role" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                @endif

                <div class="flex justify-end gap-2">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
