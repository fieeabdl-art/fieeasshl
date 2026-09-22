<section id="portofolio" class="py-20 bg-brand-cream">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-12 reveal">

            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">
                GALERI PROYEK
            </span>

            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">
                PORTOFOLIO KAMI
            </h2>

            <p class="text-stone-500 leading-relaxed">
                Beberapa karya dan proyek interior yang telah kami kerjakan.
            </p>

        </div>


        {{-- Filter --}}
     <div
            class="reveal flex flex-wrap justify-center items-center gap-2 mb-12"
            id="portfolio-filters"
        >

            <button
                type="button"
                class="portfolio-filter px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-forest text-white transition"
                data-filter="all"
            >
                Semua
            </button>

            <button
                type="button"
                class="portfolio-filter px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white transition"
                data-filter="Rumah"
            >
                Desain Interior Rumah
            </button>

            <button
                type="button"
                class="portfolio-filter px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white transition"
                data-filter="Kantor"
            >
                Desain Interior Kantor
            </button>

            <button
                type="button"
                class="portfolio-filter px-5 py-2 rounded-full text-xs sm:text-sm font-medium bg-brand-cream text-brand-forest hover:bg-brand-forest hover:text-white transition"
                data-filter="Custom Interior"
            >
               Desain Custom Interior
            </button>

        </div>

        {{-- Portfolio Carousel (infinite marquee, sama seperti Klien & Mitra + panah manual) --}}
        <div class="portfolio-carousel relative">

            {{-- Tombol Sebelumnya --}}
            <button
                type="button"
                id="portfolio-prev"
                class="portfolio-arrow portfolio-arrow-left"
                aria-label="Portofolio sebelumnya"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            {{-- Area yang terlihat --}}
            <div
                id="portfolio-viewport"
                class="portfolio-viewport"
            >
                <div
                    id="portfolio-grid"
                    class="portfolio-grid"
                >

                    @forelse($portfolios as $p)

                        {{-- =====================================================
                             PORTFOLIO CARD
                             Diperbesar & diberi border tipis supaya gambar jadi
                             fokus utama (bukan sekadar thumbnail kecil). Lebar
                             kartu TETAP diatur oleh CSS .portfolio-item di atas
                             (untuk carousel) — di sini hanya mengubah tampilan
                             di dalam kartu, bukan lebar/posisinya.

                             Ubah tinggi gambar: ganti "h-64 sm:h-72".
                             Ubah radius sudut: ganti "rounded-2xl".
                        ====================================================== --}}
                        <article
                            class="portfolio-item reveal group bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer"
                            data-category="{{ $p['category'] ?? '' }}"
                            data-portfolio-id="{{ $p['id'] ?? 0 }}"
                        >

                            <div class="h-64 sm:h-72 bg-stone-100 relative overflow-hidden group">

                                <img
                                    src="{{ $p['image_url'] ?? '' }}"
                                    alt="{{ $p['title'] ?? 'Portofolio' }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    onerror="this.src='https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80'"
                                >

                                {{-- Scrim halus di bawah gambar supaya badge & judul lebih menyatu dengan foto --}}
                                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/25 to-transparent"></div>

                                <div class="absolute top-3 left-3 bg-brand-gold text-brand-forest text-[10px] tracking-wider uppercase font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    {{ $p['category'] ?? 'Interior' }}
                                </div>

                                <div class="absolute inset-0 bg-brand-forest/0 group-hover:bg-brand-forest/20 transition-colors duration-300 flex items-center justify-center">

                                    <span class="opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 text-brand-forest text-xs font-semibold uppercase tracking-wider px-4 py-2 rounded-full shadow">
                                        Lihat Detail Proyek
                                    </span>

                                </div>

                            </div>

                            <div class="p-6">

                                <h3 class="title-underline font-serif font-bold text-lg text-brand-forest mb-1">
                                    {{ $p['title'] ?? '' }}
                                </h3>

                                <div class="w-8 h-[2px] bg-brand-gold/60 mb-2"></div>

                                <p class="text-stone-500 text-xs sm:text-sm font-light line-clamp-3">
                                    {{ $p['description'] ?? '' }}
                                </p>

                            </div>

                        </article>

                    @empty

                        <div class="portfolio-empty text-center text-stone-400 py-12">
                            Belum ada portofolio saat ini.
                        </div>

                    @endforelse

                </div>
            </div>

            {{-- Tombol Berikutnya --}}
            <button
                type="button"
                id="portfolio-next"
                class="portfolio-arrow portfolio-arrow-right"
                aria-label="Portofolio berikutnya"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

        </div>

    </div>

</section>
