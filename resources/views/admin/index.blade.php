@extends('admin.layout')

@section('title', 'Testimonials')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Kelola ulasan dan testimonial klien.</p>
        <a href="{{ route('admin.testimonials.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
            + Tambah Testimonial
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Jabatan / Perusahaan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($testimonial->photo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-100"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $testimonial->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $testimonial->position }}@if($testimonial->position && $testimonial->company), @endif{{ $testimonial->company }}</td>
                        <td class="px-4 py-3">
                            @if ($testimonial->is_published)
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Published</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="mr-3 text-sm font-medium text-emerald-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline" data-confirm-delete="Hapus testimonial dari &quot;{{ $testimonial->name }}&quot;?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-400">Belum ada testimonial.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
@endsection