<x-app-layout>
    <div class="max-w-xl mx-auto space-y-6">

        <h1 class="text-2xl font-semibold">Edit User</h1>

        <form id="editUserForm"
              action="{{ route('users.update', $user) }}"
              method="POST"
              class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <input
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Name"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                >
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <input
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    placeholder="Username"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                >
                <x-input-error :messages="$errors->get('username')" class="mt-1" />
            </div>

            <div>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    placeholder="Email"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="New Password (optional)"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm New Password"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                >
            </div>

            <div class="text-xs space-y-1" id="passwordRules">
                <p id="rule-length" class="text-gray-400">• Minimal 8 karakter</p>
                <p id="rule-upper" class="text-gray-400">• Mengandung huruf besar</p>
                <p id="rule-lower" class="text-gray-400">• Mengandung huruf kecil</p>
                <p id="rule-number" class="text-gray-400">• Mengandung angka</p>
                <p id="rule-symbol" class="text-gray-400">• Mengandung simbol</p>
                <p id="rule-match" class="text-gray-400">• Password cocok</p>
            </div>

            @if(auth()->user()->role === 'super_admin')
                <div>
                    <select
                        name="role"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                    >
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>
            @endif

            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}"
                   class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg">
                    Cancel
                </a>

                <button id="submitBtn"
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    Update
                </button>
            </div>

        </form>
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

            if (value === '') {
                Object.values(rules).forEach(rule => {
                    rule.classList.remove('text-red-400', 'text-green-400');
                    rule.classList.add('text-gray-400');
                });
                submitBtn.disabled = false;
                return;
            }

            const checks = {
                length: value.length >= 8,
                upper: /[A-Z]/.test(value),
                lower: /[a-z]/.test(value),
                number: /[0-9]/.test(value),
                symbol: /[^A-Za-z0-9]/.test(value),
                match: value === confirmPassword.value,
            };

            let isValid = true;

            for (const rule in checks) {
                if (checks[rule]) {
                    rules[rule].classList.remove('text-red-400', 'text-gray-400');
                    rules[rule].classList.add('text-green-400');
                } else {
                    rules[rule].classList.remove('text-green-400', 'text-gray-400');
                    rules[rule].classList.add('text-red-400');
                    isValid = false;
                }
            }

            submitBtn.disabled = !isValid;
        }

        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    </script>
</x-app-layout>
