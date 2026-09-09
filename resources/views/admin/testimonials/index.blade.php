@extends('admin.layout')

@section('title', 'Testimonial')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">Kelola ulasan dan testimonial klien.</p>
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">+ Tambah Testimonial</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jabatan / Perusahaan</th>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($testimonials as $testimonial)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 py-3">
                                @if ($testimonial->photo)
                                    <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="h-10 w-10 rounded-full object-cover border border-stone-200">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-xs text-stone-400">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-stone-800">{{ $testimonial->name }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $testimonial->position }}@if($testimonial->position && $testimonial->company), @endif{{ $testimonial->company }}</td>
                            <td class="px-4 py-3 text-stone-500">{{ $testimonial->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if ($testimonial->is_published)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="rounded-md px-2.5 py-1.5 text-xs font-medium text-[#2C3E35] hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Yakin ingin menghapus testimonial ini?');">
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
                                Belum ada testimonial. <a href="{{ route('admin.testimonials.create') }}" class="font-medium text-[#2C3E35] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($testimonials->hasPages())
        <div class="mt-4">{{ $testimonials->links() }}</div>
    @endif
@endsection
