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
    <div class="flex min-h-screen"
         x-data="adminNotifications({{ (int) ($adminUnreadActivityCount ?? 0) }})"
         x-init="startPolling()">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

        <!-- Notifikasi live: muncul tiap ada admin lain melakukan perubahan (CRUD saja) -->
        <div class="pointer-events-none fixed right-4 top-20 z-[70] flex w-full max-w-sm flex-col gap-2">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.visible" x-transition
                     class="pointer-events-auto relative rounded-lg border border-emerald-300 bg-emerald-100 py-3 pl-4 pr-8 text-sm text-emerald-900 shadow-lg">
                    <button type="button" @click="dismissToast(toast.id)"
                            class="absolute right-1.5 top-1.5 rounded p-1 text-emerald-700/70 hover:bg-emerald-200 hover:text-emerald-900"
                            aria-label="Tutup notifikasi">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <p class="font-semibold" x-text="toast.admin_name"></p>
                    <p class="mt-0.5 text-emerald-800" x-text="toast.description"></p>
                    <p class="mt-1 text-xs text-emerald-700/80" x-show="toast.device" x-text="toast.device"></p>
                </div>
            </template>
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-[#2C3E35] text-white transition-transform duration-200 lg:static lg:translate-x-0">
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#C5A880] text-sm font-bold text-[#2C3E35]">
                    {{ Auth::guard('admin')->user() ? strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) : 'A' }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold tracking-wide">Halo, {{ Auth::guard('admin')->user()?->name ?? 'Admin' }}</p>
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

                <a href="{{ route('admin.faqs.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.faqs.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    FAQ
                </a>

                <a href="{{ route('admin.activities.index') }}"
                   class="flex items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.activities.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex items-center gap-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Riwayat Perubahan
                    </span>
                    <span x-show="unreadCount > 0" x-cloak x-text="unreadCount" class="flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-[#C5A880] px-1 text-[11px] font-bold text-[#2C3E35]"></span>
                </a>

                @if (Auth::guard('admin')->user()?->isSuperAdmin())
                    <a href="{{ route('admin.admins.index') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.admins.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 8v4m2-2h-4"/></svg>
                        Kelola Admin
                    </a>
                @endif

                <a href="{{ route('admin.settings.edit') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive('admin.settings.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan Website

                </a>
                <a href="{{ url('/') }}"
   target="_blank"
   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
    <i class="fa-solid fa-globe w-5 text-center"></i>
    <span>Cek Website</span>
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

                <div class="relative ml-auto" @click.outside="closeNotifications()">
                    <button type="button" @click="toggleNotifications()"
                            class="relative rounded-lg p-2 text-stone-500 hover:bg-stone-100" title="Notifikasi perubahan">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        <span x-show="unreadCount > 0" x-cloak x-text="unreadCount > 9 ? '9+' : unreadCount"
                              class="absolute -right-0.5 -top-0.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white"></span>
                    </button>

                    <!-- Dropdown notifikasi: posisi absolute relatif ke bell, di atas header (z-50),
                         tinggi dibatasi + scroll sendiri supaya daftar panjang tidak menumpuk/tertutup. -->
                    <div x-show="notificationsOpen" x-cloak x-transition
                         class="absolute right-0 top-full z-50 mt-2 w-80 max-w-[90vw] overflow-hidden rounded-xl border border-stone-200 bg-white shadow-lg sm:w-96">
                        <div class="flex items-center justify-between border-b border-stone-100 px-4 py-3">
                            <p class="text-sm font-semibold text-stone-800">Notifikasi Perubahan</p>
                            <a href="{{ route('admin.activities.index') }}" class="text-xs font-medium text-[#2C3E35] hover:underline">Lihat semua</a>
                        </div>

                        <ul class="max-h-96 divide-y divide-stone-100 overflow-y-auto">
                            <template x-for="item in recentActivities" :key="item.id">
                                <li class="flex items-start gap-3 px-4 py-3">
                                    <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#2C3E35]/10 text-[11px] font-bold text-[#2C3E35]"
                                         x-text="item.admin_name.charAt(0).toUpperCase()"></div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm text-stone-800">
                                            <span class="font-semibold" x-text="item.admin_name"></span>
                                            <span x-text="' ' + item.description"></span>
                                        </p>
                                        <p class="mt-0.5 flex flex-wrap items-center gap-x-1.5 text-[11px] text-stone-400">
                                            <span x-text="item.created_at + ' WIB'"></span>
                                            <span x-text="'· ' + item.time_ago"></span>
                                            <span x-show="item.device" x-text="'· ' + item.device"></span>
                                        </p>
                                    </div>
                                </li>
                            </template>

                            <li x-show="recentActivities.length === 0" class="px-4 py-8 text-center text-sm text-stone-400">
                                Belum ada perubahan.
                            </li>
                        </ul>
                    </div>
                </div>
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
    <script>
        function adminNotifications(initialUnreadCount) {
            return {
                sidebarOpen: false,
                notificationsOpen: false,
                unreadCount: initialUnreadCount,
                recentActivities: [],
                toasts: [],
                seenIds: [],
                // Batas toast yang tampil bersamaan — mencegah menumpuk kalau
                // banyak perubahan terjadi beruntun di satu siklus polling.
                maxToasts: 4,
                startPolling() {
                    this.poll();
                    // Poll tiap 20 detik — cukup responsif tanpa membebani shared hosting.
                    setInterval(() => this.poll(), 20000);
                },
                poll() {
                    fetch('{{ route('admin.activities.latest') }}', {
                        headers: { 'Accept': 'application/json' },
                    })
                        .then(res => res.ok ? res.json() : null)
                        .then(data => {
                            if (!data) return;
                            this.unreadCount = data.unread_count;
                            this.recentActivities = data.recent ?? [];

                            data.items.forEach(item => {
                                if (this.seenIds.includes(item.id)) return;
                                this.seenIds.push(item.id);
                                this.showToast(item);
                            });
                        })
                        .catch(() => {});
                },
                showToast(item) {
                    const toast = {
                        id: item.id,
                        admin_name: item.admin_name,
                        description: item.description,
                        device: item.device,
                        visible: true,
                    };
                    this.toasts.push(toast);

                    // Buang toast paling lama duluan kalau melebihi batas,
                    // supaya tidak menumpuk memenuhi layar.
                    while (this.toasts.length > this.maxToasts) {
                        this.toasts.shift();
                    }

                    // Hilang otomatis setelah 4 detik (bisa juga ditutup manual
                    // lewat tombol × — lihat dismissToast()).
                    toast.timer = setTimeout(() => this.dismissToast(toast.id), 4000);
                },
                dismissToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (!toast || !toast.visible) return;

                    clearTimeout(toast.timer);
                    toast.visible = false;

                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                },
                toggleNotifications() {
                    this.notificationsOpen = !this.notificationsOpen;

                    if (this.notificationsOpen) {
                        this.unreadCount = 0;

                        fetch('{{ route('admin.activities.mark-read') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        }).catch(() => {});
                    }
                },
                closeNotifications() {
                    this.notificationsOpen = false;
                },
            };
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
