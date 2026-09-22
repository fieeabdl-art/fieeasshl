<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Semua route di controller ini dibungkus middleware EnsureSuperAdmin
 * (lihat routes/admin.php) — hanya Super Admin yang bisa menambah,
 * menghapus admin, atau menentukan siapa yang jadi Super Admin lain.
 */
class AdminUserController extends Controller
{
    public function index(): View
    {
        $admins = Admin::query()
            ->orderByDesc('role')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Admin::query()->create($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(Admin $adminUser): View
    {
        return view('admin.admins.edit', ['adminUser' => $adminUser]);
    }

    public function update(UpdateAdminRequest $request, Admin $adminUser): RedirectResponse
    {
        $data = $request->validated();

        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Jangan sampai super admin terakhir menurunkan perannya sendiri
        // jadi admin biasa — CMS bisa kehilangan super admin sama sekali.
        if (
            $adminUser->isSuperAdmin()
            && $data['role'] !== Admin::ROLE_SUPER_ADMIN
            && Admin::query()->where('role', Admin::ROLE_SUPER_ADMIN)->count() <= 1
        ) {
            return redirect()
                ->route('admin.admins.edit', $adminUser)
                ->with('error', 'Tidak dapat menurunkan peran ini. Minimal harus ada 1 Super Admin aktif — jadikan admin lain Super Admin terlebih dahulu.');
        }

        $adminUser->update($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(Admin $adminUser): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        if ($currentAdmin && $currentAdmin->is($adminUser)) {
            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        if (Admin::query()->count() <= 1) {
            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'Tidak dapat menghapus admin terakhir. Minimal harus ada 1 akun admin.');
        }

        if ($adminUser->isSuperAdmin() && Admin::query()->where('role', Admin::ROLE_SUPER_ADMIN)->count() <= 1) {
            return redirect()
                ->route('admin.admins.index')
                ->with('error', 'Tidak dapat menghapus Super Admin terakhir. Jadikan admin lain Super Admin terlebih dahulu.');
        }

        $adminUser->delete();

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}
