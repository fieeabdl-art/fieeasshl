@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit Anggota Team
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Perbarui informasi anggota team.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.team-profiles.update', $teamProfile) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $teamProfile->name) }}"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Posisi --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Posisi
                </label>

                <input
                    type="text"
                    name="position"
                    value="{{ old('position', $teamProfile->position) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Foto lama --}}
            @if ($teamProfile->image_path)
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Saat Ini
                    </label>

                    <img
                        src="{{ asset('storage/' . $teamProfile->image_path) }}"
                        alt="{{ $teamProfile->name }}"
                        class="w-32 h-32 object-cover rounded-xl border border-gray-200"
                    >
                </div>
            @endif

            {{-- Foto baru --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ganti Foto
                </label>

                <input
                    type="file"
                    name="image_path"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-lg border border-gray-300 p-2"
                >

                <p class="text-xs text-gray-500 mt-1">
                    JPG, JPEG, PNG, atau WEBP. Maksimal 15 MB.
                </p>
            </div>

            {{-- Instagram --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Instagram
                </label>

                <input
                    type="url"
                    name="instagram"
                    value="{{ old('instagram', $teamProfile->instagram) }}"
                    placeholder="https://instagram.com/username"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- LinkedIn --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    LinkedIn
                </label>

                <input
                    type="url"
                    name="linkedin"
                    value="{{ old('linkedin', $teamProfile->linkedin) }}"
                    placeholder="https://linkedin.com/in/username"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Urutan --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan Tampilan
                </label>

                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', $teamProfile->sort_order ?? 0) }}"
                    min="0"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Tombol --}}
    
{{-- Tombol --}}
<div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">

    {{-- Tombol Batal --}}
    <a
        href="{{ route('admin.team-profiles.index') }}"
        class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg
               bg-gray-100 text-gray-700 font-semibold
               border border-gray-300
               hover:bg-gray-200
               transition-all duration-200"
    >
        Batal
    </a>

    {{-- Tombol Simpan Perubahan --}}
     <button
                type="submit"
                class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c]"
            >
                Update
            </button>


        </form>

    </div>
</div>
@endsection
