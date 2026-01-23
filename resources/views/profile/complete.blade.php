<x-guest-layout>
    <div class="space-y-4" x-data="completeProfile()">

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-lg font-semibold text-gray-100">
                Complete Your Profile
            </h1>
            <p class="text-xs text-gray-400">
                Lengkapi data untuk melanjutkan
            </p>
        </div>

        {{-- Global Error --}}
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-lg p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.complete.store') }}" class="space-y-3">
            @csrf

            <!-- Name -->
            <x-text-input
                name="name"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Name"
                value="{{ auth()->user()->name }}"
                required
            />

            <!-- Username -->
            <x-text-input
                name="username"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Username"
                required
            />

            <!-- Email (readonly from Google) -->
            <x-text-input
                name="email"
                type="email"
                class="w-full bg-gray-700 border-gray-600 text-gray-400 cursor-not-allowed"
                value="{{ auth()->user()->email }}"
                disabled
            />

            <!-- Password -->
            <x-text-input
                id="password"
                name="password"
                type="password"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Password"
                x-model="password"
                @input="validatePassword"
                required
            />

            <!-- Confirm Password -->
            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                placeholder="Confirm Password"
                x-model="confirmPassword"
                @input="validatePassword"
                required
            />

            <!-- Password Rules -->
            <div class="text-xs space-y-1" x-show="password.length > 0" x-cloak>
                <p :class="ruleMin8 ? 'text-green-400' : 'text-red-400'">• Minimal 8 karakter</p>
                <p :class="ruleUpper ? 'text-green-400' : 'text-red-400'">• Mengandung huruf besar</p>
                <p :class="ruleLower ? 'text-green-400' : 'text-red-400'">• Mengandung huruf kecil</p>
                <p :class="ruleNumber ? 'text-green-400' : 'text-red-400'">• Mengandung angka</p>
                <p :class="ruleSymbol ? 'text-green-400' : 'text-red-400'">• Mengandung simbol</p>
                <p :class="ruleMatch ? 'text-green-400' : 'text-red-400'">• Password cocok</p>
            </div>

            <button
                type="submit"
                class="w-full text-white bg-indigo-600 hover:bg-indigo-500 text-sm font-medium py-2.5 rounded-lg">
                Save & Continue
            </button>
        </form>
    </div>

    <script>
        function completeProfile() {
            return {
                password: '',
                confirmPassword: '',

                ruleMin8: false,
                ruleUpper: false,
                ruleLower: false,
                ruleNumber: false,
                ruleSymbol: false,
                ruleMatch: false,

                validatePassword() {
                    const value = this.password;

                    this.ruleMin8 = value.length >= 8;
                    this.ruleUpper = /[A-Z]/.test(value);
                    this.ruleLower = /[a-z]/.test(value);
                    this.ruleNumber = /[0-9]/.test(value);
                    this.ruleSymbol = /[^A-Za-z0-9]/.test(value);
                    this.ruleMatch = value === this.confirmPassword && value !== '';
                }
            }
        }
    </script>
</x-guest-layout>
