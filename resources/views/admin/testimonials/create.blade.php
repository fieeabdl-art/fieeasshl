@extends('admin.layout')

@section('title', 'Tambah Testimonial')

@section('content')
    <div class="mb-6"><a href="{{ route('admin.testimonials.index') }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali</a></div>

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-stone-700">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="position" class="mb-1.5 block text-sm font-medium text-stone-700">Jabatan</label>
                <input type="text" name="position" id="position" value="{{ old('position') }}" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>
            <div>
                <label for="company" class="mb-1.5 block text-sm font-medium text-stone-700">Perusahaan</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>
        </div>
        <div>
            <label for="message" class="mb-1.5 block text-sm font-medium text-stone-700">Pesan <span class="text-red-500">*</span></label>
            <textarea name="message" id="message" rows="5" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('message') }}</textarea>
            @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="photo" class="mb-1.5 block text-sm font-medium text-stone-700">Foto</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
            <p class="mt-1 text-xs text-stone-400">JPEG, PNG, WebP. Maks 15MB.</p>
            @error('photo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-medium text-stone-700">Urutan</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true)) class="h-4 w-4 rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]">
                    Published
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-stone-100 pt-5">
            <a href="{{ route('admin.testimonials.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-100">Batal</a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">Simpan</button>
        </div>
    </form>
@endsection
