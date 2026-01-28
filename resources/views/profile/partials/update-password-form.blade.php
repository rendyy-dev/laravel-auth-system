<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            Ganti Password
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Untuk keamanan, kamu harus verifikasi OTP sebelum mengganti password.
        </p>
    </header>

    <form method="POST" action="{{ route('otp.send') }}" class="mt-6">
        @csrf

        <input type="hidden" name="purpose" value="password_change">

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg"
        >
            Kirim OTP ke Email
        </button>
    </form>
</section>
