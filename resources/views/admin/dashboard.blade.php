@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <p class="text-sm text-stone-500">Ringkasan konten website BumiYuji.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-stone-400">Total Layanan</p>
            <p class="mt-2 text-3xl font-semibold text-stone-800">{{ $stats['services_total'] }}</p>
            <p class="mt-1 text-xs text-stone-500">{{ $stats['services_active'] }} aktif di website</p>
        </div>
        <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-stone-400">Total Portfolio</p>
            <p class="mt-2 text-3xl font-semibold text-stone-800">{{ $stats['portfolios_total'] }}</p>
            <p class="mt-1 text-xs text-emerald-700">{{ $stats['portfolios_published'] }} published</p>
        </div>
        <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-stone-400">Total Testimonial</p>
            <p class="mt-2 text-3xl font-semibold text-stone-800">{{ $stats['testimonials_total'] }}</p>
            <p class="mt-1 text-xs text-emerald-700">{{ $stats['testimonials_published'] }} published</p>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-[#C5A880] hover:shadow-md">
            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#2C3E35]/10 text-[#2C3E35]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="font-medium text-stone-800">Pengaturan Website</p>
                <p class="text-xs text-stone-500">Hero, tentang kami, kontak</p>
            </div>
        </a>
        <a href="{{ route('admin.services.index') }}" class="flex items-center gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-[#C5A880] hover:shadow-md">
            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#2C3E35]/10 text-[#2C3E35]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="font-medium text-stone-800">Kelola Layanan</p>
                <p class="text-xs text-stone-500">Tambah, urutan, aktifkan</p>
            </div>
        </a>
        <a href="{{ route('admin.portfolios.index') }}" class="flex items-center gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-[#C5A880] hover:shadow-md">
            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#2C3E35]/10 text-[#2C3E35]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="font-medium text-stone-800">Kelola Portfolio</p>
                <p class="text-xs text-stone-500">Tambah, edit, publish</p>
            </div>
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-4 rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-[#C5A880] hover:shadow-md">
            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#2C3E35]/10 text-[#2C3E35]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <div>
                <p class="font-medium text-stone-800">Kelola Testimonial</p>
                <p class="text-xs text-stone-500">Ulasan klien</p>
            </div>
        </a>
    </div>
@endsection
