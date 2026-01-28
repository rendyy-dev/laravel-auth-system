<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Verifikasi OTP
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-md mx-auto bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-100 mb-2">
                Masukkan Kode OTP
            </h3>

            <p class="text-sm text-gray-400 mb-4">
                Kode OTP telah dikirim ke email kamu. Kode berlaku selama 5 menit.
            </p>

            <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="purpose" value="{{ request('purpose') }}">

                <div>
                    <x-input-label for="otp" value="Kode OTP" />
                    <x-text-input
                        id="otp"
                        name="otp"
                        type="text"
                        inputmode="numeric"
                        maxlength="6"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 text-gray-100"
                        placeholder="Contoh: 123456"
                        required
                    />
                    <x-input-error :messages="$errors->get('otp')" class="mt-1" />
                </div>

                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('profile.edit') }}"
                       class="text-sm text-gray-400 hover:text-gray-200">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg"
                    >
                        Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
