@extends('admin.layout')

@section('title', 'Riwayat Perubahan')

@section('content')
    <p class="mb-4 text-sm text-stone-500">Semua perubahan (tambah, ubah, hapus) yang dilakukan admin di CMS ini, terbaru di atas.</p>

    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">
        <ul class="divide-y divide-stone-100">
            @forelse ($activities as $activity)
                <li class="flex items-start gap-3 px-4 py-3.5">
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2C3E35]/10 text-xs font-bold text-[#2C3E35]">
                        {{ strtoupper(substr($activity->admin_name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-stone-800">
                            <span class="font-semibold">{{ $activity->admin_name }}</span>
                            {{ $activity->description }}
                        </p>
                        <p class="mt-0.5 flex flex-wrap items-center gap-x-1.5 gap-y-0.5 text-xs text-stone-400">
                            <span>{{ $activity->created_at_wib->translatedFormat('d M Y, H:i:s') }} WIB</span>
                            <span>&middot; {{ $activity->created_at_wib->diffForHumans(now('Asia/Jakarta')) }}</span>
                            @if ($activity->device)
                                <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 px-2 py-0.5 text-stone-500">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                                    {{ $activity->device }}
                                </span>
                            @endif
                        </p>
                    </div>
                </li>
            @empty
                <li class="px-4 py-12 text-center text-sm text-stone-400">Belum ada riwayat perubahan.</li>
            @endforelse
        </ul>
    </div>

    @if ($activities->hasPages())
        <div class="mt-4">{{ $activities->links() }}</div>
    @endif
@endsection
