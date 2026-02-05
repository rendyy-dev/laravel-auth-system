<x-guest-layout>
    <div x-data="{ 
            show: {{ $errors->any() ? 'true' : 'false' }}, 
            password: '', 
            confirmPassword: '', 
            username: '' 
        }"
        x-init="if(show) setTimeout(() => show = false, 4000)"
    >

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

        <div class="space-y-4">

            <div class="text-center">
                <h1 class="text-lg font-semibold text-gray-100">Register</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <x-text-input 
                    name="name" 
                    type="text" 
                    class="w-full" 
                    placeholder="Name" 
                    required 
                />

                <x-text-input
                    name="username"
                    type="text"
                    class="w-full"
                    placeholder="Username"
                    required
                    x-model="username"
                    @input="username = username.replace(/\s+/g, '').toLowerCase()"
                />

                <x-text-input 
                    name="email" 
                    type="email" 
                    class="w-full" 
                    placeholder="Email" 
                    required 
                />

                <x-text-input
                    name="password"
                    type="password"
                    class="w-full"
                    placeholder="Password"
                    x-model="password"
                />

                <!-- Password Rules -->
                <div class="text-xs text-gray-300" x-show="password.length > 0" x-cloak>
                    <div :class="password.length >= 8 ? 'text-green-400' : 'text-gray-400'">• Minimal 8 karakter</div>
                    <div :class="/[A-Z]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Huruf besar</div>
                    <div :class="/[a-z]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Huruf kecil</div>
                    <div :class="/[0-9]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Angka</div>
                    <div :class="/[^A-Za-z0-9]/.test(password) ? 'text-green-400' : 'text-gray-400'">• Simbol</div>
                </div>

                <x-text-input
                    name="password_confirmation"
                    type="password"
                    class="w-full"
                    placeholder="Confirm Password"
                    x-model="confirmPassword"
                />

                <button type="submit" class="w-full bg-indigo-600 text-white rounded-lg py-2">
                    Register
                </button>

                <div class="flex justify-between text-xs text-gray-500">
                    <a href="{{ route('login') }}" class="hover:text-indigo-400">Login</a>
                    <a href="{{ url('/') }}" class="hover:text-indigo-400">← Home</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
