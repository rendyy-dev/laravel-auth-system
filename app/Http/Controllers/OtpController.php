<?php

namespace App\Http\Controllers;

use App\Models\UserOtp;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class OtpController extends Controller
{
    /**
     * Kirim OTP ke email user
     */
    public function send(Request $request)
    {
        $request->validate([
            'purpose' => 'required|in:password_change,account_delete',
        ]);

        $user = auth()->user();

        // Hapus OTP lama (jika ada)
        UserOtp::where('user_id', $user->id)
            ->where('purpose', $request->purpose)
            ->delete();

        $otp = random_int(100000, 999999);

        UserOtp::create([
            'user_id'    => $user->id,
            'otp_hash'   => Hash::make($otp),
            'purpose'    => $request->purpose,
            'expires_at' => now()->addMinutes(5),
        ]);

        $user->notify(
            new SendOtpNotification($otp, $request->purpose)
        );

        return redirect()->route('otp.verify.form', [
            'purpose' => $request->purpose
        ])->with('status', 'Kode OTP sudah dikirim ke email kamu.');
    }

    /**
     * Verifikasi OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp'     => 'required|digits:6',
            'purpose' => 'required|in:password_change,account_delete',
        ]);

        $user = auth()->user();

        $otpRecord = UserOtp::where('user_id', $user->id)
            ->where('purpose', $request->purpose)
            ->latest()
            ->first();

        if (
            ! $otpRecord ||
            $otpRecord->expires_at->isPast() ||
            $otpRecord->used_at !== null ||
            ! Hash::check($request->otp, $otpRecord->otp_hash)
        ) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // Tandai OTP sudah dipakai
        $otpRecord->update([
            'used_at' => now()
        ]);

        // Simpan status OTP ke session
        session([
            'otp_verified' => $request->purpose
        ]);

        /**
         * Aksi lanjutan
         */
        if ($request->purpose === 'account_delete') {
            auth()->guard()->logout();

            $user->delete();

            return redirect('/')
                ->with('status', 'Akun kamu berhasil dihapus.');
        }

        session()->put('otp_verified', $request->purpose);

        return redirect()->route('password.form');
    }
}
