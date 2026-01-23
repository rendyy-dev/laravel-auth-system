<x-app-layout>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-4">
            <img
                src="{{ auth()->user()->avatarUrl() }}"
                loading="lazy"
                alt="Avatar"
                class="w-16 h-16 rounded-full object-cover border border-gray-700"
            >

            <div>
                <h1 class="text-2xl font-semibold">
                    Welcome, {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-gray-400">
                    Role: {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Account Status -->
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <p class="text-sm text-gray-400">Account Status</p>
                <p class="mt-2 text-lg font-semibold
                    {{ auth()->user()->is_active ? 'text-green-400' : 'text-red-400' }}">
                    {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                </p>
            </div>

            <!-- Login Method -->
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <p class="text-sm text-gray-400">Login Method</p>
                <p class="mt-2 text-lg font-semibold">
                    {{ auth()->user()->google_id ? 'Google' : 'Email' }}
                </p>
            </div>

            <!-- Member Since -->
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <p class="text-sm text-gray-400">Member Since</p>
                <p class="mt-2 text-lg font-semibold">
                    {{ auth()->user()->created_at->format('d M Y') }}
                </p>
            </div>

        </div>

        <!-- Info -->
        <!-- <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h2 class="text-sm font-semibold mb-2">Next Step</h2>
            <p class="text-sm text-gray-400">
                Complete your profile and start building awesome features 🚀
            </p>
        </div> -->

    </div>
</x-app-layout>
