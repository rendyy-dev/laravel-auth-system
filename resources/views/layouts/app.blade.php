<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RenTry-App</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-950 text-gray-100">

    <div class="min-h-screen flex">
        <aside class="w-64 bg-gray-900 border-r border-gray-800 hidden md:flex flex-col">
            <div class="px-6 py-6 flex items-center gap-3 border-b border-gray-800">
                <img src="{{ auth()->user()->avatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-700">

                <div class="leading-tight">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>

                    <p class="text-xs text-gray">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded-lg font-medium
                {{ request()->routeIs('dashboard')
                        ? 'bg-gray-800 text-indigo-400'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    Dashboard
                </a>

                <a href="{{ route('profile.edit') }}"
                class="block px-3 py-2 rounded-lg font-medium
                {{ request()->routeIs('profile.*')
                        ? 'bg-gray-800 text-indigo-400'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    Profile
                </a>

                <!-- <a href="{{ route('products.index') }}"
                class="block px-3 py-2 rounded-lg font-medium
                {{ request()->routeIs('products.*')
                        ? 'bg-gray-800 text-indigo-400'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    Products
                </a> -->

                @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                <a href="{{ route('users.index') }}"
                class="block px-3 py-2 rounded-lg font-medium
                {{ request()->routeIs('users.*')
                        ? 'bg-gray-800 text-indigo-400'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    Users
                </a>
            @endif
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-6">
                <span class="text-sm text-gray-400">
                    Welcome, {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="text-sm text-gray-400 hover:text-red-400 transition"
                    >
                        Logout
                    </button>
                </form>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                    @if (session('status'))
                        <div 
                            x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 3000)"
                            x-show="show"
                            class="max-w-4xl mx-auto mt-6 px-4"
                        >
                            <div class="bg-green-900/60 border border-green-700 text-green-200 px-4 py-3 rounded-lg text-sm">
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
