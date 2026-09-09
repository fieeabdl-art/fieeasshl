@extends('admin.layout')

@section('title', 'Edit Layanan')

@section('content')
    <div class="mb-6"><a href="{{ route('admin.services.index') }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali</a></div>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="mx-auto max-w-2xl space-y-6 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label for="title" class="mb-1.5 block text-sm font-medium text-stone-700">Judul Layanan <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="slug" class="mb-1.5 block text-sm font-medium text-stone-700">Slug (URL)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug) }}" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            <p class="mt-1 text-xs text-stone-400">Biarkan sesuai default atau sesuaikan untuk URL layanan.</p>
            @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="description" id="description" rows="4" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('description', $service->description) }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="image" class="mb-1.5 block text-sm font-medium text-stone-700">Gambar Layanan</label>
            @if ($service->image)
                <div class="mb-3 flex items-center gap-4">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="h-24 w-36 rounded-lg object-cover border border-stone-200">
                    <label class="flex items-center gap-2 text-sm text-stone-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus gambar saat ini
                    </label>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
            <p class="mt-1 text-xs text-stone-400">Upload gambar baru untuk mengganti. JPEG, PNG, WebP. Maks 15 MB.</p>
            @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-medium text-stone-700">Urutan Tampil</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="status" value="1" @checked(old('status', $service->status)) class="h-4 w-4 rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]">
                    Aktif (Tampil di Website)
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-stone-100 pt-5">
            <a href="{{ route('admin.services.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-100">Batal</a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">Simpan Perubahan</button>
        </div>
    </form>
@endsection
