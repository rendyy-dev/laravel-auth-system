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

            <!-- Update Password -->
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                @include('profile.partials.update-password-form')
            </div>

        </div>
    </div>
</x-app-layout>
