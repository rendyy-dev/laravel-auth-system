<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RenTry - Login</title>

    <!-- Fonts (optional, tapi bikin UI lebih halus) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-950 flex flex-col justify-center items-center px-4">

        <!-- App Name / Logo -->
        <div class="mb-8 text-center">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-gray-100">
                RenTry
            </a>
            <p class="text-sm text-gray-400 mt-2">
                Ayo Inventory Produk Kamu
            </p>
        </div>

        <!-- Auth Card -->
        <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-xl">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-8 text-xs text-gray-600">
            © {{ date('Y') }} M. Rendy Fahrezi. All rights reserved.
        </p>

    </div>

</body>
</html>
