<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin BumiYuji</title>
    @vite(['resources/css/app.css'])


<!-- Font Manrope -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    [x-cloak] {
        display: none !important;
    }

    html,
    body {
        font-family: 'Manrope', sans-serif;
    }

</style>
</head>
<body class="min-h-screen bg-stone-100 text-stone-800 antialiased font-sans">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-[#2C3E35] text-white transition-transform duration-200 lg:static lg:translate-x-0">
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#C5A880] text-sm font-bold text-[#2C3E35]">BY</div>
                <div>
                    <p class="text-sm font-semibold tracking-wide">BumiYuji</p>
                    <p class="text-xs text-white/60">Admin CMS</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                @php $isActive = fn (string $pattern) => request()->routeIs($pattern); @endphp

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.dashboard') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.services.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.services.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Layanan
                </a>

                <a href="{{ route('admin.portfolios.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.portfolios.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Portfolio
                </a>

                <a href="{{ route('admin.workflows.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.workflows.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="6" height="4" rx="1"/>
                        <rect x="15" y="17" width="6" height="4" rx="1"/>
                        <rect x="15" y="3" width="6" height="4" rx="1"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h3a3 3 0 013 3v9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5h-3"/>
                    </svg>
                    Alur Kerja
                </a>

                <a href="{{ route('admin.team-profiles.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.team-profiles.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20a4 4 0 00-8 0m4-4a4 4 0 100-8 4 4 0 000 8zm6 4a3 3 0 00-3-3m3 3a3 3 0 003-3 3 3 0 00-3-3m-12 6a3 3 0 01-3-3 3 3 0 013-3"/></svg>
                    Our Team
                </a>

                <a href="{{ route('admin.client-partners.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.client-partners.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Klien & Mitra
                </a>

                <a href="{{ route('admin.affiliated-divisions.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.affiliated-divisions.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m16 0h-4m-6 0h4M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1"/></svg>
                    Divisi Terafiliasi
                </a>

                <a href="{{ route('admin.testimonials.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.testimonials.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Testimonial
                </a>

                <a href="{{ route('admin.settings.edit') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.settings.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan Website
                </a>
            </nav>

            <div class="border-t border-white/10 p-3">
                <div class="mb-2 truncate px-3 text-xs text-white/50">{{ Auth::guard('admin')->user()?->name ?? 'Admin' }}</div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-stone-200 bg-white px-4 shadow-sm lg:px-8">
                <button type="button" @click="sidebarOpen = true" class="rounded-lg p-2 text-stone-500 hover:bg-stone-100 lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-stone-800">@yield('title', 'Dashboard')</h1>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="font-medium">Terjadi kesalahan validasi:</p>
                        <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
