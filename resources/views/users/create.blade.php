<x-app-layout>
    <div class="max-w-xl mx-auto space-y-6">

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-lg p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-2xl font-semibold">Add User</h1>

        <form id="userForm"
              action="{{ route('users.store') }}"
              method="POST"
              class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
            @csrf

            <input name="name" placeholder="Name"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                   required>

            <input name="username" placeholder="Username"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                   required>

            <input name="email" type="email" placeholder="Email"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                   required>

            <input id="password"
                   type="password"
                   name="password"
                   placeholder="Password"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                   required>

            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   placeholder="Confirm Password"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                   required>

            <div class="text-xs space-y-1" id="passwordRules">
                <p id="rule-length" class="text-red-400">• Minimal 8 karakter</p>
                <p id="rule-upper" class="text-red-400">• Mengandung huruf besar</p>
                <p id="rule-lower" class="text-red-400">• Mengandung huruf kecil</p>
                <p id="rule-number" class="text-red-400">• Mengandung angka</p>
                <p id="rule-symbol" class="text-red-400">• Mengandung simbol</p>
                <p id="rule-match" class="text-red-400">• Password cocok</p>
            </div>

            @if(auth()->user()->role === 'super_admin')
                <select name="role"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2"
                        required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            @else
                <input type="hidden" name="role" value="user">

                <!-- <div class="text-xs text-gray-400 bg-gray-800/40 border border-gray-700 rounded-lg p-3">
                    User yang dibuat akan otomatis memiliki role
                    <span class="text-indigo-400 font-medium">User</span>.
                </div> -->
            @endif

            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}"
                   class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg">
                    Cancel
                </a>

                <button id="submitBtn"
                        type="submit"
                        disabled
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    Save
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
</x-app-layout>
