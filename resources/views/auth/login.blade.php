<x-guest-layout>

    <!-- Popup khusus login manual -->
    <div
        x-data="{ show: {{ $errors->has('login') ? 'true' : 'false' }} }"
        x-init="if (show) setTimeout(() => show = false, 4000)"
    >
        <div
            x-show="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30"
        >
            <div class="w-full max-w-sm rounded-lg bg-gray-900 p-4 text-white shadow-lg">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-semibold">Login Gagal</h3>
                        <p class="mt-1 text-sm">
                            {{ $errors->first('login') }}
                        </p>
                    </div>
                    <button @click="show = false">✕</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="space-y-6">

        <h1 class="text-center text-lg font-semibold text-gray-100">
            Login
        </h1>

        <!-- Login Manual -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-text-input
                name="login"
                placeholder="Email atau Username"
                required
                autofocus
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
            />
            <x-input-error :messages="$errors->get('login')" />

            <!-- Password dengan toggle show/hide -->
            <div x-data="{ show: false }" class="relative">
                <input
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="Password"
                    required
                    class="w-full bg-gray-800 border-gray-700 text-gray-100 pr-10"
                />
                <x-input-error :messages="$errors->get('password')" />

                <button
                    type="button"
                    @click="show = !show"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200"
                >
                    <span x-show="!show">👁️</span>
                    <span x-show="show">🙈</span>
                </button>
            </div>

            <!-- reCaptcha untuk login manual -->
            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            <x-input-error :messages="$errors->get('g-recaptcha-response')" />

            <button class="w-full rounded-lg bg-indigo-600 py-2.5 text-white">
                Login
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center gap-3 text-xs text-gray-400">
            <div class="flex-1 h-px bg-gray-700"></div>
            atau
            <div class="flex-1 h-px bg-gray-700"></div>
        </div>

        <!-- Google Login (bebas reCaptcha) -->
        <form method="GET" action="{{ route('google.login') }}" class="space-y-3">
            <button
                type="submit"
                class="flex w-full items-center justify-center gap-3 rounded-lg bg-gray-800 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700"
            >
                <!-- icon -->
                Login dengan Google
            </button>
        </form>

        <div class="flex justify-between text-xs text-gray-500">
            <span>Belum punya akun?</span>
            <a href="{{ route('register') }}" class="hover:text-indigo-400">
                Register
            </a>
        </div>

    </div>

    <!-- reCaptcha script hanya untuk login manual -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</x-guest-layout>
