<section id="kontak" class="py-20 bg-brand-cream">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-10 items-start">

            {{-- Intro --}}
            <div class="reveal reveal-left">

                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-3">
                    KONSULTASI
                </span>

                <h2 class="font-serif text-4xl sm:text-5xl font-semibold text-brand-forest leading-tight mb-5">
                    Wujudkan Ruang Impian Anda
                </h2>

                <div class="divider-grow origin-left w-16 h-[2px] bg-brand-gold mb-6" data-divider></div>

                <p class="text-stone-600 leading-relaxed mb-6">
                    Ceritakan kebutuhan ruang Anda kepada tim Bumiyuji Living.
                    Kami siap membantu memberikan solusi interior yang sesuai.
                </p>

                <div class="space-y-3 text-sm text-stone-600">

                    <div class="flex items-start gap-3">
                        <span class="text-brand-gold">✓</span>
                        <span>Konsultasi awal tanpa biaya</span>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-brand-gold">✓</span>
                        <span>Diskusi kebutuhan dan konsep ruang</span>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-brand-gold">✓</span>
                        <span>Terhubung langsung melalui WhatsApp</span>
                    </div>

                </div>

            </div>


            {{-- Form --}}
            <div class="form-card reveal reveal-right bg-[#F2EBDD] border border-[#B9A56F]/20 shadow-[0_12px_32px_-16px_rgba(48,72,63,0.25)] rounded-2xl p-6 sm:p-8 transition-shadow duration-500">

                <form id="appointment-form" onsubmit="handleFormSubmit(event)" class="space-y-5">

                    <div>

                        <label
                            for="form-name"
                            class="block text-sm font-medium text-brand-forest mb-2"
                        >
                            Nama
                        </label>

                        <input
                            id="form-name"
                            type="text"
                            required
                            class="w-full rounded-lg border border-[#DCD2BC] bg-gradient-to-b from-white to-brand-cream/50 px-4 py-3 text-sm outline-none transition-colors duration-300 focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="Nama lengkap"
                        >

                    </div>


                    <div>

                        <label
                            for="form-phone"
                            class="block text-sm font-medium text-brand-forest mb-2"
                        >
                            No. HP / WhatsApp
                        </label>

                        <input
                            id="form-phone"
                            type="tel"
                            required
                            class="w-full rounded-lg border border-[#DCD2BC] bg-gradient-to-b from-white to-brand-cream/50 px-4 py-3 text-sm outline-none transition-colors duration-300 focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="08xxxxxxxxxx"
                        >

                    </div>


                    <div>

                        <label
                            for="form-email"
                            class="block text-sm font-medium text-brand-forest mb-2"
                        >
                            Email <span class="text-stone-400">(opsional)</span>
                        </label>

                        <input
                            id="form-email"
                            type="email"
                            class="w-full rounded-lg border border-[#DCD2BC] bg-gradient-to-b from-white to-brand-cream/50 px-4 py-3 text-sm outline-none transition-colors duration-300 focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="email@contoh.com"
                        >

                    </div>


                    <div>

                        <label
                            for="form-address"
                            class="block text-sm font-medium text-brand-forest mb-2"
                        >
                            Alamat Proyek
                        </label>

                        <textarea
                            id="form-address"
                            rows="3"
                            required
                            class="w-full rounded-lg border border-[#DCD2BC] bg-gradient-to-b from-white to-brand-cream/50 px-4 py-3 text-sm outline-none resize-none transition-colors duration-300 focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="Lokasi proyek"
                        ></textarea>

                    </div>


                    <div>

                        <label
                            for="form-project"
                            class="block text-sm font-medium text-brand-forest mb-2"
                        >
                            Rencana Project
                        </label>

                        <textarea
                            id="form-project"
                            rows="4"
                            required
                            class="w-full rounded-lg border border-[#DCD2BC] bg-gradient-to-b from-white to-brand-cream/50 px-4 py-3 text-sm outline-none resize-none transition-colors duration-300 focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="Ceritakan kebutuhan interior Anda..."
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        class="btn-shine relative w-full overflow-hidden bg-brand-forest text-white font-semibold text-sm uppercase tracking-wide px-6 py-4 rounded-lg transition-all duration-300 hover:bg-[#4F6862] hover:-translate-y-0.5 hover:shadow-lg"
                    >
                        Kirim Konsultasi via WhatsApp
                    </button>

                </form>

            </div>


            {{-- Informasi Hub Korporat --}}
            <div class="reveal reveal-right">

                <h3 class="font-serif text-2xl font-semibold text-brand-forest mb-2">
                    Informasi Hub Korporat
                </h3>

                <div class="divider-grow origin-left w-16 h-[2px] bg-brand-gold mb-6" data-divider></div>

                <div class="space-y-5">

                    {{-- Kantor Utama (Pusat & Logistik) --}}
                    @if (!empty($settings['address']))
                        <div class="flex items-start gap-4">

                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/10 text-brand-forest">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M9 13h.01M15 10h.01M15 13h.01" />
                                </svg>
                            </span>

                            <div>
                                <span class="block text-[11px] font-semibold tracking-widest text-brand-gold uppercase mb-1">
                                    Kantor Utama (Pusat &amp; Logistik)
                                </span>
                                <p class="text-sm font-semibold text-brand-forest leading-snug">
                                    {{ $settings['address'] }}
                                </p>
                                @if (!empty($settings['address_note']))
                                    <p class="text-xs text-stone-500 mt-1">
                                        {{ $settings['address_note'] }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    @endif

                    {{-- Kantor Operasional & Administrasi --}}
                    @if (!empty($settings['secondary_address']))
                        <div class="flex items-start gap-4">

                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/10 text-brand-forest">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>

                            <div>
                                <span class="block text-[11px] font-semibold tracking-widest text-brand-gold uppercase mb-1">
                                    Kantor Operasional &amp; Administrasi
                                </span>
                                <p class="text-sm font-semibold text-brand-forest leading-snug">
                                    {{ $settings['secondary_address'] }}
                                </p>
                                @if (!empty($settings['secondary_address_note']))
                                    <p class="text-xs text-stone-500 mt-1">
                                        {{ $settings['secondary_address_note'] }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    @endif

                    {{-- WhatsApp Hotline --}}
                    <div class="flex items-start gap-4">

                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/10 text-brand-forest">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.001 2C6.478 2 2 6.477 2 12c0 1.9.526 3.68 1.44 5.2L2 22l4.94-1.396A9.95 9.95 0 0012.001 22C17.524 22 22 17.523 22 12S17.524 2 12.001 2zm0 18.2a8.15 8.15 0 01-4.35-1.26l-.312-.19-3.033.858.834-2.958-.202-.318A8.15 8.15 0 013.85 12c0-4.5 3.65-8.15 8.151-8.15 4.5 0 8.15 3.65 8.15 8.15 0 4.501-3.65 8.2-8.15 8.2z"/>
                            </svg>
                        </span>

                        <div>
                            <span class="block text-[11px] font-semibold tracking-widest text-brand-gold uppercase mb-1">
                                WhatsApp Hotline (Kantor Utama)
                            </span>
                            <p class="text-sm font-semibold text-brand-forest leading-snug">
                                {{ $settings['wa_number'] ?? '0813 1111 4523' }}
                            </p>
                            @if (!empty($settings['office_hours']))
                                <p class="text-xs text-stone-500 mt-1">
                                    {{ $settings['office_hours'] }}
                                </p>
                            @endif
                        </div>

                    </div>

                    {{-- Email --}}
                    @if (!empty($settings['email']))
                        <div class="flex items-start gap-4">

                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-gold/10 text-brand-forest">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>

                            <div>
                                <span class="block text-[11px] font-semibold tracking-widest text-brand-gold uppercase mb-1">
                                    Surel Rekanan &amp; Bisnis
                                </span>
                                <p class="text-sm font-semibold text-brand-forest leading-snug">
                                    {{ $settings['email'] }}
                                </p>
                            </div>

                        </div>
                    @endif

                </div>


                {{-- Peta Lokasi --}}
                @php
                    $mapsQueryAddress = trim(($settings['address'] ?? '').' '.($settings['address_note'] ?? ''));
                    $mapsOpenUrl = !empty($settings['maps_url'])
                        ? $settings['maps_url']
                        : ($mapsQueryAddress ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($mapsQueryAddress) : null);
                    $mapsEmbedUrl = $mapsQueryAddress ? 'https://www.google.com/maps?q='.urlencode($mapsQueryAddress).'&output=embed' : null;
                @endphp
                @if ($mapsEmbedUrl)
                    <div class="relative mt-6 rounded-2xl overflow-hidden border border-stone-200 h-[260px]">

                        @if ($mapsOpenUrl)
                            <a
                                href="{{ $mapsOpenUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="absolute top-3 left-3 z-10 inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-brand-forest shadow-md hover:bg-white transition"
                            >
                                Buka di Maps
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif

                        <iframe
                            title="Lokasi Kantor Bumiyuji Living"
                            src="{{ $mapsEmbedUrl }}"
                            width="100%"
                            height="100%"
                            style="border:0"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                            class="w-full h-full"
                        ></iframe>

                    </div>
                @endif

            </div>

        </div>

    </div>

</section>
