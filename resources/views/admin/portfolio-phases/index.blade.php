@extends('admin.layout')

@section('title', 'Progres Pengerjaan')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali ke {{ $portfolio->title }}</a>
        <h1 class="mt-2 font-serif text-lg font-semibold text-stone-800">Progres Pengerjaan &mdash; {{ $portfolio->title }}</h1>
        <p class="mt-1 text-sm text-stone-500">Setiap proyek memiliki 3 tahap tetap: 0% (Dokumentasi Sebelum), 50% (Proses Pengerjaan), dan 100% (Hasil Akhir). Persentase dan urutan tidak dapat diubah &mdash; hanya judul, deskripsi, dan foto.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (!empty($duplicates))
        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            <p class="font-medium">Ditemukan tahap duplikat pada persentase berikut, mohon periksa data secara manual (tidak dihapus otomatis):</p>
            <ul class="mt-1 list-inside list-disc space-y-0.5">
                @foreach ($duplicates as $percentage => $count)
                    <li>{{ $percentage }}% &mdash; {{ $count }} baris ditemukan</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        @foreach ($portfolio->phases as $phase)
            <section class="flex flex-col rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="mb-3 flex items-center gap-2">
                    <span class="inline-flex h-9 w-14 items-center justify-center rounded-full bg-[#2C3E35]/10 text-sm font-bold text-[#2C3E35]">{{ $phase->percentage }}%</span>
                    <h2 class="text-sm font-semibold text-stone-800">{{ $phase->title }}</h2>
                </div>

                <p class="min-h-[3rem] flex-1 text-sm text-stone-500">
                    {{ $phase->description ?: 'Belum ada deskripsi untuk tahap ini.' }}
                </p>

                <p class="mt-3 text-xs text-stone-400">{{ $phase->images->count() }} foto galeri</p>

                @if ($phase->images->isNotEmpty())
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        @foreach ($phase->images->take(4) as $image)
                            <div class="aspect-square overflow-hidden rounded-lg border border-stone-200 bg-stone-50">
                                <img src="{{ Storage::url($image->image) }}" alt="Foto progres" class="h-full w-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4 border-t border-stone-100 pt-4">
                    <a href="{{ route('admin.portfolios.phases.edit', [$portfolio, $phase]) }}" class="inline-flex w-full items-center justify-center rounded-lg bg-[#2C3E35] px-4 py-2 text-sm font-medium text-white hover:bg-[#24332c]">
                        Edit Tahap Ini
                    </a>
                </div>
            </section>
        @endforeach
    </div>
@endsection
