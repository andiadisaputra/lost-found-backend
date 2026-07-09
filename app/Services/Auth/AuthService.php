<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\PendingRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Simpan data registrasi sementara (belum jadi user) & kirim OTP.
     * User baru benar-benar dibuat saat OTP berhasil diverifikasi.
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $otp = random_int(100000, 999999);

            $pending = PendingRegistration::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nim' => $data['nim'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'otp' => $otp,
                    'expired_at' => now()->addMinutes(5),
                ]
            );

            return [
                'pending' => $pending,
                'otp' => $otp,
            ];
        });
    }

    /**
     * Verifikasi OTP. Kalau valid, baru buat akun User permanen
     * dari data pending, lalu hapus data pending-nya.
     */
    public function verifyOtp(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $pending = PendingRegistration::where('email', $data['email'])->first();

            if (!$pending) {
                throw new \Exception('Data pendaftaran tidak ditemukan. Silakan daftar ulang.');
            }

            if ($pending->otp !== $data['otp']) {
                throw new \Exception('Kode OTP salah.');
            }

            if ($pending->expired_at < now()) {
                throw new \Exception('OTP sudah kedaluwarsa. Silakan minta kode baru.');
            }

            $user = User::create([
                'nim' => $pending->nim,
                'name' => $pending->name,
                'email' => $pending->email,
                'phone' => $pending->phone,
                'password' => $pending->password, // sudah di-hash sejak register
                'is_verified' => true,
            ]);

            $pending->delete();

            return $user;
        });
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new \Exception('Email belum terdaftar.');
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new \Exception('Password salah.');
        }

        $token = $user->createToken('mobile-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function resendOtp(string $email): int
    {
        $pending = PendingRegistration::where('email', $email)->first();

        if (!$pending) {
            throw new \Exception('Data pendaftaran tidak ditemukan. Silakan daftar ulang.');
        }

        $otp = random_int(100000, 999999);

        $pending->update([
            'otp' => $otp,
            'expired_at' => now()->addMinutes(5),
        ]);

        return $otp;
    }
}
