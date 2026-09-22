<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Services\AdminActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminActivityController extends Controller
{
    /**
     * Halaman "Riwayat Perubahan" — daftar lengkap siapa mengubah apa,
     * dan kapan. Hanya aktivitas CRUD (tambah/ubah/hapus) yang tampil di
     * sini; aktivitas lain seperti login sengaja disaring keluar.
     */
    public function index(): View
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $activities = AdminActivity::query()
            ->crud()
            ->latest('created_at')
            ->paginate(25);

        // Buka halaman ini otomatis menandai semua notifikasi sudah dibaca.
        $admin->forceFill(['activities_read_at' => now()])->save();

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Dipanggil berkala lewat AJAX dari layout admin untuk menampilkan
     * notifikasi "Admin X mengubah Y" ke admin lain yang sedang online,
     * dan untuk meng-update badge & dropdown notifikasi di header.
     */
    public function latest(): JsonResponse
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $unread = AdminActivity::query()
            ->crud()
            ->where('admin_id', '!=', $admin->id)
            ->when($admin->activities_read_at, fn ($q) => $q->where('created_at', '>', $admin->activities_read_at))
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'admin_name', 'description', 'device', 'created_at'])
            ->map(fn (AdminActivity $activity) => [
                'id' => $activity->id,
                'admin_name' => $activity->admin_name,
                'description' => $activity->description,
                'device' => $activity->device,
                'created_at' => $activity->created_at_wib->format('d M Y, H:i:s'),
                'time_ago' => $activity->created_at_wib->diffForHumans(now('Asia/Jakarta')),
            ]);

        // Ikut kirim beberapa aktivitas terbaru (dibaca maupun belum) supaya
        // dropdown notifikasi tidak kosong begitu semua sudah ditandai
        // terbaca — cukup untuk ditampilkan sebagai daftar terkini.
        $recent = AdminActivity::query()
            ->crud()
            ->latest('created_at')
            ->limit(8)
            ->get(['id', 'admin_name', 'description', 'device', 'created_at'])
            ->map(fn (AdminActivity $activity) => [
                'id' => $activity->id,
                'admin_name' => $activity->admin_name,
                'description' => $activity->description,
                'device' => $activity->device,
                'created_at' => $activity->created_at_wib->format('d M Y, H:i:s'),
                'time_ago' => $activity->created_at_wib->diffForHumans(now('Asia/Jakarta')),
            ]);

        return response()->json([
            'unread_count' => AdminActivityLogger::unreadCountFor($admin),
            'items' => $unread,
            'recent' => $recent,
        ]);
    }

    /**
     * Tandai semua notifikasi sudah dibaca tanpa pindah halaman (dipanggil
     * saat admin membuka/menutup dropdown notifikasi).
     */
    public function markRead(Request $request): RedirectResponse|JsonResponse
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $admin->forceFill(['activities_read_at' => now()])->save();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }
}
