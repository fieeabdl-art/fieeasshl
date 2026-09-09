@extends('admin.layout')

@section('title', 'Klien & Mitra')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola logo klien &amp; mitra yang tampil di halaman depan.</p>
        <a href="{{ route('admin.client-partners.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Klien/Mitra</a>
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
                        <th class="px-4 py-3">Logo</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($clientPartners as $cp)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                @if ($cp->logo)
                                    <div class="flex h-12 w-20 items-center justify-center rounded border border-stone-200 bg-stone-50 p-1.5">
                                        <img src="{{ Storage::url($cp->logo) }}" alt="{{ $cp->name }}" class="max-h-full max-w-full object-contain">
                                    </div>
                                @else
                                    <div class="flex h-12 w-20 items-center justify-center rounded bg-stone-100 text-xs text-stone-400">—</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-stone-800">{{ $cp->name }}</td>
                            <td class="px-4 py-3">
                                @if ($cp->type === 'client')
                                    <span class="inline-flex rounded-full bg-sky-50 px-2 py-0.5 text-xs font-medium text-sky-700">Klien</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Mitra</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-stone-500">{{ $cp->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if ($cp->is_published)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.client-partners.edit', $cp) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.client-partners.destroy', $cp) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                Belum ada klien/mitra. <a href="{{ route('admin.client-partners.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($clientPartners->hasPages())
        <div class="mt-4">{{ $clientPartners->links() }}</div>
    @endif
@endsection
