@extends('admin.layout')

@section('title', 'Alur Kerja')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola langkah-langkah alur kerja yang tampil di halaman depan.</p>
        <a href="{{ route('admin.workflows.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Alur Kerja</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif
 <!-- #region -->
    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-3 w-20">No.</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 w-32">Status</th>
                        <th class="px-4 py-3 text-right w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($workflows as $workflow)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#2C3E35]/5 text-xs font-bold text-[#2C3E35]">
                                    {{ str_pad($workflow->step, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-stone-800">{{ $workflow->title }}</td>
                            <td class="px-4 py-3 text-stone-500">
                                <span class="line-clamp-2">{{ $workflow->description }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($workflow->is_published)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.workflows.edit', $workflow) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.workflows.destroy', $workflow) }}" onsubmit="return confirm('Yakin ingin menghapus alur kerja ini?');">
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
                                Belum ada alur kerja. <a href="{{ route('admin.workflows.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($workflows->hasPages())
        <div class="mt-4">{{ $workflows->links() }}</div>
    @endif
@endsection
