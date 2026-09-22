@extends('admin.layout')

@section('title', 'Kelola Admin')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola akun admin yang memiliki akses ke CMS ini.</p>
        <a href="{{ route('admin.admins.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Admin</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Peran</th>
                        <th class="px-4 py-3">Dibuat</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#2C3E35]/10 text-xs font-bold text-[#2C3E35]">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-stone-800">{{ $admin->name }}</p>
                                        @if (Auth::guard('admin')->id() === $admin->id)
                                            <span class="text-xs text-emerald-600">Anda saat ini</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-stone-600">{{ $admin->email }}</td>
                            <td class="px-4 py-3">
                                @if ($admin->isSuperAdmin())
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#C5A880]/20 px-2.5 py-1 text-xs font-semibold text-[#8a6d3f]">Super Admin</span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-600">Admin</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-stone-500">{{ optional($admin->created_at)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="return confirm('Yakin ingin menghapus akun admin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-stone-400">
                                Belum ada akun admin. <a href="{{ route('admin.admins.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($admins->hasPages())
        <div class="mt-4">{{ $admins->links() }}</div>
    @endif
@endsection
