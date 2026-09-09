@extends('admin.layout')

@section('title', 'Tambah Alur Kerja')

@section('content')
    <div class="mb-6">
        <p class="text-sm text-stone-500">Tambahkan langkah baru pada alur kerja Bumiyuji Living.</p>
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

    <form action="{{ route('admin.workflows.store') }}" method="POST" class="space-y-6">
        @csrf

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="step" class="mb-1.5 block text-sm font-medium text-stone-700">Nomor Langkah</label>
                    <input type="number" name="step" id="step" value="{{ old('step') }}" min="1" max="99" placeholder="Contoh: 1"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-2 text-sm text-stone-600 pb-2.5">
                        <input type="checkbox" name="is_published" value="1" checked
                               class="rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]/40">
                        Tampilkan di website
                    </label>
                </div>

                <div class="sm:col-span-2">
                    <label for="title" class="mb-1.5 block text-sm font-medium text-stone-700">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: KONSULTASI"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-medium text-stone-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="5" placeholder="Masukkan deskripsi alur kerja..."
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('description') }}</textarea>
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.workflows.index') }}" class="rounded-lg border border-stone-300 px-5 py-2.5 text-sm font-medium text-stone-700 hover:bg-stone-100">
                Kembali
            </a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c]">
                Simpan
            </button>
        </div>
    </form>
@endsection
