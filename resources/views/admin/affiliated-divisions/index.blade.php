@extends('admin.layout')

@section('title', 'Divisi Terafiliasi')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola daftar divisi/CV terafiliasi yang tampil di footer halaman depan.</p>
        <a href="{{ route('admin.affiliated-divisions.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Divisi</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-3">Ikon</th>
                        <th class="px-4 py-3">Nama Divisi</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($affiliatedDivisions as $division)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                @if ($division->logo)
                                    <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-stone-200 bg-white">
                                        <img src="{{ Storage::url($division->logo) }}" alt="{{ $division->name }}" class="h-full w-full object-contain p-1">
                                    </span>
                                @else
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 font-serif font-extrabold text-sm"
                                          style="color: {{ $division->color }}; background: {{ $division->color }}15;">
                                        {{ $division->initial }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-stone-800">{{ $division->name }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $division->description }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $division->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if ($division->is_published)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.affiliated-divisions.edit', $division) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.affiliated-divisions.destroy', $division) }}" onsubmit="return confirm('Yakin ingin menghapus divisi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-stone-400">
                                Belum ada divisi terafiliasi. <a href="{{ route('admin.affiliated-divisions.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($affiliatedDivisions->hasPages())
        <div class="mt-4">{{ $affiliatedDivisions->links() }}</div>
    @endif
@endsection
