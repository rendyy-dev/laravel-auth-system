<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            Ganti Password (Super Admin)
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Sebagai Super Admin, kamu dapat mengganti password tanpa OTP.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Password Saat Ini" />
            <x-text-input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-gray-100"
                required
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password" value="Password Baru" />
            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-gray-100"
                required
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-gray-100"
                required
            />
        </div>

        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg"
            >
                Simpan Password
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-sm text-green-400">
                    Password berhasil diperbarui
                </span>
            @endif
        </div>
    </form>
</section>
