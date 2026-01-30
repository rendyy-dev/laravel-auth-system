<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Profile
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Update Profile -->
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- GANTI PASSWORD --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                @if(auth()->user()->role === 'super_admin')
                    {{-- LANGSUNG FORM PASSWORD (TANPA OTP) --}}
                    @include('profile.partials.superadmin-update-password-form')
                @else
                    {{-- USER BIASA → OTP --}}
                    @include('profile.partials.update-password-form')
                @endif
            </div>

            <!-- {{-- HAPUS AKUN --}}
            @if(auth()->user()->role !== 'super_admin')
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            @endif -->

        </div>
    </div>
</x-app-layout>
