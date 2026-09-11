@extends('admin.layout')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="mb-6"><p class="text-sm text-stone-500">Ubah konten website tanpa mengedit kode.</p></div>

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
                <div class="sm:col-span-2">
                    <label for="hero_image" class="mb-1.5 block text-sm font-medium text-stone-700">Gambar Hero</label>
                    @if ($setting->hero_image)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ Storage::url($setting->hero_image) }}" alt="Hero" class="h-24 w-40 rounded-lg object-cover border border-stone-200">
                            <label class="flex items-center gap-2 text-sm text-stone-600">
                                <input type="checkbox" name="remove_hero_image" value="1" class="rounded border-stone-300 text-red-600 focus:ring-red-500"> Hapus gambar
                            </label>
                        </div>
                    @endif
                    <input type="file" name="hero_image" id="hero_image" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-sm text-stone-500 file:mr-4 file:rounded-lg file:border-0 file:bg-stone-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200">
                    <p class="mt-1 text-xs text-stone-400">JPEG, PNG, WebP. Maks 15 MB.</p>
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
@endsection
