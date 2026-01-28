<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Ganti Password
        </h2>
    </x-slot>

    @if (session('status') === 'password-updated')
        <div class="mb-4 text-sm text-green-500">
            Password berhasil diganti.
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-md mx-auto bg-gray-900 border border-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-100 mb-4">
                Ganti Password
            </h3>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('put')

                {{-- Password saat ini --}}
                <div x-data="{ show: false }">
                    <x-input-label for="current_password" value="Password Saat Ini" />

                    <div class="relative">
                        <input
                            id="current_password"
                            name="current_password"
                            x-bind:type="show ? 'text' : 'password'"
                            required
                            class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                        />

                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <span x-text="show ? '🙈' : '👁'"></span>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                </div>

                {{-- Password baru --}}
                <div x-data="{ show: false }">
                    <x-input-label for="password" value="Password Baru" />

                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            x-bind:type="show ? 'text' : 'password'"
                            required
                            class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                        />

                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <span x-text="show ? '🙈' : '👁'"></span>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                </div>

                {{-- Konfirmasi password --}}
                <div x-data="{ show: false }">
                    <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />

                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            x-bind:type="show ? 'text' : 'password'"
                            required
                            class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-gray-100 pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                        />

                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <span x-text="show ? '🙈' : '👁'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg"
                    >
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
