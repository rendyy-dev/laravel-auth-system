<section class="space-y-4">
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Menghapus akun memerlukan verifikasi OTP demi keamanan.
        </p>
    </header>

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf

        <input type="hidden" name="purpose" value="account_delete">

        <button
            type="submit"
            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm rounded-lg"
        >
            Kirim OTP & Hapus Akun
        </button>
    </form>
</section>
