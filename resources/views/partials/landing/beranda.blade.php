<section id="beranda"
         class="relative bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 overflow-hidden px-2 sm:px-3 lg:px-4 py-0">

    <div class="relative w-full
                h-[680px] sm:h-[720px] lg:h-[760px]
                rounded-[28px] overflow-hidden">

        {{-- =====================================================
             HERO PARALLAX WRAPPER
             Div pembungkus baru HANYA untuk efek parallax (background
             bergerak sedikit lebih lambat saat discroll). Logic gambar
             (Storage::url / asset) di dalam @if/@else TIDAK diubah.
             Kecepatan parallax diatur di variabel JS "heroParallaxSpeed".
        ====================================================== --}}
        <div class="hero-parallax absolute inset-0 overflow-hidden" data-hero-parallax>

        {{-- BACKGROUND HERO — multi-slide, dengan fallback ke hero_image lama
             lalu ke foto Unsplash jika hero_slides masih kosong. --}}
        <div class="hero-slides absolute inset-0"
             data-hero-slides
             role="img"
             aria-label="{{ $settings['hero_title'] ?? 'Bumiyuji Living' }}">

            @if($heroSlides->isNotEmpty())

                @foreach($heroSlides as $index => $slide)
                    <div class="hero-slide absolute inset-0 {{ $index === 0 ? 'is-active' : '' }}" data-hero-slide>
                        <div
                            class="hero-slide-zoom absolute inset-0 bg-cover bg-center"
                            style="background-image: url('{{ Storage::url($slide->image) }}');">
                        </div>
                    </div>
                @endforeach

            @elseif($setting?->hero_image)

                <div class="hero-slide absolute inset-0 is-active" data-hero-slide>
                    <div
                        class="hero-slide-zoom absolute inset-0 bg-cover bg-center"
                        style="background-image: url('{{ Storage::url($setting->hero_image) }}');">
                    </div>
                </div>

            @else

                <div class="hero-slide absolute inset-0 is-active" data-hero-slide>
                    <div
                        class="hero-slide-zoom absolute inset-0 bg-cover bg-center"
                        style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1800&q=90');">
                    </div>
                </div>

            @endif

        </div>

        </div>
        {{-- END HERO PARALLAX WRAPPER --}}



        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-black/10"></div>

        {{-- DEPTH GRADIENT --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-0
                    h-40 bg-gradient-to-t
                    from-black/25 to-transparent">
        </div>


        {{-- =====================================================
             HERO CONTENT
        ====================================================== --}}
        <div class="relative h-full flex items-center
                    justify-center
                    px-2 sm:px-6 lg:px-12">

            <div class="w-full
                        flex flex-col
                        items-center
                        lg:flex-row
                        lg:items-center
                        lg:justify-start
                        gap-2 sm:gap-6 lg:gap-10">


                {{-- =================================================
                     KOTAK TEKS
                ================================================== --}}
                <div class="w-[78%] sm:w-full
                            max-w-[560px]
                            bg-[#4F6862]/85
                            backdrop-blur-sm
                            rounded-xl sm:rounded-2xl
                            shadow-2xl
                            p-4 sm:p-8 lg:p-12
                            text-white">

                    {{-- GARIS GOLD — REVEAL PERTAMA
                         Dipindah jadi anak PERTAMA supaya nth-child
                         label/judul/deskripsi/tombol di bawah tetap
                         memakai urutan delay yang sama seperti semula,
                         hanya digeser untuk menunggu garis ini selesai.
                         Warna diganti dari putih -> gold (#B9A56F),
                         animasi diganti dari fade menjadi "tumbuh"
                         (scaleX 0 -> 1) dari kiri. --}}
                    <div class="hero-line-grow
                                w-10 sm:w-16
                                h-[2px]
                                bg-[#B9A56F]
                                mb-4 sm:mb-6">
                    </div>


                    {{-- LABEL --}}
                    <span class="hero-anim block
                                 text-[10px] sm:text-base
                                 font-semibold
                                 tracking-[0.15em]
                                 uppercase
                                 mb-3 sm:mb-5">
                        DESIGN INTERIOR
                    </span>


                    {{-- JUDUL --}}
                    <h1 class="hero-anim
                               font-serif
                               text-2xl sm:text-5xl lg:text-6xl
                               font-semibold
                               leading-[1.08]
                               mb-3 sm:mb-6
                               break-words">

                        {{ $settings['hero_title'] ?? 'Mewujudkan Ruang Impian Menjadi Nyata' }}

                    </h1>


                    {{-- DESKRIPSI --}}
                    <p class="hero-anim
                              max-w-[480px]
                              text-xs sm:text-lg
                              text-white/90
                              leading-relaxed
                              mb-4 sm:mb-8">

                        {{ $settings['hero_subtitle'] ?? 'Kami menghadirkan desain interior yang elegan, fungsional, dan berkualitas tinggi untuk rumah, kantor, maupun ruang komersial.' }}

                    </p>


                    {{-- =================================================
                         BUTTON
                    ================================================== --}}
                    <div class="hero-anim
                                flex flex-wrap
                                gap-2 sm:gap-4">

                        {{-- KONSULTASI --}}
                        <a
                            href="#kontak"
                            class="btn-shine relative
                                   bg-[#EDE7D8]
                                   text-[#6F7B68]
                                   font-semibold
                                   text-[10px] sm:text-sm
                                   px-3 sm:px-8
                                   py-2.5 sm:py-4
                                   rounded-lg
                                   text-center
                                   transition
                                   hover:bg-white
                                   whitespace-nowrap">

                            KONSULTASI GRATIS

                        </a>


                        {{-- PORTOFOLIO --}}
                        <a
                            href="#portofolio"
                            class="border-2
                                   border-white/80
                                   text-white
                                   font-semibold
                                   text-[10px] sm:text-sm
                                   px-3 sm:px-8
                                   py-2.5 sm:py-4
                                   rounded-lg
                                   text-center
                                   transition
                                   hover:bg-white/10
                                   whitespace-nowrap">

                            LIHAT PORTFOLIO

                        </a>

                    </div>

                </div>
                {{-- END KOTAK TEKS --}}


                {{-- =================================================
                     LOGO BUMIYUJI
                     MOBILE: DI BAWAH KOTAK
                     DESKTOP: DI SAMPING KOTAK
                ================================================== --}}
                <div class="flex
                            items-center
                            justify-center
                            w-28 sm:w-40
                            lg:w-80
                            xl:w-96
                            shrink-0">

                    <img
                        src="{{ asset('images/bumiyuji-icon.png') }}"
                        alt="{{ $settings['site_title'] ?? 'Bumiyuji Living' }}"
                        class="w-full
                               h-auto
                               object-contain
                               drop-shadow-lg"
                    >

                </div>
                {{-- END LOGO --}}

            </div>

        </div>


        {{-- =====================================================
             SCROLL INDICATOR
        ====================================================== --}}
        <a
            href="#tentang"
            class="absolute bottom-7 left-1/2
                   -translate-x-1/2
                   hidden sm:flex
                   flex-col
                   items-center
                   gap-2
                   text-white/80">

            <span class="text-[10px]
                         tracking-[0.25em]
                         uppercase">
                SCROLL
            </span>

            <svg
                class="w-4 h-4 animate-bounce"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 14l-7 7m0 0l-7-7m7 7V3"
                />

            </svg>

        </a>

    </div>

</section>
