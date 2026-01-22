<x-guest-layout>
    <div class="space-y-4 text-center">

        <div class="flex justify-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-indigo-600/10 text-indigo-400">
                ✉️
            </div>
        </div>

        <h1 class="text-lg font-semibold text-gray-100">
            Verifikasi Email
        </h1>

        <p class="text-sm text-gray-400 leading-relaxed">
            Terima kasih telah mendaftar 🙌 <br>
            Sebelum melanjutkan, silakan verifikasi alamat email kamu dengan
            mengklik link yang telah kami kirimkan ke email kamu.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 text-xs rounded-lg p-3">
                Link verifikasi baru telah dikirim ke email kamu.
            </div>
        @endif

        <div class="space-y-3">

            <!-- Resend -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full text-sm text-gray-400 hover:text-gray-200 underline">
                    Keluar & Login dengan Akun Lain
                </button>
            </form>
        </div>

        <p class="text-[11px] text-gray-500">
            Jika tidak menemukan email, periksa folder <b>Spam</b> atau <b>Promosi</b>.
        </p>

    </div>
</x-guest-layout>
