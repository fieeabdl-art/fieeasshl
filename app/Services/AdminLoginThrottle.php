<?php

namespace App\Services;

use App\Models\AdminLoginAttempt;
use Carbon\CarbonInterface;

/**
 * Progressive lockout untuk login admin.
 *
 * Aturan:
 * - Maksimal 5x percobaan gagal.
 * - Setelah 5x gagal, akun+IP dikunci 30 menit.
 * - Kalau setelah masa kunci habis lalu gagal 5x lagi, durasi kunci
 *   berikutnya jadi 2x lipat (60 menit), lalu 120 menit, dst.
 * - Login berhasil akan mereset semuanya ke kondisi awal.
 */
class AdminLoginThrottle
{
    private const MAX_ATTEMPTS = 5;

    private const BASE_LOCKOUT_MINUTES = 30;

    public function identifierFor(string $email, string $ip): string
    {
        return strtolower($email).'|'.$ip;
    }

    /**
     * Null kalau boleh mencoba login. Kalau sedang terkunci, return
     * Carbon waktu kapan boleh mencoba lagi.
     */
    public function lockedUntil(string $identifier): ?CarbonInterface
    {
        $record = AdminLoginAttempt::query()->where('identifier', $identifier)->first();

        if (! $record || ! $record->locked_until) {
            return null;
        }

        if ($record->locked_until->isFuture()) {
            return $record->locked_until;
        }

        return null;
    }

    /**
     * Catat 1 percobaan login yang gagal. Mengunci akun kalau sudah
     * mencapai batas percobaan.
     */
    public function recordFailure(string $identifier): void
    {
        $record = AdminLoginAttempt::query()->firstOrCreate(
            ['identifier' => $identifier],
            ['attempts' => 0, 'lockout_level' => 0],
        );

        $record->attempts += 1;

        if ($record->attempts >= self::MAX_ATTEMPTS) {
            $record->lockout_level += 1;
            $minutes = self::BASE_LOCKOUT_MINUTES * (2 ** ($record->lockout_level - 1));
            $record->locked_until = now()->addMinutes($minutes);
            $record->attempts = 0;
        }

        $record->save();
    }

    /**
     * Reset penuh setelah login berhasil.
     */
    public function clear(string $identifier): void
    {
        AdminLoginAttempt::query()->where('identifier', $identifier)->delete();
    }

    public function remainingAttempts(string $identifier): int
    {
        $record = AdminLoginAttempt::query()->where('identifier', $identifier)->first();

        if (! $record) {
            return self::MAX_ATTEMPTS;
        }

        return max(0, self::MAX_ATTEMPTS - $record->attempts);
    }
}
