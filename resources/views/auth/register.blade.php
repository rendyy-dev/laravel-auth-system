<x-guest-layout>
    <div class="space-y-4">

        <div class="text-center">
            <h1 class="text-lg font-semibold text-gray-100">Register</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-lg p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="registerForm"
              method="POST"
              action="{{ route('register') }}"
              class="space-y-3">
            @csrf

            <x-text-input
                name="name"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Name"
                value="{{ old('name') }}"
                required
                autofocus
            />

            <x-text-input
                name="username"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Username"
                value="{{ old('username') }}"
                required
            />

            <x-text-input
                name="email"
                type="email"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Email"
                value="{{ old('email') }}"
                required
            />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Password"
                required
            />

            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Confirm Password"
                required
            />

            <div class="text-xs space-y-1" id="passwordRules">
                <p id="rule-length" class="text-red-400">• Minimal 8 karakter</p>
                <p id="rule-upper" class="text-red-400">• Mengandung huruf besar</p>
                <p id="rule-lower" class="text-red-400">• Mengandung huruf kecil</p>
                <p id="rule-number" class="text-red-400">• Mengandung angka</p>
                <p id="rule-symbol" class="text-red-400">• Mengandung simbol</p>
                <p id="rule-match" class="text-red-400">• Password cocok</p>
            </div>

            <button
                id="submitBtn"
                type="submit"
                disabled
                class="w-full text-white bg-indigo-600 hover:bg-indigo-500
                       text-sm font-medium py-2.5 rounded-lg
                       disabled:opacity-50 disabled:cursor-not-allowed">
                Register
            </button>
        </form>

        <!-- Links -->
        <div class="flex justify-between text-xs text-gray-500">
            <a href="{{ route('login') }}" class="hover:text-indigo-400">Login</a>
            <a href="{{ url('/') }}" class="hover:text-indigo-400">← Home</a>
        </div>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('submitBtn');

        const rules = {
            length: document.getElementById('rule-length'),
            upper: document.getElementById('rule-upper'),
            lower: document.getElementById('rule-lower'),
            number: document.getElementById('rule-number'),
            symbol: document.getElementById('rule-symbol'),
            match: document.getElementById('rule-match'),
        };

        function validatePassword() {
            const value = password.value;

            const checks = {
                length: value.length >= 8,
                upper: /[A-Z]/.test(value),
                lower: /[a-z]/.test(value),
                number: /[0-9]/.test(value),
                symbol: /[^A-Za-z0-9]/.test(value),
                match: value === confirmPassword.value && value !== '',
            };

            let isValid = true;

            for (const rule in checks) {
                if (checks[rule]) {
                    rules[rule].classList.remove('text-red-400');
                    rules[rule].classList.add('text-green-400');
                } else {
                    rules[rule].classList.remove('text-green-400');
                    rules[rule].classList.add('text-red-400');
                    isValid = false;
                }
            }

            submitBtn.disabled = !isValid;
        }

        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    </script>
</x-guest-layout>
