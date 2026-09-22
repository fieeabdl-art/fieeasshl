<section id="tentang" class="py-16 sm:py-20 bg-brand-cream">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Text --}}
            <div class="reveal reveal-left">

                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-4">
                    TENTANG KAMI
                </span>

                <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-normal text-brand-forest mb-6 leading-[1.08]">
                    {{ $settings['about_title'] ?? 'Mengenal Bumiyuji Living' }}
                </h2>

                <div class="divider-grow origin-left w-16 h-[2px] bg-brand-gold mb-7" data-divider></div>

                <p class="text-stone-600 mb-6 leading-relaxed">
                    {{ $settings['about_text'] ?? '' }}
                </p>

                <p class="text-stone-600 mb-8 leading-relaxed font-light">
                    {{ $settings['about_subtext'] ?? '' }}
                </p>

                <a
                    href="#kontak"
                    class="inline-flex items-center gap-3
                           border border-brand-forest
                           text-brand-forest
                           px-5 py-2.5
                           rounded-full
                           text-sm font-medium
                           hover:bg-brand-forest
                           hover:text-white
                           transition duration-300"
                >

                    About Us

                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>

                </a>

            </div>


            {{-- Image --}}
            <div class="relative reveal reveal-right flex justify-center lg:justify-end">

                <div class="relative w-full max-w-[520px]">

                    <img
                        src="{{ !empty($setting?->about_image)
                            ? Storage::url($setting->about_image)
                            : 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80' }}"
                        alt="Bumiyuji Living"
                        loading="lazy"
                        class="relative z-10 w-full h-[400px] sm:h-[450px] lg:h-[500px] object-contain"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         4 KEUNGGULAN
         Diubah dari baris ikon polos jadi kartu individual
         (background putih + border + shadow tipis) supaya
         punya hierarchy dan tidak terlihat seperti teks biasa.

         Cara mengubah jumlah kolom:
         ganti "md:grid-cols-4" di bawah.

         Cara mengubah jarak antar kartu:
         ganti "gap-4 sm:gap-5" di bawah.
    ====================================================== --}}
    <div class="mt-16 bg-brand-gold/[0.06] py-10 sm:py-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-5">

                {{-- Tim --}}
                <div class="reveal flex items-center justify-center gap-3 py-6 px-4 bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">

                    <svg class="w-10 h-10 text-brand-forest shrink-0"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                        />

                        <circle cx="9" cy="7" r="4" stroke-width="1.5"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                        />

                    </svg>

                    <span class="text-sm text-brand-forest leading-tight">
                        Tim<br>Profesional
                    </span>

                </div>


                {{-- Material --}}
                <div class="reveal flex items-center justify-center gap-3 py-6 px-4 bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="transition-delay: 80ms;">

                    <svg class="w-10 h-10 text-brand-forest shrink-0"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M3 7l9-4 9 4-9 4-9-4z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M3 12l9 4 9-4M3 17l9 4 9-4"
                        />

                    </svg>

                    <span class="text-sm text-brand-forest leading-tight">
                        Material<br>Berkualitas
                    </span>

                </div>


                {{-- Garansi --}}
                <div class="reveal flex items-center justify-center gap-3 py-6 px-4 bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="transition-delay: 160ms;">

                    <svg class="w-10 h-10 text-brand-forest shrink-0"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M9 12l2 2 4-4"
                        />

                    </svg>

                    <span class="text-sm text-brand-forest leading-tight">
                        Garansi<br>Pekerjaan
                    </span>

                </div>


                {{-- Desain --}}
                <div class="reveal flex items-center justify-center gap-3 py-6 px-4 bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="transition-delay: 240ms;">

                    <svg class="w-10 h-10 text-brand-forest shrink-0"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M3 10h18M5 10v8m14-8v8M3 18h18"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M4 10l2-5h12l2 5"
                        />

                    </svg>

                    <span class="text-sm text-brand-forest leading-tight">
                        Desain<br>Eksklusif
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>
