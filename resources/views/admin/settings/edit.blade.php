@extends('admin.layout')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="mb-6"><p class="text-sm text-stone-500">Ubah konten website tanpa mengedit kode.</p></div>

    @if ($setting->updated_at)
        <div class="mb-6 rounded-lg border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-600">
            Terakhir diubah oleh <span class="font-medium text-stone-800">{{ optional($setting->updatedBy)->name ?? 'tidak diketahui' }}</span>
            &middot; {{ $setting->updated_at->diffForHumans() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Logo &amp; Branding</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="site_name" class="mb-1.5 block text-sm font-medium text-stone-700">Nama Brand</label>
                    <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $setting->site_name) }}" placeholder="Bumiyuji Living"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                    <p class="mt-1 text-xs text-stone-400">Ditampilkan di navbar &amp; footer saat tidak ada logo, atau sebagai teks pendamping logo.</p>
                </div>
                <div class="sm:col-span-2">
                    <label for="logo" class="mb-1.5 block text-sm font-medium text-stone-700">Logo Website</label>
                    @if ($setting->logo)
                        <div class="mb-3 flex items-center gap-4">
                            <div class="flex h-20 w-40 items-center justify-center rounded-lg border border-stone-200 bg-brand-cream/40 p-3" style="background:#F9F6F0">
                                <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="max-h-14 w-auto object-contain">
                            </div>
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_logo" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus logo
                            </label>
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    <p class="mt-1 text-xs text-stone-400">JPEG, PNG, WebP, atau SVG. Maks 15 MB. Jika kosong, navbar akan menampilkan nama brand sebagai teks.</p>
                </div>

                <div class="sm:col-span-2 border-t border-stone-100 pt-5">
                    <label for="favicon" class="mb-1.5 block text-sm font-medium text-stone-700">Favicon Website</label>
                    <p class="mb-3 text-xs text-stone-400">Ikon kecil yang tampil pada tab browser dan bookmark website.</p>

                    @if ($setting->favicon)
                        <div class="mb-3 flex items-center gap-4 rounded-lg border border-stone-200 bg-stone-50 p-3">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-stone-200 bg-white p-2">
                                <img src="{{ Storage::url($setting->favicon) }}" alt="Favicon Website" class="h-full w-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-stone-800">Favicon saat ini</p>
                                <p class="mt-0.5 truncate text-xs text-stone-400">{{ basename($setting->favicon) }}</p>
                            </div>
                            <label class="flex shrink-0 cursor-pointer items-center gap-2 text-sm text-red-600">
                                <input type="checkbox" name="remove_favicon" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus
                            </label>
                        </div>
                    @endif

                    <input type="file" name="favicon" id="favicon" accept=".svg,.png,.ico,.jpg,.jpeg,.webp"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    <p class="mt-1 text-xs text-stone-400">SVG, PNG, ICO, JPG, JPEG, atau WEBP. Maks 2 MB. Ukuran ideal 32x32px atau 512x512px (persegi).</p>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Hero</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="hero_title" class="mb-1.5 block text-sm font-medium text-stone-700">Judul Hero</label>
                    <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $setting->hero_title) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="hero_subtitle" class="mb-1.5 block text-sm font-medium text-stone-700">Subtitle Hero</label>
                    <input type="text" name="hero_subtitle" id="hero_subtitle" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2" x-data="heroSlideManager({
                        slides: @js($heroSlides->map(fn ($s) => ['id' => $s->id, 'url' => Storage::url($s->image), 'sort_order' => $s->sort_order])->values()),
                        storeUrl: @js(route('admin.settings.hero-slides.store')),
                        reorderUrl: @js(route('admin.settings.hero-slides.reorder')),
                        replaceUrlTemplate: @js(route('admin.settings.hero-slides.update', ':id')),
                        destroyUrlTemplate: @js(route('admin.settings.hero-slides.destroy', ':id')),
                    })">
                    <label class="mb-1.5 block text-sm font-medium text-stone-700">Gambar Hero</label>
                    <div class="flex flex-wrap items-center gap-4 rounded-lg border border-stone-200 bg-stone-50 p-3">
                        <div class="flex h-16 w-28 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-stone-200 bg-white">
                            <template x-if="slides.length">
                                <img :src="slides[0].url" alt="Preview Hero" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!slides.length">
                                <span class="px-2 text-center text-[11px] leading-tight text-stone-400">Belum ada gambar</span>
                            </template>
                        </div>
                        <p class="text-sm text-stone-600" x-text="slides.length + ' gambar tersedia'"></p>
                        <button type="button" @click="open()"
                                class="ml-auto rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-medium text-stone-700 shadow-sm hover:bg-stone-100">
                            Atur Gambar
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-stone-400">Slideshow otomatis Hero homepage. Dikelola terpisah dari tombol Simpan Perubahan di bawah &mdash; setiap perubahan pada gambar langsung tersimpan.</p>

                    <template x-teleport="body">
                        <div x-show="modalOpen" x-cloak
                             @keydown.escape.window="close()"
                             class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="absolute inset-0 bg-black/50" @click="close()"></div>

                            <div class="relative flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-xl bg-white shadow-2xl">
                                <div class="flex items-start justify-between border-b border-stone-100 px-6 py-4">
                                    <div>
                                        <h3 class="text-base font-semibold text-stone-800">Atur Gambar Hero</h3>
                                        <p class="mt-0.5 text-xs text-stone-500">Kelola gambar yang ditampilkan pada Hero homepage. Tarik gambar untuk mengubah urutan tampilan.</p>
                                    </div>
                                    <button type="button" @click="close()" class="rounded-lg p-1.5 text-stone-400 hover:bg-stone-100 hover:text-stone-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <div class="flex-1 overflow-y-auto px-6 py-5">
                                    <template x-if="errorMessage">
                                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm text-red-700" x-text="errorMessage"></div>
                                    </template>

                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2C3E35] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]"
                                           :class="uploading && 'pointer-events-none opacity-60'">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span x-text="uploading ? 'Mengunggah...' : '+ Upload Gambar'"></span>
                                        <input type="file" class="hidden" multiple accept="image/jpeg,image/png,image/webp"
                                               @change="uploadFiles($event.target.files); $event.target.value = ''">
                                    </label>

                                    <template x-if="!slides.length">
                                        <p class="mt-6 text-center text-sm text-stone-400">Belum ada gambar Hero. Unggah gambar pertama Anda.</p>
                                    </template>

                                    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4" x-ref="grid">
                                        <template x-for="(slide, index) in slides" :key="slide.id">
                                            <div class="group relative rounded-lg border border-stone-200 bg-stone-50 p-2 shadow-sm"
                                                 :data-id="slide.id">
                                                <div class="relative flex aspect-video w-full cursor-move items-center justify-center overflow-hidden rounded-md border border-stone-200 bg-white drag-handle">
                                                    <img :src="slide.url" alt="Gambar Hero" class="h-full w-full object-cover">
                                                    <div x-show="slide.busy" class="absolute inset-0 flex items-center justify-center bg-white/70">
                                                        <svg class="h-5 w-5 animate-spin text-stone-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                                                    </div>
                                                </div>
                                                <p class="mt-1.5 flex items-center gap-1 text-[11px] font-medium text-stone-500">
                                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                                    Urutan <span x-text="index + 1"></span>
                                                </p>
                                                <div class="mt-2 flex gap-1.5">
                                                    <label class="flex-1 cursor-pointer rounded-md border border-stone-300 bg-white px-2 py-1.5 text-center text-xs font-medium text-stone-700 hover:bg-stone-100">
                                                        Ganti
                                                        <input type="file" class="hidden" accept="image/jpeg,image/png,image/webp"
                                                               @change="replaceSlide(slide, $event.target.files[0]); $event.target.value = ''">
                                                    </label>
                                                    <button type="button" @click="deleteSlide(slide)"
                                                            class="flex-1 rounded-md border border-red-200 bg-white px-2 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="flex justify-end border-t border-stone-100 px-6 py-4">
                                    <button type="button" @click="close()" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">
                                        Tutup / Selesai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Tentang Kami</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="about_title" class="mb-1.5 block text-sm font-medium text-stone-700">Judul</label>
                    <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $setting->about_title) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="about_description" class="mb-1.5 block text-sm font-medium text-stone-700">Deskripsi</label>
                    <textarea name="about_description" id="about_description" rows="4"
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('about_description', $setting->about_description) }}</textarea>
                </div>
                <div>
                    <label for="about_vision" class="mb-1.5 block text-sm font-medium text-stone-700">Visi</label>
                    <textarea name="about_vision" id="about_vision" rows="3"
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('about_vision', $setting->about_vision) }}</textarea>
                </div>
                <div>
                    <label for="about_mission" class="mb-1.5 block text-sm font-medium text-stone-700">Misi</label>
                    <textarea name="about_mission" id="about_mission" rows="3"
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('about_mission', $setting->about_mission) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label for="about_image" class="mb-1.5 block text-sm font-medium text-stone-700">Gambar Tentang Kami</label>
                    @if ($setting->about_image)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ Storage::url($setting->about_image) }}" alt="About" class="h-24 w-40 rounded-lg object-cover border border-stone-200">
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_about_image" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus gambar
                            </label>
                        </div>
                    @endif
                    <input type="file" name="about_image" id="about_image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                </div>
                <div class="sm:col-span-2">
                    <label for="about_video" class="mb-1.5 block text-sm font-medium text-stone-700">Video Karya Kami (upload)</label>
                    <p class="mb-2 text-xs text-stone-500">
                        Format MP4/WebM/MOV, maksimal 50MB. Jika video ini diisi, video akan tampil menggantikan link YouTube di beranda.
                        Disarankan resolusi 1080p ke bawah dan file sudah dikompres agar cepat dimuat.
                    </p>
                    @if ($setting->about_video)
                        <div class="mb-3 flex items-center gap-4">
                            <video src="{{ Storage::url($setting->about_video) }}" class="h-24 w-40 rounded-lg object-cover border border-stone-200" muted></video>
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_about_video" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus video
                            </label>
                        </div>
                    @endif
                    <input type="file" name="about_video" id="about_video" accept="video/mp4,video/webm,video/quicktime"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    @error('about_video')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Divisi Terafiliasi &mdash; Perusahaan Induk</h2>
            <p class="mb-4 text-xs text-stone-500">
                Data ini tampil sebagai header di atas daftar Divisi Terafiliasi pada footer website
                (identitas ekosistem perusahaan). Daftar divisinya sendiri dikelola di menu Divisi Terafiliasi.
            </p>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="parent_company_logo" class="mb-1.5 block text-sm font-medium text-stone-700">Logo Perusahaan Induk</label>
                    @if ($setting->parent_company_logo)
                        <div class="mb-3 flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full border border-stone-200 bg-brand-cream/40 p-2" style="background:#F9F6F0">
                                <img src="{{ Storage::url($setting->parent_company_logo) }}" alt="Logo Perusahaan Induk" class="h-full w-full object-contain">
                            </div>
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_parent_company_logo" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus logo
                            </label>
                        </div>
                    @endif
                    <input type="file" name="parent_company_logo" id="parent_company_logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    <p class="mt-1 text-xs text-stone-400">JPEG, PNG, WEBP, atau SVG. Maks 15 MB. Jika kosong, akan ditampilkan inisial sebagai fallback.</p>
                    @error('parent_company_logo')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="parent_company_name" class="mb-1.5 block text-sm font-medium text-stone-700">Nama Perusahaan Induk</label>
                    <input type="text" name="parent_company_name" id="parent_company_name" value="{{ old('parent_company_name', $setting->parent_company_name) }}" placeholder="PT Arada Integra Indonesia"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div>
                    <label for="parent_company_brand" class="mb-1.5 block text-sm font-medium text-stone-700">Brand / Alias</label>
                    <input type="text" name="parent_company_brand" id="parent_company_brand" value="{{ old('parent_company_brand', $setting->parent_company_brand) }}" placeholder="Artersia"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="ecosystem_intro" class="mb-1.5 block text-sm font-medium text-stone-700">Teks Intro Ekosistem</label>
                    <textarea name="ecosystem_intro" id="ecosystem_intro" rows="2" maxlength="1000" placeholder="Satu ekosistem, beragam keahlian, terhubung dalam sinergi yang berkelanjutan."
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('ecosystem_intro', $setting->ecosystem_intro) }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Kontak</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact_whatsapp" class="mb-1.5 block text-sm font-medium text-stone-700">WhatsApp</label>
                    <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp', $setting->contact_whatsapp) }}" placeholder="62812xxxxxxxx"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div>
                    <label for="contact_email" class="mb-1.5 block text-sm font-medium text-stone-700">Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $setting->contact_email) }}"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="office_hours" class="mb-1.5 block text-sm font-medium text-stone-700">Jam Operasional</label>
                    <input type="text" name="office_hours" id="office_hours" value="{{ old('office_hours', $setting->office_hours) }}" placeholder="Senin - Sabtu (08:00 - 17:00 WIB)"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                    <p class="mt-1 text-xs text-stone-400">Ditampilkan di bawah nomor WhatsApp pada halaman Kontak.</p>
                </div>
            </div>

            <div class="mt-6 border-t border-stone-100 pt-5">
                <h3 class="mb-1 text-sm font-semibold text-stone-800">Kantor Utama (Pusat &amp; Logistik)</h3>
                <p class="mb-3 text-xs text-stone-400">Alamat ini juga dipakai untuk peta lokasi di halaman Kontak.</p>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="contact_address" class="mb-1.5 block text-sm font-medium text-stone-700">Alamat</label>
                        <textarea name="contact_address" id="contact_address" rows="2" placeholder="Jln. Pelabuhan II No.89B Citamiang Kota Sukabumi"
                                  class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('contact_address', $setting->contact_address) }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="contact_address_note" class="mb-1.5 block text-sm font-medium text-stone-700">Keterangan Alamat</label>
                        <input type="text" name="contact_address_note" id="contact_address_note" value="{{ old('contact_address_note', $setting->contact_address_note) }}" placeholder="Kec. Citamiang, Kota Sukabumi, Jawa Barat"
                               class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-stone-100 pt-5">
                <h3 class="mb-1 text-sm font-semibold text-stone-800">Kantor Operasional &amp; Administrasi</h3>
                <p class="mb-3 text-xs text-stone-400">Kosongkan jika hanya punya satu kantor — bagian ini otomatis disembunyikan di halaman publik.</p>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="secondary_address" class="mb-1.5 block text-sm font-medium text-stone-700">Alamat</label>
                        <textarea name="secondary_address" id="secondary_address" rows="2" placeholder="Jln. Ciaul Pasir Cisarua - Cikole, Jingga Residence Blok B23"
                                  class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('secondary_address', $setting->secondary_address) }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="secondary_address_note" class="mb-1.5 block text-sm font-medium text-stone-700">Keterangan Alamat</label>
                        <input type="text" name="secondary_address_note" id="secondary_address_note" value="{{ old('secondary_address_note', $setting->secondary_address_note) }}" placeholder="Kota Sukabumi - Jabar 43115"
                               class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-stone-100 pt-5">
                <label for="contact_maps_url" class="mb-1.5 block text-sm font-medium text-stone-700">Google Maps URL</label>
                <input type="url" name="contact_maps_url" id="contact_maps_url" value="{{ old('contact_maps_url', $setting->contact_maps_url) }}" placeholder="https://maps.google.com/..."
                       class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                <p class="mt-1 text-xs text-stone-400">Dipakai untuk tombol "Buka di Maps". Peta yang tertanam di halaman otomatis dibuat dari alamat Kantor Utama di atas.</p>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Social Media</h2>
            @php $social = $setting->social_links ?? []; @endphp
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="social_instagram" class="mb-1.5 block text-sm font-medium text-stone-700">Instagram</label>
                    <input type="url" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $social['instagram'] ?? '') }}" placeholder="https://instagram.com/..."
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div>
                    <label for="social_facebook" class="mb-1.5 block text-sm font-medium text-stone-700">Facebook</label>
                    <input type="url" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $social['facebook'] ?? '') }}" placeholder="https://facebook.com/..."
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div>
                    <label for="social_tiktok" class="mb-1.5 block text-sm font-medium text-stone-700">TikTok</label>
                    <input type="url" name="social_tiktok" id="social_tiktok" value="{{ old('social_tiktok', $social['tiktok'] ?? '') }}" placeholder="https://tiktok.com/@..."
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div>
                    <label for="social_youtube" class="mb-1.5 block text-sm font-medium text-stone-700">YouTube</label>
                    <input type="url" name="social_youtube" id="social_youtube" value="{{ old('social_youtube', $social['youtube'] ?? '') }}" placeholder="https://youtube.com/..."
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-base font-semibold text-stone-800">Appointment / Booking</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="appointment_whatsapp_number" class="mb-1.5 block text-sm font-medium text-stone-700">Nomor WhatsApp Tujuan</label>
                    <input type="text" name="appointment_whatsapp_number" id="appointment_whatsapp_number"
                           value="{{ old('appointment_whatsapp_number', $setting->appointment_whatsapp_number) }}" placeholder="62812xxxxxxxx"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="appointment_message_template" class="mb-1.5 block text-sm font-medium text-stone-700">Template Pesan</label>
                    <textarea name="appointment_message_template" id="appointment_message_template" rows="4"
                              class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('appointment_message_template', $setting->appointment_message_template) }}</textarea>
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c]">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
    <script>
        function heroSlideManager(config) {
            return {
                slides: (config.slides || []).map((s) => ({ ...s, busy: false })),
                storeUrl: config.storeUrl,
                reorderUrl: config.reorderUrl,
                replaceUrlTemplate: config.replaceUrlTemplate,
                destroyUrlTemplate: config.destroyUrlTemplate,
                modalOpen: false,
                uploading: false,
                errorMessage: '',
                sortable: null,

                csrfToken() {
                    return document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');
                },

                open() {
                    this.modalOpen = true;
                    this.errorMessage = '';
                    this.$nextTick(() => this.initSortable());
                },

                close() {
                    this.modalOpen = false;
                },

                initSortable() {
                    if (this.sortable || !this.$refs.grid || typeof Sortable === 'undefined') {
                        return;
                    }

                    this.sortable = Sortable.create(this.$refs.grid, {
                        handle: '.drag-handle',
                        animation: 150,
                        ghostClass: 'opacity-40',
                        onEnd: () => {
                            const ids = Array.from(this.$refs.grid.children).map((el) => Number(el.dataset.id));
                            this.slides = ids.map((id) => this.slides.find((s) => s.id === id));
                            this.persistOrder(ids);
                        },
                    });
                },

                async persistOrder(ids) {
                    try {
                        const res = await fetch(this.reorderUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                            body: JSON.stringify({ order: ids }),
                        });

                        if (!res.ok) {
                            throw new Error();
                        }
                    } catch (e) {
                        this.errorMessage = 'Gagal menyimpan urutan gambar. Coba lagi.';
                    }
                },

                async uploadFiles(fileList) {
                    if (!fileList || !fileList.length) {
                        return;
                    }

                    this.uploading = true;
                    this.errorMessage = '';

                    const formData = new FormData();
                    Array.from(fileList).forEach((file) => formData.append('images[]', file));

                    try {
                        const res = await fetch(this.storeUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                            body: formData,
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            throw new Error(data.message || 'Gagal mengunggah gambar.');
                        }

                        data.slides.forEach((s) => this.slides.push({ ...s, busy: false }));
                        this.$nextTick(() => this.initSortable());
                    } catch (e) {
                        this.errorMessage = e.message || 'Gagal mengunggah gambar.';
                    } finally {
                        this.uploading = false;
                    }
                },

                async replaceSlide(slide, file) {
                    if (!file) {
                        return;
                    }

                    slide.busy = true;
                    this.errorMessage = '';

                    const formData = new FormData();
                    formData.append('image', file);

                    try {
                        const res = await fetch(this.replaceUrlTemplate.replace(':id', slide.id), {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                            body: formData,
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            throw new Error(data.message || 'Gagal mengganti gambar.');
                        }

                        slide.url = data.slide.url + '?t=' + Date.now();
                    } catch (e) {
                        this.errorMessage = e.message || 'Gagal mengganti gambar.';
                    } finally {
                        slide.busy = false;
                    }
                },

                async deleteSlide(slide) {
                    if (!confirm('Apakah Anda yakin ingin menghapus gambar Hero ini?')) {
                        return;
                    }

                    slide.busy = true;
                    this.errorMessage = '';

                    try {
                        const res = await fetch(this.destroyUrlTemplate.replace(':id', slide.id), {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                        });

                        if (!res.ok) {
                            const data = await res.json().catch(() => ({}));
                            throw new Error(data.message || 'Gagal menghapus gambar.');
                        }

                        this.slides = this.slides.filter((s) => s.id !== slide.id);
                    } catch (e) {
                        this.errorMessage = e.message || 'Gagal menghapus gambar.';
                        slide.busy = false;
                    }
                },
            };
        }
    </script>
@endsection