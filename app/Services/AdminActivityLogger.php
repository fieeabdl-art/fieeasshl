<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminActivityLogger
{
    /**
     * Hanya aksi CRUD ini yang dianggap "perubahan" — dipakai untuk
     * memfilter halaman Riwayat Perubahan, badge notifikasi, dan toast.
     * Aksi lain (mis. "logged_in") tetap boleh dicatat ke tabel ini kalau
     * suatu saat dibutuhkan untuk audit, tapi tidak akan tampil sebagai
     * "perubahan" ke admin.
     */
    public const CRUD_ACTIONS = ['created', 'updated', 'deleted'];

    /**
     * Simpan satu entri riwayat perubahan. Dipanggil otomatis lewat
     * AdminActivityObserver untuk model-model konten, atau manual dari
     * controller (mis. saat login) lewat AdminActivityLogger::log(...).
     */
    public static function log(string $action, string $description, ?string $subjectType = null, ?int $subjectId = null): void
    {
        /** @var Admin|null $admin */
        $admin = Auth::guard('admin')->user() ?? Auth::user();

        // Pastikan causer adalah Admin
        if (! $admin instanceof Admin) {
            $admin = null;
        }

        $userAgent = Request::header('User-Agent');

        AdminActivity::query()->create([
            'admin_id' => $admin?->id,
            'admin_name' => $admin?->name ?? 'Sistem',
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'device' => static::describeDevice($userAgent),
            'user_agent' => $userAgent ? mb_substr($userAgent, 0, 512) : null,
            // Simpan sebagai string jam dinding WIB eksplisit (bukan Carbon
            // yang formatnya bergantung timezone default aplikasi/server),
            // supaya tidak pernah lagi selisih dengan diffForHumans() saat
            // ditampilkan — lihat AdminActivity::createdAtWib().
            'created_at' => now('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Jumlah notifikasi yang belum dibaca oleh admin tertentu — hanya
     * aktivitas CRUD dari admin LAIN, setelah `activities_read_at`.
     */
    public static function unreadCountFor(Admin $admin): int
    {
        return AdminActivity::query()
            ->crud()
            ->where('admin_id', '!=', $admin->id)
            ->when($admin->activities_read_at, fn ($q) => $q->where('created_at', '>', $admin->activities_read_at))
            ->count();
    }

    /**
     * Ubah user agent mentah jadi label singkat "Browser di OS", mis.
     * "Chrome di Windows" atau "Safari di iPhone". Sengaja pakai regex
     * sederhana (bukan library eksternal) — cukup akurat untuk keperluan
     * riwayat, tidak perlu presisi forensik.
     */
    public static function describeDevice(?string $userAgent): ?string
    {
        if (! $userAgent) {
            return null;
        }

        $browser = match (true) {
            (bool) preg_match('/Edg\//i', $userAgent) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/i', $userAgent) => 'Opera',
            (bool) preg_match('/CriOS/i', $userAgent) => 'Chrome',
            (bool) preg_match('/Chrome\//i', $userAgent) && ! preg_match('/Chromium/i', $userAgent) => 'Chrome',
            (bool) preg_match('/FxiOS/i', $userAgent) => 'Firefox',
            (bool) preg_match('/Firefox\//i', $userAgent) => 'Firefox',
            (bool) preg_match('/Safari\//i', $userAgent) && preg_match('/Version\//i', $userAgent) => 'Safari',
            default => null,
        };

        $os = match (true) {
            (bool) preg_match('/iPhone/i', $userAgent) => 'iPhone',
            (bool) preg_match('/iPad/i', $userAgent) => 'iPad',
            (bool) preg_match('/Android/i', $userAgent) => 'Android',
            (bool) preg_match('/Mac OS X/i', $userAgent) => 'Mac',
            (bool) preg_match('/Windows/i', $userAgent) => 'Windows',
            (bool) preg_match('/Linux/i', $userAgent) => 'Linux',
            default => null,
        };

        if ($browser && $os) {
            return "{$browser} di {$os}";
        }

        return $browser ?? $os;
    }
}
