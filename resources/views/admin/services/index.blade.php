@extends('admin.layout')

@section('title', 'Layanan')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola layanan interior yang tampil di halaman depan.</p>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Layanan</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-3">Gambar</th>
                        <th class="px-4 py-3">Judul Layanan</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($services as $service)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                @if ($service->image)
                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="h-12 w-16 rounded object-cover border border-stone-200">
                                @else
                                    <div class="flex h-12 w-16 items-center justify-center rounded bg-stone-100 text-xs text-stone-400">—</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-stone-800">{{ $service->title }}</p>
                                <p class="text-xs text-stone-500 line-clamp-1 max-w-xs">{{ $service->description }}</p>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-stone-500">{{ $service->slug }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $service->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if ($service->status)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
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
                                Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($services->hasPages())
        <div class="mt-4">{{ $services->links() }}</div>
    @endif
@endsection
