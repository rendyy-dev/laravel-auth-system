<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Perbarui informasi akun dan alamat email kamu.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-5">
            <img src="{{ $user->avatarUrl() }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border border-gray-700">

            <div>
                <h2 class="text-gray-300 font-semibold mb-1">Foto Profil</h2>
                <input type="file" name="avatar" accept="image/*" class="block text-sm text-gray-300
                    file:bg-gray-800 file:border-0
                    file:px-4 file:py-2
                    file:text-gray-300
                    file:rounded-lg
                    hover:file:bg-gray-700">

                    <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
            </div>
        </div>
        
        <div>
            <h2 class="text-gray-300 font-semibold">Nama:</h2>
            <x-text-input
                name="name"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                :value="old('name', $user->name)"
                required
            />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        <div>
            <h2 class="text-gray-300 font-semibold">Username:</h2>
            <x-text-input
                name="username"
                type="text"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                :value="old('username', $user->username)"
                required
            />
            <x-input-error class="mt-1" :messages="$errors->get('username')" />
        </div>

        <div>
            <h2 class="text-gray-300 font-semibold">Email:</h2>
            <x-text-input
                name="email"
                type="email"
                class="w-full bg-gray-800 border-gray-700 text-gray-100"
                :value="old('email', $user->email)"
                required
            />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="text-xs text-yellow-400">
                Email kamu belum diverifikasi.
            </p>
        @endif

        <div class="flex items-center gap-3">
            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-sm text-green-400">
                    Profil berhasil diperbarui
                </span>
            @endif
        </div>
    </form>
</section>
