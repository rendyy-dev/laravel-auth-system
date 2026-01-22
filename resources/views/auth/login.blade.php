<x-guest-layout>
    <div class="space-y-4">

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-lg font-semibold text-gray-100">Login</h1>
        </div>

        <x-auth-session-status class="text-xs" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-3">
            @csrf

            <!-- Email / Username -->
            <div>
                <x-text-input
                    id="login"
                    class="w-full bg-gray-800 border-gray-700 text-gray-100"
                    type="text"
                    name="login"
                    placeholder="Email atau Username"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('login')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <x-text-input
                    id="password"
                    class="w-full bg-gray-800 border-gray-700 text-gray-100"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <button
                type="submit"
                class="w-full text-white bg-indigo-600 hover:bg-indigo-500 text-sm font-medium py-2.5 rounded-lg"
            >
                Login
            </button>
        </form>

        <!-- Google -->
        <a
            href="{{ route('google.login') }}"
            class="flex text-white items-center justify-center gap-3 w-full rounded-lg bg-gray-800 px-4 py-3 text-sm font-semibold hover:bg-gray-700 transition"
        >
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.5 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.6-.4-3.9z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 16 19 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.3 35.6 26.8 36 24 36c-5.3 0-9.7-3.5-11.3-8.3l-6.5 5C9.6 39.5 16.3 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.3-2.3 4.3-4.3 5.5l6.3 5.3C35.9 41.5 44 36 44 24c0-1.3-.1-2.6-.4-3.9z"/>
            </svg>
            Login with Google
        </a>

        <!-- Links -->
        <div class="flex justify-between text-xs text-gray-500">
            <p class="flex ">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="hover:text-indigo-400">Register</a>
        </div>
    </div>
</x-guest-layout>
