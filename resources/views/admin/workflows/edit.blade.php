```blade
{{-- 
    ============================================================
    HALAMAN EDIT ALUR KERJA
    ============================================================
    Halaman ini digunakan oleh admin untuk mengubah data
    langkah-langkah alur kerja yang sudah tersimpan di database.
--}}

{{-- Menggunakan layout utama admin --}}
@extends('admin.layout')

{{-- 
    Mengatur judul halaman.
    Biasanya akan digunakan oleh admin.layout pada bagian <title>.
--}}
@section('title', 'Edit Alur Kerja')


{{-- ============================================================
     CONTENT
     ============================================================ --}}
@section('content')

    {{-- 
        Keterangan singkat di bagian atas halaman.
        Memberikan informasi kepada admin mengenai fungsi halaman.
    --}}
    <div class="mb-6">
        <p class="text-sm text-stone-500">
            Perbarui informasi langkah alur kerja.
        </p>
    </div>


    {{-- ========================================================
         PESAN ERROR VALIDASI
         ========================================================

         Jika data yang dikirim admin tidak memenuhi validasi
         di controller, Laravel akan menyimpan pesan error
         di dalam variabel $errors.
    --}}
    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            {{-- Menampilkan semua pesan error --}}
            <ul class="list-inside list-disc space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================
         FORM EDIT ALUR KERJA
         ========================================================

         Data akan dikirim ke route:
         admin.workflows.update

         $workflow adalah data alur kerja yang sedang diedit.
    --}}
    <form
        action="{{ route('admin.workflows.update', $workflow) }}"
        method="POST"
        class="space-y-6"
    >

        {{-- Token keamanan Laravel untuk mencegah CSRF --}}
        @csrf

        {{-- 
            Karena form HTML hanya mendukung GET dan POST,
            @method('PUT') digunakan agar Laravel menganggap
            request ini sebagai HTTP PUT untuk proses update.
        --}}
        @method('PUT')


        {{-- ====================================================
             BAGIAN DATA ALUR KERJA
             ==================================================== --}}
        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">

            {{-- 
                Grid digunakan supaya input Nomor Langkah dan
                checkbox dapat ditampilkan berdampingan pada
                layar yang cukup lebar.
            --}}
            <div class="grid gap-5 sm:grid-cols-2">


                {{-- =================================================
                     NOMOR LANGKAH
                     ================================================= --}}
                <div>

                    {{-- Label untuk input nomor langkah --}}
                    <label
                        for="step"
                        class="mb-1.5 block text-sm font-medium text-stone-700"
                    >
                        Nomor Langkah
                    </label>

                    {{-- 
                        Input angka untuk menentukan urutan
                        langkah alur kerja.

                        old() digunakan agar nilai sebelumnya
                        tetap muncul jika validasi gagal.
                    --}}
                    <input
                        type="number"
                        name="step"
                        id="step"
                        value="{{ old('step', $workflow->step) }}"
                        min="1"
                        max="99"
                        class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20"
                    >

                </div>


                {{-- =================================================
                     STATUS PUBLIKASI
                     ================================================= --}}
                <div class="flex items-end">

                    {{-- 
                        Checkbox menentukan apakah alur kerja
                        ditampilkan pada website publik.
                    --}}
                    <label class="flex items-center gap-2 text-sm text-stone-600 pb-2.5">

                        <input
                            type="checkbox"
                            name="is_published"
                            value="1"

                            {{-- 
                                Checkbox otomatis dicentang jika:
                                - nilai lama dari form adalah 1, atau
                                - data database bernilai true.
                            --}}
                            {{ old('is_published', $workflow->is_published) ? 'checked' : '' }}

                            class="rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]/40"
                        >

                        Tampilkan di website

                    </label>

                </div>


                {{-- =================================================
                     JUDUL ALUR KERJA
                     ================================================= --}}
                <div class="sm:col-span-2">

                    {{-- Label judul --}}
                    <label
                        for="title"
                        class="mb-1.5 block text-sm font-medium text-stone-700"
                    >
                        Judul
                    </label>

                    {{-- 
                        Input judul langkah alur kerja.

                        Contoh:
                        "Konsultasi"
                        "Survey Lokasi"
                        "Desain"
                        "Produksi"
                    --}}
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $workflow->title) }}"
                        class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20"
                    >

                </div>


                {{-- =================================================
                     DESKRIPSI
                     ================================================= --}}
                <div class="sm:col-span-2">

                    {{-- Label deskripsi --}}
                    <label
                        for="description"
                        class="mb-1.5 block text-sm font-medium text-stone-700"
                    >
                        Deskripsi
                    </label>

                    {{-- 
                        Textarea digunakan untuk menyimpan
                        penjelasan dari langkah alur kerja.

                        rows="5" menentukan tinggi awal textarea.
                    --}}
                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20"
                    >{{ old('description', $workflow->description) }}</textarea>

                </div>

            </div>

        </section>


        {{-- ========================================================
             TOMBOL AKSI
             ========================================================

             Bagian ini berisi tombol untuk:
             1. Kembali ke daftar alur kerja.
             2. Menyimpan perubahan.
        --}}
        <div class="flex items-center justify-end gap-3">


            {{-- =================================================
                 TOMBOL KEMBALI
                 =================================================

                 Tidak mengubah data.
                 Hanya membawa admin kembali ke halaman daftar
                 alur kerja.
            --}}
            <a
                href="{{ route('admin.workflows.index') }}"
                class="rounded-lg border border-stone-300 px-5 py-2.5 text-sm font-medium text-stone-700 hover:bg-stone-100"
            >
                Kembali
            </a>


            {{-- =================================================
                 TOMBOL UPDATE
                 =================================================

                 Ketika ditekan:
                 - Form akan dikirim.
                 - Laravel menjalankan method update().
                 - Data alur kerja akan diperbarui di database.
            --}}
            <button
                type="submit"
                class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c]"
            >
                Update
            </button>

        </div>

    </form>

@endsection

