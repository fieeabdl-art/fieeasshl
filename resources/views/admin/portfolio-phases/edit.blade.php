@extends('admin.layout')

@section('title', 'Edit Fase Progres')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.portfolios.phases.index', $portfolio) }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali ke Progres {{ $portfolio->title }}</a>
        <h1 class="mt-2 font-serif text-lg font-semibold text-stone-800">Edit Fase &mdash; {{ $phase->title }}</h1>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="mx-auto max-w-2xl rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.portfolios.phases.update', [$portfolio, $phase]) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="mb-1.5 block text-sm font-medium text-stone-700">Judul Fase <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $phase->title) }}" required
                       class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-stone-700">Persentase</label>
                <div class="inline-flex items-center gap-2 rounded-lg border border-stone-200 bg-stone-50 px-3.5 py-2.5 text-sm font-semibold text-stone-600">
                    {{ $phase->percentage }}%
                    <span class="text-xs font-normal text-stone-400">(terkunci sesuai tahap)</span>
                </div>
            </div>

            <div>
                <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Deskripsi Fase</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('description', $phase->description) }}</textarea>
            </div>

            <div>
                <label for="images" class="mb-1.5 block text-sm font-medium text-stone-700">Tambah Foto Galeri</label>
                <input type="file" name="images[]" id="images" accept="image/jpeg,image/png,image/webp" multiple
                       class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                <p class="mt-1 text-xs text-stone-400">Foto baru akan ditambahkan ke galeri fase ini. JPEG, PNG, WebP. Maks 15 MB per foto.</p>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-stone-100 pt-4">
                <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <section class="mx-auto mt-6 max-w-2xl rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold text-stone-800">Galeri Foto Fase Ini ({{ $phase->images->count() }})</h2>

        @if ($phase->images->isEmpty())
            <p class="text-sm text-stone-400">Belum ada foto pada fase ini.</p>
        @else
            <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                @foreach ($phase->images as $image)
                    <div class="group relative">
                        <div class="flex aspect-square w-full items-center justify-center overflow-hidden rounded-lg border border-stone-200 bg-stone-50">
                            <img src="{{ Storage::url($image->image) }}" alt="Foto progres" class="h-full w-full object-cover">
                        </div>
                        <form method="POST" action="{{ route('admin.portfolios.phases.images.destroy', [$portfolio, $phase, $image]) }}" onsubmit="return confirm('Hapus foto ini?');" class="absolute right-1.5 top-1.5">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus foto" class="flex h-7 w-7 items-center justify-center rounded-full bg-black/60 text-white opacity-0 transition-opacity duration-200 hover:bg-red-600 group-hover:opacity-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
