@extends('admin.layout')

@section('title', 'Edit Divisi Terafiliasi')

@section('content')
    <div class="mb-6">
        <p class="text-sm text-stone-500">Perbarui data divisi/CV terafiliasi.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.affiliated-divisions.update', $affiliatedDivision) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-medium text-stone-700">Nama Divisi/CV</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $affiliatedDivision->name) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>

                <div class="sm:col-span-2">
                    <label for="logo" class="mb-1.5 block text-sm font-medium text-stone-700">Logo CV</label>
                    @if ($affiliatedDivision->logo)
                        <div class="mb-3 flex items-center gap-4">
                            <span class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-full border border-stone-200 bg-stone-50 p-2">
                                <img src="{{ Storage::url($affiliatedDivision->logo) }}" alt="{{ $affiliatedDivision->name }}" class="max-h-full max-w-full object-contain">
                            </span>
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_logo" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus logo
                            </label>
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" accept="image/*" onchange="previewLogo(event)"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    <p class="mt-1 text-xs text-stone-400">JPG, JPEG, PNG, WebP, atau SVG. Ukuran maksimal 15 MB. Jika kosong, ikon akan memakai inisial nama secara otomatis.</p>
                    <img id="logo-preview" src="" alt="Preview" class="mt-3 hidden h-16 w-16 rounded-full border border-stone-200 object-contain p-2">
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Deskripsi Singkat</label>
                    <input type="text" name="description" id="description" value="{{ old('description', $affiliatedDivision->description) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>

                <div>
                    <label for="sort_order" class="mb-1.5 block text-sm font-medium text-stone-700">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $affiliatedDivision->sort_order) }}" min="0"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-2 text-sm text-stone-600 pb-2.5">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $affiliatedDivision->is_published) ? 'checked' : '' }}
                               class="rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]/40">
                        Tampilkan di website
                    </label>
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.affiliated-divisions.index') }}" class="rounded-lg border border-stone-300 px-5 py-2.5 text-sm font-medium text-stone-700 hover:bg-stone-100">
                Kembali
            </a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c]">
                Update
            </button>
        </div>
    </form>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logo-preview');
            if (!file) {
                preview.classList.add('hidden');
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    </script>
@endsection
