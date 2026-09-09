<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $settings['site_title'] ?? 'Bumiyuji Living' }}</title>

    {{-- =========================================================
         TAILWIND CSS
    ========================================================== --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            forest: '#2C3E35',
                            gold: '#C5A880',
                            cream: '#F9F6F0',
                            charcoal: '#1E1E1E',
                        }
                    },

                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'serif'],
                    },
                }
            }
        };
    </script>

    {{-- =========================================================
         GOOGLE FONT
    ========================================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- =========================================================
         CUSTOM CSS
    ========================================================== --}}
    <style>
        /* =====================================================
           FONT
        ====================================================== */

        body {
            font-family: 'Manrope', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .font-sans {
            font-family: 'Manrope', sans-serif;
        }

        /* =====================================================
           SCROLL REVEAL
        ====================================================== */

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition:
                opacity .7s cubic-bezier(.16,.8,.24,1),
                transform .7s cubic-bezier(.16,.8,.24,1);
            will-change: opacity, transform;
        }

        .reveal-left {
            transform: translateX(-32px);
        }

        .reveal-right {
            transform: translateX(32px);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translate(0, 0);
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .hero-bg-zoom {
                animation: none !important;
            }
        }

        /* =====================================================
           HERO
        ====================================================== */

        .hero-anim {
            opacity: 0;
            transform: translateY(18px);
            animation: heroIn .8s cubic-bezier(.16,.8,.24,1) forwards;
        }

        .hero-anim:nth-child(1) {
            animation-delay: .1s;
        }

        .hero-anim:nth-child(2) {
            animation-delay: .2s;
        }

        .hero-anim:nth-child(3) {
            animation-delay: .3s;
        }

        .hero-anim:nth-child(4) {
            animation-delay: .4s;
        }

        @keyframes heroIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-bg-zoom {
            animation: heroZoom 18s ease-in-out infinite alternate;
        }

        @keyframes heroZoom {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.08);
            }
        }

  /* =====================================================
   NAVIGATION
====================================================== */

.nav-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    border-radius: 9999px;
    color: #374151;
    background: transparent;
    border: 1px solid transparent;
    transition: all .3s ease;
    white-space: nowrap;
}

/* Hover */
.nav-link:hover {
    background: #f1f5f9;
    color: #8da9bd;
    transform: translateY(-1px);
}

/* Menu yang sedang aktif */
.nav-link.active {
    background: #8da9bd;
    color: #ffffff !important;
    border-color: #8da9bd;
    box-shadow: 0 4px 12px rgba(141, 169, 189, 0.30);
}

/* Hilangkan garis bawah lama */
.nav-link::after {
    display: none;
}

/* Header saat discroll */
#site-header.scrolled {
    box-shadow: 0 8px 24px -12px rgba(30, 30, 30, .25);
}

        /* =====================================================
           MOBILE MENU
        ====================================================== */

        #mobile-menu {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition:
                max-height .35s ease,
                opacity .25s ease;
        }

        #mobile-menu.open {
            max-height: 480px;
            opacity: 1;
        }

        #mobile-menu-btn.open .hamburger-line:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        #mobile-menu-btn.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        #mobile-menu-btn.open .hamburger-line:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* =====================================================
           BUTTON SHINE
        ====================================================== */

        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255,255,255,.45),
                transparent
            );
            transform: skewX(-20deg);
            transition: left .6s ease;
        }

        .btn-shine:hover::before {
            left: 125%;
        }

        /* =====================================================
           BACK TO TOP
        ====================================================== */

        #back-to-top {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all .3s ease;
        }

        #back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

         /* CSS lainnya */


   /* =====================================================
   TESTIMONI - SINGLE CARD SLIDER
===================================================== */

/* =====================================================
   TESTIMONI - HORIZONTAL SINGLE SLIDER
===================================================== */

.testimonial-slider {
    position: relative;
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
}

/* =====================================================
   VIEWPORT
===================================================== */

.testimonial-viewport {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 30px;
}

/* =====================================================
   TRACK
   Semua slide tetap berjajar KE SAMPING
===================================================== */

.testimonial-track {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;

    width: 100%;

    transform: translate3d(0, 0, 0);

    transition:
        transform .85s cubic-bezier(.65, 0, .35, 1);

    will-change: transform;
}

/* =====================================================
   SINGLE SLIDE
===================================================== */

.testimonial-slide {
    position: relative;

    flex: 0 0 100%;
    width: 100%;
    min-width: 100%;

    height: 540px;

    overflow: hidden;

    border-radius: 30px;

    background: #e7e5e4;
}

/* =====================================================
   FOTO FULL CARD
===================================================== */

.testimonial-image {
    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    z-index: 0;
}

.testimonial-image img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}

/* =====================================================
   GRADIENT OVERLAY
===================================================== */

.testimonial-slide::after {
    content: "";

    position: absolute;

    inset: 0;

    z-index: 1;

    background:
        linear-gradient(
            to top,
            rgba(0, 0, 0, .80) 0%,
            rgba(0, 0, 0, .60) 28%,
            rgba(0, 0, 0, .25) 58%,
            rgba(0, 0, 0, .03) 85%,
            rgba(0, 0, 0, 0) 100%
        );

    pointer-events: none;
}

/* =====================================================
   CONTENT
===================================================== */

.testimonial-content {
    position: absolute;

    left: 0;
    right: 0;
    bottom: 0;

    z-index: 2;

    padding: 45px 55px;

    padding-right: 130px;

    color: white;
}

/* =====================================================
   COMPANY / TITLE
===================================================== */

.testimonial-content h3 {
    margin: 0 0 18px;

    font-size: clamp(30px, 4vw, 48px);

    line-height: 1.05;

    font-weight: 400;

    letter-spacing: -.025em;

    color: white;
}

/* =====================================================
   DESKRIPSI TRANSPARAN
===================================================== */

.testimonial-message {
    display: inline-block;

    max-width: 820px;

    margin: 0;

    padding: 16px 20px;

    border-radius: 14px;

    background: rgba(255, 255, 255, .13);

    border: 1px solid rgba(255, 255, 255, .18);

    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);

    font-size: 17px;

    line-height: 1.7;

    font-style: italic;

    color: rgba(255, 255, 255, .96);
}

/* =====================================================
   NAMA CLIENT
   TANPA FOTO BULAT
===================================================== */

.testimonial-client {
    margin-top: 20px;
}

.testimonial-client-name {
    margin: 0;

    font-size: 17px;

    font-weight: 600;

    color: white;
}

.testimonial-client-position {
    margin: 4px 0 0;

    font-size: 13px;

    color: rgba(255, 255, 255, .72);
}

/* =====================================================
   COUNTER
===================================================== */

.testimonial-counter {
    position: absolute;

    top: 25px;
    right: 30px;

    z-index: 5;

    padding: 7px 13px;

    border-radius: 999px;

    background: rgba(0, 0, 0, .30);

    color: rgba(255, 255, 255, .95);

    font-size: 12px;

    letter-spacing: .08em;

    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);
}

/* =====================================================
   PANAH TESTIMONI - DI LUAR CARD
===================================================== */

.testimonial-navigation {
    position: absolute;

    top: 50%;
    left: -75px;
    right: -75px;

    z-index: 100;

    display: flex;
    align-items: center;
    justify-content: space-between;

    transform: translateY(-50%);

    pointer-events: none;
}

.testimonial-prev,
.testimonial-next {
    width: 52px;
    height: 52px;

    padding: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #ffffff !important;

    border: 1px solid #d6d3d1 !important;

    color: #111111 !important;

    opacity: 1 !important;
    visibility: visible !important;

    pointer-events: auto;

    cursor: pointer;

    box-shadow: 0 6px 20px rgba(0, 0, 0, .15);

    transition:
        transform .25s ease,
        background .25s ease,
        box-shadow .25s ease;
}

.testimonial-prev:hover {
    transform: translateX(-4px);
}

.testimonial-next:hover {
    transform: translateX(4px);
}

.testimonial-prev:hover,
.testimonial-next:hover {
    background: #f5f5f5 !important;

    box-shadow: 0 8px 25px rgba(0, 0, 0, .20);
}

.testimonial-prev svg,
.testimonial-next svg {
    width: 24px;
    height: 24px;

    display: block;

    stroke: currentColor;
}


/* =====================================================
   TABLET
===================================================== */

@media (max-width: 1280px) {

    .testimonial-navigation {
        left: 15px;
        right: 15px;
    }

}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 640px) {

    .testimonial-navigation {
        left: 10px;
        right: 10px;
    }

    .testimonial-prev,
    .testimonial-next {
        width: 42px;
        height: 42px;
    }

    .testimonial-prev svg,
    .testimonial-next svg {
        width: 20px;
        height: 20px;
    }

}

.testimonial-prev:hover,
.testimonial-next:hover {
    background: #f7f7f7;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, .16);
}

.testimonial-prev:hover {
    transform: translateX(-3px);
}

.testimonial-next:hover {
    transform: translateX(3px);
}

/* =====================================================
   DOT INDICATOR
===================================================== */

.testimonial-dots {
    display: flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    margin-top: 22px;
}

.testimonial-dot {
    width: 7px;
    height: 7px;

    padding: 0;

    border: 0;

    border-radius: 999px;

    background: #d6d3d1;

    cursor: pointer;

    transition:
        width .3s ease,
        background .3s ease;
}

.testimonial-dot.active {
    width: 24px;

    background: #111;
}

/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 1280px) {

    .testimonial-navigation {
        left: 18px;
        right: 18px;
    }

    .testimonial-prev,
    .testimonial-next {
        background: rgba(255, 255, 255, .90);

        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
}

@media (max-width: 640px) {

    .testimonial-slider {
        width: 100%;
    }

    .testimonial-viewport {
        border-radius: 22px;
    }

    .testimonial-slide {
        height: 500px;

        border-radius: 22px;
    }

    .testimonial-content {
        padding: 28px 22px 35px;

        padding-right: 22px;
    }

    .testimonial-content h3 {
        font-size: 30px;

        margin-bottom: 14px;
    }

    .testimonial-message {
        max-width: 100%;

        font-size: 15px;

        line-height: 1.6;

        padding: 13px 15px;
    }

    .testimonial-client {
        margin-top: 16px;
    }

    .testimonial-navigation {
        left: 12px;
        right: 12px;
    }

    .testimonial-prev,
    .testimonial-next {
        width: 42px;
        height: 42px;
    }

    .testimonial-counter {
        top: 18px;
        right: 18px;
    }

    .testimonial-dots {
        margin-top: 16px;
    }
}

        /* =====================================================
           MODAL
        ====================================================== */

        #portfolio-modal {
            overscroll-behavior: contain;
        }

        /* =====================================================
           SCROLLBAR
        ====================================================== */

        .portfolio-modal-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .portfolio-modal-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .portfolio-modal-scroll::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.2);
            border-radius: 999px;
        }


        /* =========================================================
           PORTFOLIO CAROUSEL (INFINITE MARQUEE)
           Hanya mempengaruhi bagian Portofolio.

           Catatan penting:
           - Posisi track (#portfolio-grid) TIDAK lagi digerakkan
             lewat CSS "transition", tapi lewat JavaScript
             (requestAnimationFrame) setiap frame, supaya kecepatan
             gesernya benar-benar konstan dan tidak pernah terlihat
             "loncat" balik ke kartu pertama.
           - Karena itu, jangan menambahkan properti "transition"
             untuk transform di sini lagi. Biarkan JS yang mengatur.
        ========================================================== */

        .portfolio-carousel {
            position: relative;
            width: 100%;
        }

        .portfolio-viewport {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        #portfolio-grid.portfolio-grid {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 24px;
            width: 100%;
            margin: 0;
            padding: 4px 2px 8px;
            /* Posisi awal transform, akan terus diperbarui oleh JS */
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }

        #portfolio-grid.portfolio-grid .portfolio-item {
            flex: 0 0 calc((100% - 48px) / 3);
            width: calc((100% - 48px) / 3);
            min-width: 0;
            margin: 0;
        }

        /*
         * Kartu hasil cloning (duplikat) untuk menyambung loop.
         * Ditandai supaya tidak terbaca ganda oleh screen reader,
         * tapi tetap tampil identik secara visual dengan aslinya.
         */
        #portfolio-grid.portfolio-grid .portfolio-item[data-portfolio-clone="true"] {
            pointer-events: auto;
        }

        .portfolio-arrow {
            position: absolute;
            top: 50%;
            z-index: 30;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            border: 1px solid rgba(44, 62, 53, .16);
            border-radius: 999px;
            background: rgba(255, 255, 255, .96);
            color: #2C3E35;
            box-shadow: 0 8px 24px rgba(30, 30, 30, .14);
            cursor: pointer;
            transition: background-color .25s ease,
                        color .25s ease,
                        opacity .25s ease,
                        transform .25s ease,
                        box-shadow .25s ease;
        }

        .portfolio-arrow svg {
            width: 21px;
            height: 21px;
        }

        .portfolio-arrow:hover {
            background: #2C3E35;
            color: #fff;
            box-shadow: 0 10px 28px rgba(30, 30, 30, .20);
        }

        .portfolio-arrow:active {
            transform: translateY(-50%) scale(.94);
        }

        .portfolio-arrow:focus-visible {
            outline: 2px solid #C5A880;
            outline-offset: 3px;
        }

        .portfolio-arrow.disabled {
            opacity: .25;
            pointer-events: none;
        }

        .portfolio-arrow-left {
            left: -22px;
        }

        .portfolio-arrow-right {
            right: -22px;
        }

        @media (max-width: 1024px) {
            #portfolio-grid.portfolio-grid {
                gap: 24px;
            }

            #portfolio-grid.portfolio-grid .portfolio-item {
                flex-basis: calc((100% - 24px) / 2);
                width: calc((100% - 24px) / 2);
            }

            .portfolio-arrow-left {
                left: -12px;
            }

            .portfolio-arrow-right {
                right: -12px;
            }
        }

        @media (max-width: 640px) {
            #portfolio-grid.portfolio-grid {
                gap: 16px;
                padding-left: 0;
                padding-right: 0;
            }

            #portfolio-grid.portfolio-grid .portfolio-item {
                flex-basis: 100%;
                width: 100%;
            }

            .portfolio-arrow {
                width: 38px;
                height: 38px;
            }

            .portfolio-arrow svg {
                width: 18px;
                height: 18px;
            }

            .portfolio-arrow-left {
                left: 8px;
            }

            .portfolio-arrow-right {
                right: 8px;
            }
        }

        /*
         * Untuk pengguna yang mengaktifkan "reduce motion" di OS
         * mereka, JS akan mematikan gerakan otomatis (lihat
         * portfolioReducedMotion). Rule di bawah ini hanya jaga-jaga
         * supaya tidak ada transisi CSS lain yang tiba-tiba aktif.
         */
        @media (prefers-reduced-motion: reduce) {
            #portfolio-grid.portfolio-grid {
                transition: none;
            }
        }

        /* =========================================================
           KLIEN & MITRA - MARQUEE
        ========================================================== */

        .cp-marquee-viewport {
            position: relative;
            width: 100%;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(to right, transparent 0, #000 6%, #000 94%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0, #000 6%, #000 94%, transparent 100%);
        }

        .cp-marquee-track {
            display: flex;
            align-items: stretch;
            gap: 24px;
            width: max-content;
            animation-name: cpMarqueeLeft;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            will-change: transform;
        }

        .cp-marquee-viewport:hover .cp-marquee-track,
        .cp-marquee-viewport:focus-within .cp-marquee-track {
            animation-play-state: paused;
        }

        .cp-marquee-item {
            flex: 0 0 auto;
            width: 150px;
        }

        @media (min-width: 640px) {
            .cp-marquee-item {
                width: 170px;
            }
        }

        @keyframes cpMarqueeLeft {
            from {
                transform: translate3d(0, 0, 0);
            }

            to {
                transform: translate3d(-50%, 0, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .cp-marquee-track {
                animation: none;
            }
        }
    </style>
</head>

<body class="font-sans bg-brand-cream text-brand-charcoal antialiased">

{{-- =========================================================
     TOP INFO BAR
========================================================= --}}
<div class="bg-brand-forest text-brand-gold text-xs py-2 px-4 border-b border-brand-gold/20">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">

        <span class="flex items-center gap-1.5 text-center sm:text-left">
            <svg class="w-3.5 h-3.5 shrink-0"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>

            {{ $settings['address'] ?? 'Sukabumi, Jawa Barat' }}
        </span>

        <span class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            {{ $settings['office_hours'] ?? 'Senin - Sabtu: 08:00 - 17:00' }}
        </span>

    </div>
</div>


{{-- =========================================================
NAVBAR
========================================================= --}}

<header id="site-header"
    class="sticky top-0 z-50 bg-white transition-shadow duration-300">

    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                min-h-20 py-3
                flex items-center justify-between gap-3">

        {{-- =====================================================
        LOGO BUMIYUJI
        ====================================================== --}}
        <a href="#beranda"
            class="flex items-center gap-3 group shrink-0 min-w-0">

            @if(!empty($settings['logo_url']))

                <img
                    src="{{ $settings['logo_url'] }}"
                    alt="{{ $settings['site_title'] ?? 'Bumiyuji Living' }}"
                    class="h-9 sm:h-10 lg:h-11 w-auto max-w-[150px] object-contain
                           transition-transform duration-300
                           group-hover:scale-105"
                >

            @else

                <span class="flex flex-col">

                    <span class="font-serif text-lg sm:text-xl
                                 tracking-widest font-bold
                                 text-brand-forest leading-none">
                        BUMIYUJI
                    </span>

                    <span class="text-[8px] sm:text-[9px]
                                 tracking-[0.25em]
                                 text-brand-gold mt-1">
                        L I V I N G
                    </span>

                </span>

            @endif

        </a>


        {{-- =====================================================
        DESKTOP NAVIGATION
        ====================================================== --}}
        <div class="hidden md:flex items-center gap-1 lg:gap-2
                    text-sm flex-1 justify-center">

            <a href="#beranda"
                class="nav-link px-3 lg:px-5 py-2 rounded-full
                       border border-[#9bb0bf]
                       text-brand-forest
                       hover:bg-[#8da9bd] hover:text-white
                       transition whitespace-nowrap">
                Beranda
            </a>

            <a href="#tentang"
                class="nav-link px-3 lg:px-5 py-2 rounded-full
                       border border-[#9bb0bf]
                       text-brand-forest
                       hover:bg-[#8da9bd] hover:text-white
                       transition whitespace-nowrap">
                Tentang Kami
            </a>

            <a href="#layanan"
                class="nav-link px-3 lg:px-5 py-2 rounded-full
                       border border-[#9bb0bf]
                       text-brand-forest
                       hover:bg-[#8da9bd] hover:text-white
                       transition whitespace-nowrap">
                Informasi
            </a>

            <a href="#portofolio"
                class="nav-link px-3 lg:px-5 py-2 rounded-full
                       border border-[#9bb0bf]
                       text-brand-forest
                       hover:bg-[#8da9bd] hover:text-white
                       transition whitespace-nowrap">
                Portofolio
            </a>

            <a href="#kontak"
                class="nav-link px-3 lg:px-5 py-2 rounded-full
                       border border-[#9bb0bf]
                       text-brand-forest
                       hover:bg-[#8da9bd] hover:text-white
                       transition whitespace-nowrap">
                Kontak
            </a>

        </div>


        {{-- =====================================================
        RIGHT SIDE
        ====================================================== --}}
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">

            {{-- =================================================
            MEMBER OF / LOGO ARADA
            ================================================== --}}
            <div class="flex items-center gap-1.5 sm:gap-2">

                {{-- Tulisan Member Of tampil di desktop dan mobile --}}
<span class="block
             font-['Manrope']
             text-[8px] sm:text-[9px] lg:text-[10px]
             font-semibold
             tracking-wider
             uppercase
             text-gray-500
             whitespace-nowrap">
    Member Of
</span>
                {{-- Logo ARADA --}}
                <img
                    src="{{ asset('images/logoarada.png') }}"
                    alt="ARADA"
                    class="h-6 sm:h-7 lg:h-8
                           w-auto
                           max-w-[85px]
                           object-contain"
                >

            </div>


            {{-- =================================================
            CTA
            ================================================== --}}
            <a
                href="https://wa.me/{{ $settings['wa_number'] ?? '6281311114523' }}?text=Halo%20Bumiyuji%2C%20saya%20ingin%20berkonsultasi%20mengenai%20desain%20interior."
                target="_blank"
                rel="noopener noreferrer"
                class="hidden sm:inline-flex
                       items-center justify-center
                       bg-[#a8b29a]
                       text-white
                       font-semibold
                       text-xs
                       uppercase
                       px-4 lg:px-6
                       py-3
                       rounded-full
                       transition
                       hover:opacity-90
                       whitespace-nowrap">
                Konsultasi Gratis
            </a>


            {{-- =================================================
            MOBILE BUTTON
            ================================================== --}}
            <button
                id="mobile-menu-btn"
                type="button"
                aria-label="Buka menu"
                aria-expanded="false"
                class="md:hidden
                       relative
                       h-10
                       w-10
                       shrink-0
                       flex flex-col
                       items-center
                       justify-center
                       gap-1.5
                       rounded
                       border
                       border-brand-forest/15
                       text-brand-forest">

                <span
                    class="hamburger-line block h-0.5 w-5
                           bg-brand-forest
                           transition-all duration-300">
                </span>

                <span
                    class="hamburger-line block h-0.5 w-5
                           bg-brand-forest
                           transition-all duration-300">
                </span>

                <span
                    class="hamburger-line block h-0.5 w-5
                           bg-brand-forest
                           transition-all duration-300">
                </span>

            </button>

        </div>

    </nav>


    {{-- =========================================================
    MOBILE MENU
    ========================================================== --}}
    <div id="mobile-menu"
        class="md:hidden bg-white border-t border-gray-100">

        <div class="px-4 sm:px-6 py-4 flex flex-col gap-1">

            <a href="#beranda"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Beranda
            </a>

            <a href="#tentang"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Tentang Kami
            </a>

            <a href="#layanan"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Informasi
            </a>

            <a href="#portofolio"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Portofolio
            </a>

            <a href="#alur-kerja"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Alur Kerja
            </a>

            <a href="#kontak"
                class="mobile-nav-link px-3 py-3 rounded
                       hover:bg-brand-cream transition">
                Kontak
            </a>

        </div>

    </div>

</header>
{{-- =========================================================
     HERO
========================================================= --}}
<section id="beranda"
         class="relative bg-white overflow-hidden px-2 sm:px-3 lg:px-4 py-0">

    <div class="relative w-full
                h-[680px] sm:h-[720px] lg:h-[760px]
                rounded-[28px] overflow-hidden">

        {{-- Background Hero --}}
        @if($setting?->hero_image)

            <div
                class="hero-bg-zoom absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ Storage::url($setting->hero_image) }}');">
            </div>

        @else

            <div
                class="hero-bg-zoom absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1800&q=90');">
            </div>

        @endif


        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/10"></div>


        {{-- =====================================================
             HERO CONTENT
             Satu kolom
        ====================================================== --}}
        <div class="relative h-full flex items-center px-5 sm:px-8 lg:px-12">

            <div class="w-full max-w-[560px]
                        bg-[#91a9ba]/85
                        backdrop-blur-sm
                        rounded-2xl
                        p-8 sm:p-10 lg:p-12
                        text-white">

                {{-- Label --}}
                <span class="hero-anim block
                             text-sm sm:text-base
                             font-semibold
                             tracking-[0.15em]
                             uppercase
                             mb-5">
                    DESIGN INTERIOR
                </span>


                {{-- Garis --}}
                <div class="hero-anim w-16 h-px bg-white mb-6"></div>


                {{-- Judul --}}
                <h1 class="hero-anim
                           font-serif
                           text-4xl sm:text-5xl lg:text-6xl
                           font-semibold
                           leading-[1.08]
                           mb-6
                           break-words">

                    {{ $settings['hero_title'] ?? 'Mewujudkan Ruang Impian Menjadi Nyata' }}

                </h1>


                {{-- Deskripsi --}}
                <p class="hero-anim
                          max-w-[480px]
                          text-base sm:text-lg
                          text-white/90
                          leading-relaxed
                          mb-8">

                    {{ $settings['hero_subtitle'] ?? 'Kami menghadirkan desain interior yang elegan, fungsional, dan berkualitas tinggi untuk rumah, kantor, maupun ruang komersial.' }}

                </p>
                

                {{-- Tombol --}}
                <div class="hero-anim flex flex-wrap gap-4">

                    <a
                        href="#appointment"
                        class="btn-shine relative
                               bg-[#f4f0e5]
                               text-[#718ba0]
                               font-semibold
                               text-sm
                               px-8 py-4
                               rounded-lg
                               text-center
                               transition
                               hover:bg-white
                               whitespace-nowrap"
                    >
                        KONSULTASI GRATIS
                    </a>

                    <a
                        href="#portofolio"
                        class="border-2 border-white/80
                               text-white
                               font-semibold
                               text-sm
                               px-8 py-4
                               rounded-lg
                               text-center
                               transition
                               hover:bg-white/10
                               whitespace-nowrap"
                    >
                        LIHAT PORTOFOLIO
                    </a>

                </div>

            </div>

        </div>


        {{-- Scroll Indicator --}}
        <a
            href="#tentang"
            class="absolute bottom-7 left-1/2
                   -translate-x-1/2
                   hidden sm:flex flex-col
                   items-center gap-2
                   text-white/80"
        >

            <span class="text-[10px] tracking-[0.25em] uppercase">
                SCROLL
            </span>

            <svg
                class="w-4 h-4 animate-bounce"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
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


{{-- =========================================================
     TENTANG KAMI
========================================================= --}}
<section id="tentang" class="py-16 sm:py-20 bg-white">

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

                <div class="w-16 h-[2px] bg-brand-gold mb-7"></div>

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
    ====================================================== --}}
    <div class="mt-16 bg-[#e3e5df]">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 md:grid-cols-4">

                {{-- Tim --}}
                <div class="flex items-center justify-center gap-3 py-6 px-4">

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
                <div class="flex items-center justify-center gap-3 py-6 px-4">

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
                <div class="flex items-center justify-center gap-3 py-6 px-4">

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
                <div class="flex items-center justify-center gap-3 py-6 px-4">

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
{{-- =========================================================
     VISI & MISI
========================================================= --}}

<section id="visi-misi" class="py-20 bg-[#f5f5f1]">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Heading --}}
        <div class="text-center mb-12">

            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase">
                VISI & MISI
            </span>

            <h2 class="font-serif text-4xl sm:text-5xl font-semibold text-brand-forest mt-3">
                Arah dan Komitmen Kami
            </h2>

            <div class="w-16 h-[2px] bg-brand-gold mx-auto mt-5"></div>

        </div>


        {{-- Visi --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-white rounded-2xl p-8 shadow-sm">

                <div class="flex items-center gap-4 mb-5">

                    <div class="w-12 h-12 rounded-full bg-[#8da9bd] flex items-center justify-center text-white">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"
                            />
                        </svg>

                    </div>

                    <h3 class="font-serif text-2xl font-bold text-brand-forest">
                        Visi
                    </h3>

                </div>

                <p class="text-stone-600 leading-relaxed">
       {{ $settings['visi'] ?? 'Visi belum tersedia.' }}
                </p>

            </div>


            {{-- Misi --}}
            <div class="bg-brand-forest rounded-2xl p-8 shadow-sm text-white">

                <div class="flex items-center gap-4 mb-5">

                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                    </div>

                    <h3 class="font-serif text-2xl font-bold">
                        Misi
                    </h3>

                </div>

                <p class="leading-relaxed text-white/80">
                    {{ $settings['misi'] ?? 'Misi belum tersedia.' }}
                </p>

            </div>

        </div>

    </div>

</section>

{{-- =========================================================
     LAYANAN
========================================================= --}}
<section id="layanan" class="py-20 bg-brand-cream">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-16 reveal">

            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">
                LAYANAN KAMI
            </span>

            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">
                Solusi Interior untuk Berbagai Kebutuhan
            </h2>

            <p class="text-stone-500 leading-relaxed">
                Kami menghadirkan solusi interior yang disesuaikan dengan kebutuhan,
                karakter, dan fungsi setiap ruang.
            </p>

        </div>


        @php
            $defaultServiceImages = [
                'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=800&q=80',
            ];
        @endphp


        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @forelse($services as $index => $service)

                @php
                    $imageUrl = $service->image
                        ? Storage::url($service->image)
                        : $defaultServiceImages[$index % count($defaultServiceImages)];
                @endphp

                <article
                    class="reveal group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5"
                    @if($index > 0)
                        style="transition-delay: {{ min($index * 100, 500) }}ms"
                    @endif
                >

                    <div class="overflow-hidden">

                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $service->title }}"
                            loading="lazy"
                            class="h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            onerror="this.src='{{ $defaultServiceImages[0] }}'"
                        >

                    </div>

                    <div class="p-6">

                        <h3 class="font-serif font-bold text-xl text-brand-forest mb-2">
                            {{ $service->title }}
                        </h3>

                        <p class="text-stone-500 text-sm leading-relaxed">
                            {{ $service->description }}
                        </p>

                    </div>

                </article>

            @empty

                <div class="col-span-full text-center text-stone-400 py-8">
                    Layanan belum tersedia saat ini.
                </div>

            @endforelse

        </div>

    </div>

</section>

{{-- =========================================================
     TIM KAMI
========================================================= --}}

<section
    id="our-team"
    class="team-section relative overflow-hidden bg-[#f9f8f6] py-24 lg:py-32"
>
    <div class="mx-auto max-w-6xl px-6 lg:px-8">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="reveal mx-auto mb-16 max-w-2xl text-center">

            <div class="mb-5 flex items-center justify-center gap-4">
                <span class="h-px w-10 bg-[#c5a880]"></span>

                <span
                    class="text-xs font-medium uppercase tracking-[0.25em] text-[#c5a880]"
                >
                    Our Team
                </span>

                <span class="h-px w-10 bg-[#c5a880]"></span>
            </div>

            <h2
                class="font-serif text-4xl leading-tight text-[#2c3e35] sm:text-5xl"
            >
                Meet Our Team
            </h2>

            <p
                class="mx-auto mt-5 max-w-xl text-sm leading-7 text-[#6d756f]"
            >
                Tim profesional BumiYuji Living yang berdedikasi menghadirkan
                desain interior dan arsitektur yang elegan, fungsional,
                dan sesuai dengan kebutuhan setiap klien.
            </p>

        </div>


        {{-- =====================================================
             TEAM
        ====================================================== --}}
        @if ($team->isNotEmpty())

            <div
                id="our-team-grid"
                class="grid grid-cols-2 gap-x-4 gap-y-10
                       sm:gap-x-6 sm:gap-y-12
                       lg:grid-cols-3 lg:gap-x-10 lg:gap-y-14"
            >

                @foreach ($team as $index => $member)

                    <div
                        data-team-card
                        data-team-index="{{ $index }}"
                        class="team-card reveal group flex flex-col items-center text-center"
                        style="
                            transition-delay: {{ min($index * 90, 360) }}ms;
                            display: flex;
                        "
                    >

                        {{-- =================================================
                             FOTO
                        ================================================== --}}
                        <div
                            class="team-image relative mb-4 h-28 w-28
                                   sm:h-32 sm:w-32
                                   lg:mb-6 lg:h-40 lg:w-40"
                        >

                            <div
                                class="absolute inset-0 rounded-full
                                       bg-gradient-to-br
                                       from-[#c5a880]/40 to-transparent
                                       opacity-0 blur-md
                                       transition-opacity duration-500
                                       group-hover:opacity-100"
                            ></div>

                            <div
                                class="relative aspect-square h-full w-full
                                       overflow-hidden rounded-full
                                       border-2 border-white shadow-md
                                       ring-1 ring-[#e4ddce]
                                       transition-all duration-500 ease-out
                                       group-hover:-translate-y-1.5
                                       group-hover:shadow-xl
                                       lg:border-4"
                            >

                                @if ($member->image_path)

                                    <img
                                        src="{{ Storage::url($member->image_path) }}"
                                        alt="{{ $member->name }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover object-center
                                               transition-transform duration-500 ease-out
                                               group-hover:scale-[1.06]"
                                    >

                                @else

                                    <div
                                        class="flex h-full w-full items-center
                                               justify-center bg-[#eee9df]"
                                    >
                                        <span
                                            class="font-serif text-lg
                                                   text-[#a89f8d]
                                                   lg:text-2xl"
                                        >
                                            {{
                                                collect(explode(' ', $member->name))
                                                    ->map(fn ($w) => mb_substr($w, 0, 1))
                                                    ->take(2)
                                                    ->implode('')
                                            }}
                                        </span>
                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                             NAMA
                        ================================================== --}}
                        <h3
                            class="team-content font-serif text-base
                                   leading-snug text-[#2c3e35]
                                   sm:text-lg lg:text-xl"
                        >
                            {{ $member->name }}
                        </h3>


                        {{-- =================================================
                             POSISI
                        ================================================== --}}
                        @if ($member->position)

                            <span
                                class="mt-1 block text-[10px]
                                       font-medium uppercase
                                       tracking-[0.14em]
                                       text-[#9a9488]
                                       sm:mt-1.5 sm:text-xs
                                       sm:tracking-[0.18em]"
                            >
                                {{ $member->position }}
                            </span>

                        @endif


                        {{-- =================================================
                             SOCIAL
                        ================================================== --}}
                        @if ($member->instagram || $member->linkedin)

                            <div
                                class="team-social mt-3 flex gap-2.5
                                       opacity-100
                                       transition-all duration-500 ease-out
                                       sm:gap-3
                                       lg:mt-4
                                       lg:translate-y-2
                                       lg:opacity-0
                                       lg:group-hover:translate-y-0
                                       lg:group-hover:opacity-100"
                            >

                                @if ($member->instagram)

                                    <a
                                        href="{{ $member->instagram }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Instagram {{ $member->name }}"
                                        class="flex h-8 w-8 items-center
                                               justify-center rounded-full
                                               border border-[#dedbd4]
                                               text-[#6d756f]
                                               transition-colors duration-300
                                               hover:border-[#c5a880]
                                               hover:bg-[#c5a880]
                                               hover:text-white
                                               lg:h-9 lg:w-9"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            class="h-4 w-4"
                                        >
                                            <rect
                                                x="3"
                                                y="3"
                                                width="18"
                                                height="18"
                                                rx="5"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="4"
                                            />

                                            <circle
                                                cx="17.5"
                                                cy="6.5"
                                                r="1"
                                                fill="currentColor"
                                                stroke="none"
                                            />
                                        </svg>
                                    </a>

                                @endif


                                @if ($member->linkedin)

                                    <a
                                        href="{{ $member->linkedin }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="LinkedIn {{ $member->name }}"
                                        class="flex h-8 w-8 items-center
                                               justify-center rounded-full
                                               border border-[#dedbd4]
                                               text-[#6d756f]
                                               transition-colors duration-300
                                               hover:border-[#c5a880]
                                               hover:bg-[#c5a880]
                                               hover:text-white
                                               lg:h-9 lg:w-9"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            class="h-4 w-4"
                                        >
                                            <path
                                                d="M6.5 8.5H3.5V20h3V8.5ZM5 4a1.75 1.75 0 1 0 0 3.5A1.75 1.75 0 0 0 5 4ZM10 8.5H7V20h3v-6.05c0-1.6.3-3.15 2.3-3.15 1.98 0 2 1.84 2 3.25V20h3v-6.58c0-3.23-.7-5.72-4.5-5.72-1.83 0-3.05 1.01-3.55 1.97h-.04V8.5H10Z"
                                            />
                                        </svg>
                                    </a>

                                @endif

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>


            {{-- =====================================================
                 BUTTON
            ====================================================== --}}
            @if ($team->count() > 4)

                <div
                    id="our-team-toggle-wrapper"
                    class="mt-10 flex justify-center sm:mt-12"
                >

                    <button
                        type="button"
                        id="our-team-toggle"
                        aria-expanded="false"
                        class="inline-flex items-center justify-center
                               rounded-full
                               border border-[#dedbd4]
                               bg-[#f2efe8]
                               px-7 py-2.5
                               text-xs font-medium uppercase
                               tracking-[0.14em]
                               text-[#2c3e35]
                               transition-all duration-300
                               hover:border-[#c5a880]
                               hover:bg-[#c5a880]
                               hover:text-white"
                    >
                        Tampilkan lainnya
                    </button>

                </div>

            @endif


        @else

            {{-- =====================================================
                 EMPTY
            ====================================================== --}}
            <div
                class="border border-[#dedbd4] bg-white
                       px-6 py-12 text-center"
            >
                <p class="text-sm text-[#6d756f]">
                    Data anggota tim belum tersedia.
                </p>
            </div>

        @endif

    </div>
</section>


{{-- =========================================================
     TEAM DISPLAY CONTROLLER
     
     MOBILE  = 4
     DESKTOP = 6
========================================================= --}}

<style>
    /*
     * Semua card team disembunyikan terlebih dahulu
     * oleh controller JavaScript.
     *
     * Jangan gunakan .hidden Tailwind di sini.
     */
    [data-team-card].team-is-hidden {
        display: none !important;
    }
</style>


<script>
(function () {

    function initOurTeam() {

        const teamGrid = document.getElementById('our-team-grid');
        const teamButton = document.getElementById('our-team-toggle');
        const teamButtonWrapper = document.getElementById(
            'our-team-toggle-wrapper'
        );

        /*
         * Kalau section/team tidak ada,
         * jangan jalankan apa pun.
         */
        if (!teamGrid) {
            return;
        }

        const teamCards = Array.from(
            teamGrid.querySelectorAll('[data-team-card]')
        );

        /*
         * Tidak perlu tombol jika tidak ada card.
         */
        if (teamCards.length === 0) {
            return;
        }

        /*
         * Status:
         *
         * false = tampilan awal
         * true  = semua anggota
         */
        let expanded = false;


        /*
         * =====================================================
         * BATAS TEAM
         *
         * Mobile  = 4
         * Desktop = 6
         * =====================================================
         */
        function getLimit() {

            return window.matchMedia('(max-width: 639px)').matches
                ? 4
                : 6;
        }


        /*
         * =====================================================
         * UPDATE TEAM
         * =====================================================
         */
        function updateTeam() {

            const limit = getLimit();


            /*
             * Tampilkan/sembunyikan setiap card.
             */
            teamCards.forEach(function (card, index) {

                if (expanded) {

                    /*
                     * MODE SEMUA
                     */
                    card.classList.remove('team-is-hidden');

                } else {

                    /*
                     * MODE AWAL
                     *
                     * Mobile  -> 4
                     * Desktop -> 6
                     */
                    if (index < limit) {

                        card.classList.remove(
                            'team-is-hidden'
                        );

                    } else {

                        card.classList.add(
                            'team-is-hidden'
                        );

                    }

                }

            });


            /*
             * =================================================
             * BUTTON
             * =================================================
             */

            const hasMore = teamCards.length > limit;


            /*
             * Kalau tidak ada anggota tambahan,
             * tombol tidak perlu ditampilkan.
             */
            if (!hasMore) {

                if (teamButtonWrapper) {
                    teamButtonWrapper.style.display = 'none';
                }

                return;
            }


            /*
             * Ada anggota tambahan.
             */
            if (teamButtonWrapper) {
                teamButtonWrapper.style.display = 'flex';
            }


            /*
             * Ubah tulisan tombol.
             */
            if (teamButton) {

                teamButton.textContent = expanded
                    ? 'Sembunyikan'
                    : 'Tampilkan lainnya';

                teamButton.setAttribute(
                    'aria-expanded',
                    expanded ? 'true' : 'false'
                );

            }

        }


        /*
         * =====================================================
         * BUTTON CLICK
         * =====================================================
         */
        if (teamButton) {

            teamButton.addEventListener(
                'click',
                function () {

                    /*
                     * Balik status.
                     */
                    expanded = !expanded;

                    /*
                     * Update tampilan.
                     */
                    updateTeam();

                }
            );

        }


        /*
         * =====================================================
         * RESIZE
         * =====================================================
         *
         * Jika user mengubah:
         *
         * Desktop -> Mobile
         * 6 -> 4
         *
         * Mobile -> Desktop
         * 4 -> 6
         */
        let lastIsMobile =
            window.matchMedia('(max-width: 639px)').matches;

        window.addEventListener('resize', function () {

            const currentIsMobile =
                window.matchMedia('(max-width: 639px)').matches;


            /*
             * Jika berpindah breakpoint,
             * reset ke tampilan awal.
             */
            if (currentIsMobile !== lastIsMobile) {

                expanded = false;

                lastIsMobile = currentIsMobile;

            }

            updateTeam();

        });


        /*
         * =====================================================
         * INIT
         * =====================================================
         */
        updateTeam();

    }


    /*
     * Pastikan DOM sudah siap.
     */
    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initOurTeam
        );

    } else {

        initOurTeam();

    }

})();
</script>


{{-- =========================================================
     PORTOFOLIO
========================================================= --}}
<section id="portofolio" class="py-20 bg-white">

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

        {{-- Portfolio Carousel --}}
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

                        <article
                            class="portfolio-item reveal bg-white rounded-lg shadow overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 cursor-pointer"
                            data-category="{{ $p['category'] ?? '' }}"
                            data-portfolio-id="{{ $p['id'] ?? 0 }}"
                        >

                            <div class="h-64 bg-stone-100 relative overflow-hidden group">

                                <img
                                    src="{{ $p['image_url'] ?? '' }}"
                                    alt="{{ $p['title'] ?? 'Portofolio' }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    onerror="this.src='https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&q=80'"
                                >

                                <div class="absolute top-3 left-3 bg-brand-gold text-brand-forest text-[10px] tracking-wider uppercase font-bold px-2.5 py-1 rounded">
                                    {{ $p['category'] ?? 'Interior' }}
                                </div>

                                <div class="absolute inset-0 bg-brand-forest/0 group-hover:bg-brand-forest/20 transition-colors duration-300 flex items-center justify-center">

                                    <span class="opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 bg-white text-brand-forest text-xs font-semibold uppercase tracking-wider px-4 py-2 rounded-full shadow">
                                        Lihat Detail Proyek
                                    </span>

                                </div>

                            </div>

                            <div class="p-6">

                                <h3 class="font-serif font-bold text-lg text-brand-forest mb-1">
                                    {{ $p['title'] ?? '' }}
                                </h3>

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


{{-- =========================================================
     PORTFOLIO MODAL
========================================================= --}}
<div
    id="portfolio-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6"
    aria-hidden="true"
>

    <div
        id="portfolio-modal-backdrop"
        class="absolute inset-0 bg-black/70 backdrop-blur-sm"
    ></div>


    <div
        class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto portfolio-modal-scroll rounded-2xl bg-[#1a2420] text-white shadow-2xl"
    >

        {{-- Close --}}
        <button
            type="button"
            id="portfolio-modal-close"
            aria-label="Tutup"
            class="absolute right-4 top-4 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition"
        >

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
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>

        </button>


        <div class="p-5 sm:p-8">

            <span class="text-brand-gold font-semibold tracking-[0.2em] text-xs uppercase block mb-2">
                Detail Proyek
            </span>

            <h3
                id="pm-title"
                class="font-serif text-xl sm:text-2xl font-bold leading-snug pr-10"
            ></h3>

            <span
                id="pm-category-badge"
                class="mt-2 inline-block bg-brand-gold text-brand-forest text-[10px] tracking-wider uppercase font-bold px-2.5 py-1 rounded"
            ></span>


            {{-- Main Image --}}
            <div class="relative mt-5 h-56 sm:h-72 w-full overflow-hidden rounded-xl bg-stone-800">

                <img
                    id="pm-main-image"
                    src=""
                    alt=""
                    class="h-full w-full object-cover transition-opacity duration-300"
                >

            </div>


            {{-- Timeline --}}
            <div
                id="pm-timeline"
                class="mt-6 flex items-start justify-between relative"
            ></div>


            {{-- Phase --}}
            <div
                id="pm-phase-box"
                class="mt-5 rounded-lg border border-white/10 bg-white/5 p-4"
            ></div>


            {{-- Gallery --}}
            <div
                id="pm-gallery"
                class="mt-5 grid grid-cols-3 sm:grid-cols-4 gap-2"
            ></div>

        </div>

    </div>

</div>


{{-- Portfolio Data --}}
<script id="portfolio-data" type="application/json">
{!! json_encode($portfolios, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>


{{-- =========================================================
     ALUR KERJA
     STATIC - TIDAK MENGGUNAKAN DATABASE
========================================================= --}}
<section id="alur-kerja" class="py-16 lg:py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Heading --}}
        <div class="mb-8 lg:mb-10 reveal">
            <h2 class="text-4xl sm:text-5xl lg:text-[48px] font-bold tracking-tight text-black">
                ALUR KERJA
            </h2>

            <div class="w-[76px] h-[2px] bg-black mt-2"></div>
        </div>


        {{-- =====================================================
             DESKTOP
             01 → 02 → 03 → 04 → 05 → 06 → 07
        ====================================================== --}}
        <div class="hidden lg:flex items-start justify-between w-full max-w-[1200px] mx-auto">


            {{-- 01 KONSULTASI --}}
            <div class="flex flex-col items-center text-center w-[130px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <circle cx="29" cy="25" r="8"
                                stroke="black"
                                stroke-width="2.5"/>

                        <path
                            d="M16 48C16 40 21 35 29 35C37 35 42 40 42 48"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                        />

                        <path
                            d="M12 48H47"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                        />

                        <path
                            d="M17 48V57"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <path
                            d="M42 48V57"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <rect
                            x="40"
                            y="12"
                            width="22"
                            height="17"
                            rx="4"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <circle cx="47" cy="20.5" r="1.3" fill="black"/>
                        <circle cx="52" cy="20.5" r="1.3" fill="black"/>
                        <circle cx="57" cy="20.5" r="1.3" fill="black"/>

                        <path
                            d="M46 29L43 34"
                            stroke="black"
                            stroke-width="2.5"
                        />

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Konsultasi
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 02 SURVEI --}}
            <div class="flex flex-col items-center text-center w-[130px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <path
                            d="M14 48L18 26L40 20L58 27L54 50L32 56L14 48Z"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linejoin="round"
                        />

                        <path d="M25 24L22 48" stroke="black" stroke-width="2"/>
                        <path d="M43 21L40 53" stroke="black" stroke-width="2"/>

                        <path
                            d="M43 16C36 16 31 21 31 28C31 38 43 47 43 47C43 47 55 38 55 28C55 21 50 16 43 16Z"
                            fill="white"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <circle
                            cx="43"
                            cy="28"
                            r="4"
                            stroke="black"
                            stroke-width="2.5"
                        />

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Survei
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 03 DESIGN & RAB --}}
            <div class="flex flex-col items-center text-center w-[160px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <path
                            d="M18 56V22C18 18 21 15 25 15H50C54 15 57 18 57 22V56H18Z"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <path
                            d="M27 27H36V36H27V27Z"
                            stroke="black"
                            stroke-width="2.2"
                        />

                        <path d="M41 27H50" stroke="black" stroke-width="2.2"/>
                        <path d="M41 34H50" stroke="black" stroke-width="2.2"/>
                        <path d="M27 43H50" stroke="black" stroke-width="2.2"/>

                        <path
                            d="M48 18L61 5"
                            stroke="black"
                            stroke-width="3"
                            stroke-linecap="round"
                        />

                        <path
                            d="M56 3L64 11"
                            stroke="black"
                            stroke-width="2.5"
                        />

                    </svg>

                </div>

                <p class="text-[17px] leading-tight text-black mt-2">
                    Pembuatan Design
                    <br>
                    &amp; RAB
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 04 REVISI --}}
            <div class="flex flex-col items-center text-center w-[130px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <path
                            d="M20 30C23 21 32 16 41 18C48 19 54 24 56 31"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                        />

                        <path
                            d="M52 21L56 31L46 29"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M52 46C49 55 40 60 31 58C24 57 18 52 16 45"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                        />

                        <path
                            d="M20 55L16 45L26 47"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linejoin="round"
                        />

                        <rect
                            x="29"
                            y="25"
                            width="17"
                            height="24"
                            stroke="black"
                            stroke-width="2.2"
                        />

                        <path d="M33 31H42" stroke="black" stroke-width="2"/>
                        <path d="M33 37H42" stroke="black" stroke-width="2"/>

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Revisi
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 05 PRODUKSI --}}
            <div class="flex flex-col items-center text-center w-[130px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <circle
                            cx="38"
                            cy="38"
                            r="19"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <circle
                            cx="38"
                            cy="38"
                            r="7"
                            stroke="black"
                            stroke-width="2.2"
                        />

                        <path d="M38 15V22" stroke="black" stroke-width="2.5"/>
                        <path d="M38 54V61" stroke="black" stroke-width="2.5"/>
                        <path d="M15 38H22" stroke="black" stroke-width="2.5"/>
                        <path d="M54 38H61" stroke="black" stroke-width="2.5"/>
                        <path d="M22 22L17 17" stroke="black" stroke-width="2.5"/>
                        <path d="M54 22L59 17" stroke="black" stroke-width="2.5"/>
                        <path d="M22 54L17 59" stroke="black" stroke-width="2.5"/>
                        <path d="M54 54L59 59" stroke="black" stroke-width="2.5"/>

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Produksi
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 06 INSTALASI --}}
            <div class="flex flex-col items-center text-center w-[130px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <path
                            d="M21 51L34 38"
                            stroke="black"
                            stroke-width="3"
                            stroke-linecap="round"
                        />

                        <path
                            d="M31 36L22 27L31 18L40 27L31 36Z"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <path
                            d="M40 34L56 18"
                            stroke="black"
                            stroke-width="3"
                            stroke-linecap="round"
                        />

                        <path d="M48 13L61 26" stroke="black" stroke-width="2.5"/>
                        <path d="M52 9L65 22" stroke="black" stroke-width="2.5"/>

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Instalasi
                </p>

            </div>


            {{-- Arrow --}}
            <div class="flex items-center pt-[30px] shrink-0">
                <svg width="46" height="22" viewBox="0 0 46 22" fill="none">
                    <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                    <path
                        d="M30 4L38 11L30 18"
                        stroke="black"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>


            {{-- 07 SERAH TERIMA --}}
            <div class="flex flex-col items-center text-center w-[140px] shrink-0">

                <div class="h-[82px] flex items-center justify-center">

                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                        <rect
                            x="19"
                            y="12"
                            width="38"
                            height="49"
                            stroke="black"
                            stroke-width="2.5"
                        />

                        <circle
                            cx="47"
                            cy="25"
                            r="7"
                            stroke="black"
                            stroke-width="2.2"
                        />

                        <path
                            d="M43 25L46 28L51 22"
                            stroke="black"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M20 45L28 39L36 45L44 39"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M28 50L35 44L43 50"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>

                <p class="text-[17px] text-black mt-2">
                    Serah Terima
                </p>

              

            </div>

        </div>


        {{-- =====================================================
             MOBILE
             BARIS 1 : 01 → 02 → 03 → 04
             BARIS 2 : 05 → 06 → 07
        ====================================================== --}}
        <div class="lg:hidden w-full">

            {{-- ================= BARIS 1 ================= --}}
            <div class="flex items-start justify-between w-full gap-1">

                {{-- 01 --}}
                <div class="flex flex-col items-center text-center flex-1 min-w-0">

                    <div class="h-[82px] flex items-center justify-center">
                        {{-- ICON 01 --}}
                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <circle cx="29" cy="25" r="8"
                                    stroke="black"
                                    stroke-width="2.5"/>

                            <path
                                d="M16 48C16 40 21 35 29 35C37 35 42 40 42 48"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                            />

                            <path
                                d="M12 48H47"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                            />

                            <path d="M17 48V57" stroke="black" stroke-width="2.5"/>
                            <path d="M42 48V57" stroke="black" stroke-width="2.5"/>

                            <rect
                                x="40"
                                y="12"
                                width="22"
                                height="17"
                                rx="4"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <circle cx="47" cy="20.5" r="1.3" fill="black"/>
                            <circle cx="52" cy="20.5" r="1.3" fill="black"/>
                            <circle cx="57" cy="20.5" r="1.3" fill="black"/>

                            <path d="M46 29L43 34"
                                  stroke="black"
                                  stroke-width="2.5"/>

                        </svg>
                    </div>

                    <p class="text-sm text-black mt-2">
                        Konsultasi
                    </p>

                </div>


                {{-- Arrow --}}
                <div class="flex items-center pt-[30px] shrink-0">
                    <svg width="28" height="18" viewBox="0 0 46 22" fill="none">
                        <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                        <path
                            d="M30 4L38 11L30 18"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>


                {{-- 02 --}}
                <div class="flex flex-col items-center text-center flex-1 min-w-0">

                    <div class="h-[82px] flex items-center justify-center">
                        {{-- ICON 02 --}}
                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <path
                                d="M14 48L18 26L40 20L58 27L54 50L32 56L14 48Z"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linejoin="round"
                            />

                            <path d="M25 24L22 48" stroke="black" stroke-width="2"/>
                            <path d="M43 21L40 53" stroke="black" stroke-width="2"/>

                            <path
                                d="M43 16C36 16 31 21 31 28C31 38 43 47 43 47C43 47 55 38 55 28C55 21 50 16 43 16Z"
                                fill="white"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <circle cx="43" cy="28" r="4"
                                    stroke="black"
                                    stroke-width="2.5"/>

                        </svg>
                    </div>

                    <p class="text-sm text-black mt-2">
                        Survei
                    </p>

                </div>


                {{-- Arrow --}}
                <div class="flex items-center pt-[30px] shrink-0">
                    <svg width="28" height="18" viewBox="0 0 46 22" fill="none">
                        <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                        <path
                            d="M30 4L38 11L30 18"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>


                {{-- 03 --}}
                <div class="flex flex-col items-center text-center flex-1 min-w-0">

                    <div class="h-[82px] flex items-center justify-center">
                        {{-- ICON 03 --}}
                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <path
                                d="M18 56V22C18 18 21 15 25 15H50C54 15 57 18 57 22V56H18Z"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <path
                                d="M27 27H36V36H27V27Z"
                                stroke="black"
                                stroke-width="2.2"
                            />

                            <path d="M41 27H50" stroke="black" stroke-width="2.2"/>
                            <path d="M41 34H50" stroke="black" stroke-width="2.2"/>
                            <path d="M27 43H50" stroke="black" stroke-width="2.2"/>

                            <path
                                d="M48 18L61 5"
                                stroke="black"
                                stroke-width="3"
                                stroke-linecap="round"
                            />

                            <path d="M56 3L64 11"
                                  stroke="black"
                                  stroke-width="2.5"/>

                        </svg>
                    </div>

                    <p class="text-xs sm:text-sm leading-tight text-black mt-2">
                        Pembuatan Design
                        <br>
                        &amp; RAB
                    </p>

                </div>


                {{-- Arrow --}}
                <div class="flex items-center pt-[30px] shrink-0">
                    <svg width="28" height="18" viewBox="0 0 46 22" fill="none">
                        <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                        <path
                            d="M30 4L38 11L30 18"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>


                {{-- 04 --}}
                <div class="flex flex-col items-center text-center flex-1 min-w-0">

                    <div class="h-[82px] flex items-center justify-center">
                        {{-- ICON 04 --}}
                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <path
                                d="M20 30C23 21 32 16 41 18C48 19 54 24 56 31"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                            />

                            <path
                                d="M52 21L56 31L46 29"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M52 46C49 55 40 60 31 58C24 57 18 52 16 45"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                            />

                            <path
                                d="M20 55L16 45L26 47"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linejoin="round"
                            />

                            <rect
                                x="29"
                                y="25"
                                width="17"
                                height="24"
                                stroke="black"
                                stroke-width="2.2"
                            />

                            <path d="M33 31H42" stroke="black" stroke-width="2"/>
                            <path d="M33 37H42" stroke="black" stroke-width="2"/>

                        </svg>
                    </div>

                    <p class="text-sm text-black mt-2">
                        Revisi
                    </p>

                </div>

            </div>


            {{-- ================= BARIS 2 ================= --}}
            <div class="flex items-start justify-center gap-3 sm:gap-8 mt-12">

                {{-- 05 --}}
                <div class="flex flex-col items-center text-center w-[85px] sm:w-[110px]">

                    <div class="h-[82px] flex items-center justify-center">

                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <circle
                                cx="38"
                                cy="38"
                                r="19"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <circle
                                cx="38"
                                cy="38"
                                r="7"
                                stroke="black"
                                stroke-width="2.2"
                            />

                            <path d="M38 15V22" stroke="black" stroke-width="2.5"/>
                            <path d="M38 54V61" stroke="black" stroke-width="2.5"/>
                            <path d="M15 38H22" stroke="black" stroke-width="2.5"/>
                            <path d="M54 38H61" stroke="black" stroke-width="2.5"/>
                            <path d="M22 22L17 17" stroke="black" stroke-width="2.5"/>
                            <path d="M54 22L59 17" stroke="black" stroke-width="2.5"/>
                            <path d="M22 54L17 59" stroke="black" stroke-width="2.5"/>
                            <path d="M54 54L59 59" stroke="black" stroke-width="2.5"/>

                        </svg>

                    </div>

                    <p class="text-sm text-black mt-2">
                        Produksi
                    </p>

                </div>


                {{-- Arrow --}}
                <div class="flex items-center pt-[30px] shrink-0">
                    <svg width="32" height="18" viewBox="0 0 46 22" fill="none">
                        <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                        <path
                            d="M30 4L38 11L30 18"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>


                {{-- 06 --}}
                <div class="flex flex-col items-center text-center w-[85px] sm:w-[110px]">

                    <div class="h-[82px] flex items-center justify-center">

                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <path
                                d="M21 51L34 38"
                                stroke="black"
                                stroke-width="3"
                                stroke-linecap="round"
                            />

                            <path
                                d="M31 36L22 27L31 18L40 27L31 36Z"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <path
                                d="M40 34L56 18"
                                stroke="black"
                                stroke-width="3"
                                stroke-linecap="round"
                            />

                            <path d="M48 13L61 26" stroke="black" stroke-width="2.5"/>
                            <path d="M52 9L65 22" stroke="black" stroke-width="2.5"/>

                        </svg>

                    </div>

                    <p class="text-sm text-black mt-2">
                        Instalasi
                    </p>

                </div>


                {{-- Arrow --}}
                <div class="flex items-center pt-[30px] shrink-0">
                    <svg width="32" height="18" viewBox="0 0 46 22" fill="none">
                        <path d="M2 11H37" stroke="black" stroke-width="2.5"/>
                        <path
                            d="M30 4L38 11L30 18"
                            stroke="black"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>


                {{-- 07 --}}
                <div class="flex flex-col items-center text-center w-[100px] sm:w-[120px]">

                    <div class="h-[82px] flex items-center justify-center">

                        <svg width="76" height="76" viewBox="0 0 76 76" fill="none">

                            <rect
                                x="19"
                                y="12"
                                width="38"
                                height="49"
                                stroke="black"
                                stroke-width="2.5"
                            />

                            <circle
                                cx="47"
                                cy="25"
                                r="7"
                                stroke="black"
                                stroke-width="2.2"
                            />

                            <path
                                d="M43 25L46 28L51 22"
                                stroke="black"
                                stroke-width="2.2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M20 45L28 39L36 45L44 39"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M28 50L35 44L43 50"
                                stroke="black"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>

                    </div>

                    <p class="text-sm text-black mt-2">
                        Serah Terima
                    </p>

                  

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     TESTIMONI
========================================================= --}}
<section id="testimoni" class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="text-center mb-10 lg:mb-12 reveal">

            <h2 class="text-4xl sm:text-5xl lg:text-[52px] font-semibold tracking-tight text-black">
                TESTIMONI
            </h2>

            <div class="w-20 h-[1.5px] bg-black mx-auto mt-3"></div>

        </div>


        {{-- JIKA BELUM ADA TESTIMONI --}}
        @if(empty($testimonials) || count($testimonials) === 0)

            <div class="text-center py-12">

                <p class="text-stone-400">
                    Belum ada testimonial.
                </p>

            </div>

        @else

            @php
                $testimonialCount = count($testimonials);
            @endphp


            {{-- =================================================
                 PEMBUNGKUS SLIDER
            ================================================== --}}
            <div
                id="testimonialSlider"
                class="testimonial-slider"
            >

                {{-- =================================================
                     CARD TESTIMONI
                     BAGIAN INI YANG BERGERAK KE SAMPING
                ================================================== --}}
                <div class="testimonial-viewport">

                    <div
                        id="testimonialTrack"
                        class="testimonial-track"
                    >

                        @foreach($testimonials as $index => $t)

                            @php
                                $position = trim(
                                    ($t->position ?? '') .
                                    ($t->position && $t->company ? ' · ' : '') .
                                    ($t->company ?? '')
                                );
                            @endphp


                            {{-- =================================================
                                 1 CARD
                            ================================================== --}}
                            <article class="testimonial-slide">

                                {{-- FOTO MEMENUHI CARD --}}
                                <div class="testimonial-image">

                                    @if($t->photo)

                                        <img
                                            src="{{ Storage::url($t->photo) }}"
                                            alt="{{ $t->name }}"
                                        >

                                    @else

                                        <div class="w-full h-full flex items-center justify-center bg-stone-300">

                                            <span class="text-stone-500">
                                                Tidak ada foto
                                            </span>

                                        </div>

                                    @endif

                                </div>


                                {{-- =================================================
                                     ISI DI ATAS FOTO
                                ================================================== --}}
                                <div class="testimonial-content">

                                    <h3>
                                        {{ $t->company ?: $t->name }}
                                    </h3>


                                    @if($t->message)

                                        <p class="testimonial-message">
                                            "{{ $t->message }}"
                                        </p>

                                    @endif


                                    {{-- NAMA TANPA FOTO BULAT --}}
                                    <div class="testimonial-client">

                                        <p class="testimonial-client-name">
                                            {{ $t->name }}
                                        </p>

                                        @if($position)

                                            <p class="testimonial-client-position">
                                                {{ $position }}
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                {{-- NOMOR --}}
                                <div class="testimonial-counter">

                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                                    <span class="mx-1 opacity-50">
                                        /
                                    </span>

                                    {{ str_pad($testimonialCount, 2, '0', STR_PAD_LEFT) }}

                                </div>

                            </article>

                        @endforeach

                    </div>

                </div>


                {{-- =================================================
                     PANAH
                     INI POSISINYA DI LUAR CARD
                     
                     ← [ CARD ] →
                ================================================== --}}
                @if($testimonialCount > 1)

                    <div class="testimonial-navigation">

                        {{-- PANAH KIRI --}}
                        <button
                            type="button"
                            id="testimonialPrev"
                            class="testimonial-prev"
                            aria-label="Testimoni sebelumnya"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>

                        </button>


                        {{-- PANAH KANAN --}}
                        <button
                            type="button"
                            id="testimonialNext"
                            class="testimonial-next"
                            aria-label="Testimoni berikutnya"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M9 18l6-6-6-6"/>
                            </svg>

                        </button>

                    </div>


                    {{-- =================================================
                         DOTS DI BAWAH CARD
                    ================================================== --}}
                    <div
                        id="testimonialDots"
                        class="testimonial-dots"
                    >

                        @foreach($testimonials as $index => $t)

                            <button
                                type="button"
                                class="testimonial-dot {{ $index === 0 ? 'active' : '' }}"
                                data-testimonial-dot="{{ $index }}"
                                aria-label="Lihat testimoni {{ $index + 1 }}"
                            ></button>

                        @endforeach

                    </div>

                @endif

            </div>

        @endif

    </div>

</section>

{{-- =========================================================
     KLIEN & MITRA
========================================================= --}}
<section id="klien-mitra" class="py-20 bg-brand-cream">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="reveal text-center max-w-2xl mx-auto mb-4">

            <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-2">
                KLIEN &amp; MITRA
            </span>

            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-brand-forest mb-4">
                Klien &amp; Mitra Kami
            </h2>

            <p class="text-stone-500 text-sm sm:text-base leading-relaxed">
                {{ $settings['client_partner_intro'] ?? 'Kepercayaan dari klien dan mitra menjadi bagian penting dalam perjalanan Bumiyuji Living menghadirkan karya terbaik.' }}
            </p>

        </div>


        @php
            /*
             * =====================================================
             * DATA KLIEN & MITRA
             * =====================================================
             *
             * Sumber data tetap menggunakan $clientPartners.
             * Tidak ada perubahan database, model, atau controller.
             */

            $cpCollection = collect($clientPartners ?? []);

            $cpGroups = [
                [
                    'label' => 'Klien',
                    'items' => $cpCollection
                        ->filter(fn($cp) => ($cp->type ?? '') === 'client')
                        ->values(),
                ],
                [
                    'label' => 'Mitra',
                    'items' => $cpCollection
                        ->filter(fn($cp) => ($cp->type ?? '') === 'partner')
                        ->values(),
                ],
            ];
        @endphp


        @if($cpCollection->count() > 0)

            @foreach($cpGroups as $groupIndex => $group)

                {{-- Jangan tampilkan kelompok kosong --}}
                @continue($group['items']->count() === 0)


                @php
                    /*
                     * =====================================================
                     * INFINITE MARQUEE
                     * =====================================================
                     *
                     * Masalah sebelumnya:
                     * Jika logo hanya sedikit, misalnya 1-3 logo,
                     * track terlalu pendek sehingga terlihat seperti
                     * berhenti / reset.
                     *
                     * Solusi:
                     * Logo asli akan diulang beberapa kali sampai
                     * panjang minimal track mencukupi.
                     */

                    // Jumlah logo asli
                    $itemsCount = $group['items']->count();

                    // Perkiraan lebar 1 item + gap
                    // 170px item + 24px gap
                    $cpItemFootprint = 194;

                    // Minimal panjang satu putaran
                    $cpMinHalfWidth = 1300;

                    // Hitung berapa kali data asli perlu diulang
                    $cpRepeat = max(
                        1,
                        (int) ceil(
                            $cpMinHalfWidth /
                            max($itemsCount * $cpItemFootprint, 1)
                        )
                    );

                    /*
                     * Buat satu putaran penuh.
                     *
                     * Contoh jika data:
                     * A B C
                     *
                     * cpRepeat = 3
                     *
                     * hasil:
                     * A B C A B C A B C
                     */
                    $cpFullSet = collect();

                    for ($r = 0; $r < $cpRepeat; $r++) {
                        $cpFullSet = $cpFullSet->concat($group['items']);
                    }

                    /*
                     * Track akan menjadi:
                     *
                     * [cpFullSet] [cpFullSet]
                     *
                     * Animasi bergerak sampai -50%.
                     * Karena kedua sisi identik, posisi akhir
                     * sama dengan posisi awal sehingga loop
                     * terlihat seamless.
                     */

                    // Durasi berdasarkan jumlah item
                    $cpDuration = max(
                        $cpFullSet->count() * 4,
                        18
                    );
                @endphp


                {{-- =====================================================
                     GROUP
                ===================================================== --}}
                <div class="reveal {{ $groupIndex > 0 ? 'mt-14' : 'mt-8' }}">


                    {{-- Label Klien / Mitra --}}
                    <div class="flex justify-center mb-6">

                        <span
                            class="inline-flex items-center px-6 py-2 rounded-full
                                   bg-white text-brand-forest font-semibold text-sm
                                   shadow-sm border border-stone-200/70"
                        >
                            {{ $group['label'] }}
                        </span>

                    </div>


                    {{-- =================================================
                         MARQUEE
                    ================================================= --}}
                    <div class="cp-marquee-viewport">

                        <div
                            class="cp-marquee-track"
                            style="animation-duration: {{ $cpDuration }}s;"
                        >

                            {{-- =================================================
                                 SATU PUTARAN + SATU PUTARAN IDENTIK
                                 ================================================= --}}
                            @foreach($cpFullSet->concat($cpFullSet) as $cp)

                                <div
                                    class="cp-marquee-item"
                                    aria-hidden="{{ $loop->iteration > $itemsCount ? 'true' : 'false' }}"
                                >

                                    {{-- Logo Card --}}
                                    <div
                                        class="flex h-24 w-full items-center justify-center
                                               rounded-lg bg-white
                                               border border-stone-200/70
                                               p-4 shadow-sm
                                               transition-all duration-300
                                               hover:shadow-md
                                               hover:-translate-y-1
                                               hover:border-brand-gold/40"
                                    >

                                        @if($cp->logo)

                                            <img
                                                src="{{ Storage::url($cp->logo) }}"
                                                alt="{{ $cp->name }}"
                                                loading="lazy"
                                                class="max-h-14 max-w-full object-contain
                                                       grayscale opacity-80
                                                       transition-all duration-300
                                                       hover:grayscale-0
                                                       hover:opacity-100"
                                            >

                                        @else

                                            <span class="font-serif text-sm text-stone-400">
                                                {{ $cp->name }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endforeach

        @else

            {{-- Tidak ada data --}}
            <div
                class="border border-stone-200 bg-white
                       px-6 py-12 text-center rounded-lg"
            >

                <p class="text-sm text-stone-500">
                    Data klien dan mitra belum tersedia.
                </p>

            </div>

        @endif

    </div>

</section>

{{-- =========================================================
     APPOINTMENT / KONSULTASI
     Form sederhana -> WhatsApp
========================================================= --}}
<section id="kontak" class="py-20 bg-white">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Intro --}}
            <div class="reveal reveal-left">

                <span class="text-brand-gold font-semibold tracking-widest text-xs uppercase block mb-3">
                    KONSULTASI
                </span>

                <h2 class="font-serif text-4xl sm:text-5xl font-semibold text-brand-forest leading-tight mb-5">
                    Wujudkan Ruang Impian Anda
                </h2>

                <div class="w-16 h-[2px] bg-brand-gold mb-6"></div>

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
            <div class="reveal reveal-right bg-[#f1f1f1] rounded-2xl p-6 sm:p-8">

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
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
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
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
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
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
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
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm outline-none resize-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
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
                            class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm outline-none resize-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="Ceritakan kebutuhan interior Anda..."
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        class="btn-shine relative w-full overflow-hidden bg-brand-forest text-white font-semibold text-sm uppercase tracking-wide px-6 py-4 rounded-lg hover:bg-[#385047] transition"
                    >
                        Kirim Konsultasi via WhatsApp
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     FOOTER
========================================================= --}}
<footer class="bg-brand-charcoal text-white pt-16 pb-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">


        {{-- Brand --}}
        <div>

            <a href="#beranda" class="flex items-center gap-3 mb-4">

                @if(!empty($settings['logo_url']))

                    <img
                        src="{{ $settings['logo_url'] }}"
                        alt="{{ $settings['site_title'] ?? 'Logo' }}"
                        class="h-11 w-auto object-contain"
                    >

                @else

                    <span class="flex flex-col">

                        <span class="font-serif text-2xl tracking-widest font-bold text-white leading-none">
                            BUMIYUJI
                        </span>

                        <span class="text-[10px] tracking-[0.25em] font-medium text-brand-gold uppercase mt-1">
                            L I V I N G
                        </span>

                    </span>

                @endif

            </a>


            <p class="text-stone-400 text-xs sm:text-sm leading-relaxed">
                Mewujudkan ruang impian Anda menjadi kenyataan di Sukabumi, Jawa Barat.
            </p>


            <div class="text-xs text-stone-500 mt-4">

                <a
                    href="{{ route('admin.login') }}"
                    class="text-brand-gold hover:underline"
                >
                    🔐 Login Dashboard Admin
                </a>

            </div>

        </div>


        {{-- Contact --}}
        <div>

            <h4 class="font-serif font-bold text-lg text-brand-gold mb-6 uppercase">
                Contact Us
            </h4>

            <ul class="space-y-4 text-xs sm:text-sm text-stone-300">

                <li>
                    Alamat:
                    {{ $settings['address'] ?? '' }}
                </li>

                <li>
                    WhatsApp:
                    +{{ $settings['wa_number'] ?? '' }}
                </li>

                <li>
                    Email:
                    {{ $settings['email'] ?? '' }}
                </li>

            </ul>

        </div>


        {{-- Social --}}
        <div>

            <h4 class="font-serif font-bold text-lg text-brand-gold mb-6 uppercase">
                Social Media
            </h4>

            @if(!empty($settings['instagram']))

                <a
                    href="{{ $settings['instagram'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-stone-400 text-xs hover:text-brand-gold transition"
                >
                    Instagram
                </a>

            @else

                <p class="text-stone-400 text-xs">
                    Instagram belum tersedia.
                </p>

            @endif

        </div>

    </div>


    <div class="border-t border-stone-800 pt-8 text-center text-xs text-stone-500">

        &copy; {{ date('Y') }} Bumiyuji Living.
        Seluruh Hak Cipta Dilindungi.

    </div>

</footer>


{{-- =========================================================
     BACK TO TOP
========================================================= --}}
<button
    id="back-to-top"
    type="button"
    aria-label="Kembali ke atas"
    class="fixed bottom-6 right-6 z-50 flex h-11 w-11 items-center justify-center rounded-full bg-brand-forest text-brand-gold shadow-lg border border-brand-gold/30 hover:bg-brand-gold hover:text-brand-forest transition-colors duration-300"
>

    <svg
        class="w-5 h-5"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 15l7-7 7 7"
        />
    </svg>

</button>


{{-- =========================================================
     WHATSAPP FLOATING BUTTON
========================================================= --}}
<a
    href="https://wa.me/{{ $settings['wa_number'] ?? '6281311114523' }}?text=Halo%20Bumiyuji%2C%20saya%20ingin%20berkonsultasi%20mengenai%20desain%20interior."
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Chat WhatsApp"
    class="fixed bottom-6 left-6 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg hover:scale-110 transition-transform duration-300"
>

    <svg
        class="w-6 h-6"
        fill="currentColor"
        viewBox="0 0 24 24"
    >
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>

        <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M12.001 2C6.478 2 2 6.477 2 12c0 1.9.526 3.68 1.44 5.2L2 22l4.94-1.396A9.95 9.95 0 0012.001 22C17.524 22 22 17.523 22 12S17.524 2 12.001 2zm0 18.2a8.15 8.15 0 01-4.35-1.26l-.312-.19-3.033.858.834-2.958-.202-.318A8.15 8.15 0 013.85 12c0-4.5 3.65-8.15 8.151-8.15 4.5 0 8.15 3.65 8.15 8.15 0 4.501-3.65 8.2-8.15 8.2z"
        />

    </svg>

</a>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
<script>

    /* =========================================================
       MOBILE MENU
    ========================================================== */

    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    function closeMobileMenu() {

        if (!menuBtn || !mobileMenu) return;

        mobileMenu.classList.remove('open');
        menuBtn.classList.remove('open');

        menuBtn.setAttribute('aria-expanded', 'false');
        menuBtn.setAttribute('aria-label', 'Buka menu');

    }

    if (menuBtn && mobileMenu) {

        menuBtn.addEventListener('click', function () {

            const isOpen = mobileMenu.classList.toggle('open');

            menuBtn.classList.toggle('open', isOpen);

            menuBtn.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            menuBtn.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu' : 'Buka menu'
            );

        });

    }

    document.querySelectorAll('.mobile-nav-link').forEach(function (link) {

        link.addEventListener('click', closeMobileMenu);

    });


    /* =========================================================
       HEADER + BACK TO TOP
    ========================================================== */

    const siteHeader = document.getElementById('site-header');
    const backToTop = document.getElementById('back-to-top');

    function handleScroll() {

        if (siteHeader) {
            siteHeader.classList.toggle(
                'scrolled',
                window.scrollY > 20
            );
        }

        if (backToTop) {
            backToTop.classList.toggle(
                'show',
                window.scrollY > 400
            );
        }

    }

    window.addEventListener(
        'scroll',
        handleScroll,
        { passive: true }
    );

    handleScroll();


    if (backToTop) {

        backToTop.addEventListener('click', function () {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        });

    }

/* =========================================================
   ACTIVE NAVIGATION
========================================================== */

const navLinks = document.querySelectorAll('.nav-link');

function updateActiveNavigation() {
    const scrollPosition = window.scrollY + 150;

    let currentId = '#beranda';

    document.querySelectorAll(
        '#beranda, #tentang, #layanan, #portofolio, #alur-kerja, #kontak'
    ).forEach(function (section) {

        if (section.offsetTop <= scrollPosition) {
            currentId = '#' + section.id;
        }

    });

    navLinks.forEach(function (link) {
        link.classList.toggle(
            'active',
            link.getAttribute('href') === currentId
        );
    });
}

window.addEventListener(
    'scroll',
    updateActiveNavigation,
    { passive: true }
);

updateActiveNavigation();

    /* =========================================================
       SCROLL REVEAL
    ========================================================== */

    if ('IntersectionObserver' in window) {

        const revealObserver = new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.add('is-visible');

                        revealObserver.unobserve(entry.target);

                    }

                });

            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        document.querySelectorAll('.reveal').forEach(function (element) {

            revealObserver.observe(element);

        });

    } else {

        document.querySelectorAll('.reveal').forEach(function (element) {

            element.classList.add('is-visible');

        });

    }


    /* =========================================================
       PORTFOLIO FILTER + CAROUSEL (INFINITE MARQUEE)
       - Desktop: 3 kartu terlihat
       - Tablet : 2 kartu terlihat
       - Mobile : 1 kartu terlihat
       - Kartu bergerak terus menerus (marquee) dengan kecepatan
         konstan, tanpa pernah terlihat berhenti atau "loncat"
         balik ke kartu pertama.
       - Pause saat hover / touch / swipe, lalu jalan lagi otomatis.
       - Tombol Next/Prev tetap bisa dipakai untuk geser manual.
       - Filter kategori tetap berjalan seperti sebelumnya.

       ---------------------------------------------------------
       KENAPA CAROUSEL LAMA TERLIHAT "PATAH" / TIDAK SEAMLESS?
       ---------------------------------------------------------
       Versi sebelumnya adalah carousel "per halaman": track digeser
       sejauh lebar viewport tiap kali pindah halaman, memakai CSS
       transition. Begitu sampai halaman terakhir, variabel halaman
       cuma di-reset ke 0 lalu transform ikut dikembalikan ke 0 —
       padahal transisinya tetap aktif. Akibatnya, track terlihat
       meluncur MUNDUR jauh dari halaman terakhir ke halaman
       pertama, alih-alih terasa seperti barisan kartu yang tidak
       pernah putus. Itu sebabnya terasa "berhenti sebentar" lalu
       "loncat balik" — bukan loop yang mulus.

       SOLUSINYA (teknik yang dipakai di bawah ini):
       1. Kartu kategori yang sedang tampil di-KLON (digandakan) dan
          ditempel berulang setelah kartu asli, sampai total lebar
          track jauh lebih panjang dari layar.
       2. Track digeser terus-menerus ke kiri sedikit demi sedikit
          setiap frame (bukan meloncat per halaman).
       3. Begitu track sudah bergeser sejauh persis satu "pola"
          (yaitu lebar seluruh kartu asli yang sedang tampil), posisi
          langsung ditambah kembali sebesar satu pola itu juga.
          Karena kartu klon di posisi itu SAMA PERSIS dengan kartu
          asli di posisi awal, lompatan ini tidak terlihat sama
          sekali oleh mata — hasilnya terasa seperti barisan kartu
          tanpa akhir.
    ========================================================== */

    const portfolioFilterButtons =
        document.querySelectorAll('.portfolio-filter');

    const portfolioGrid =
        document.getElementById('portfolio-grid');

    const portfolioViewport =
        document.getElementById('portfolio-viewport');

    const portfolioPrev =
        document.getElementById('portfolio-prev');

    const portfolioNext =
        document.getElementById('portfolio-next');

    /*
     * PENTING: ini adalah snapshot kartu ASLI hasil render Blade,
     * diambil SEBELUM kita menambahkan kartu hasil kloning.
     * Kode di bagian modal (di bawah file ini) memakai variabel
     * "portfolioItems" ini juga untuk membuka detail portofolio,
     * jadi isinya sengaja tidak boleh berubah.
     */
    const portfolioItems =
        document.querySelectorAll('.portfolio-item');

    /*
     * Apakah pengguna mengaktifkan "reduce motion" di perangkatnya?
     * Kalau iya, kita matikan gerakan otomatis (marquee) supaya
     * tidak memicu pusing/mual, tapi tombol next/prev tetap jalan.
     */
    const portfolioReducedMotion =
        typeof window.matchMedia === 'function' &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /*
     * Kecepatan geser otomatis, dalam pixel per detik.
     * Dipakai bersama delta waktu antar frame supaya kecepatannya
     * selalu konstan, tidak peduli seberapa cepat/lambat frame rate
     * perangkat pengguna.
     */
    const PORTFOLIO_SPEED_PX_PER_SEC = 45;

    /*
     * Durasi animasi halus saat tombol Next/Prev ditekan (ms).
     */
    const PORTFOLIO_STEP_DURATION = 450;

    /* Posisi geser track saat ini (selalu <= 0). */
    let portfolioTranslateX = 0;

    /* Lebar (px) satu "pola" penuh = total lebar kartu yang sedang tampil. */
    let portfolioPatternWidth = 0;

    /* Lebar (px) satu langkah kartu, dipakai tombol Next/Prev. */
    let portfolioItemStep = 0;

    let portfolioRafId = null;
    let portfolioLastFrameTime = null;
    let portfolioIsAnimatingStep = false;
    let portfolioResumeTimer = null;

    let portfolioTouchStartX = 0;
    let portfolioTouchStartY = 0;
    let portfolioIsPointerDown = false;

    function getVisiblePortfolioItems() {
        return Array.from(portfolioItems).filter(function (item) {
            return !item.classList.contains('hidden');
        });
    }

    function applyPortfolioTransform() {
        portfolioGrid.style.transform =
            'translate3d(' + portfolioTranslateX + 'px, 0, 0)';
    }

    /*
     * Membuang semua kartu hasil kloning yang lama, supaya bisa
     * dibangun ulang (dipakai lagi setiap ganti filter / resize).
     */
    function clearPortfolioClones() {
        portfolioGrid
            .querySelectorAll('.portfolio-item[data-portfolio-clone="true"]')
            .forEach(function (clone) {
                clone.remove();
            });
    }

    /*
     * Menempelkan satu set salinan (clone) dari kartu-kartu yang
     * sedang tampil, tepat setelah kartu aslinya di dalam track.
     */
    function appendPortfolioCloneSet(visibleOriginals) {
        visibleOriginals.forEach(function (original) {
            const clone = original.cloneNode(true);

            /* Tandai sebagai duplikat, sembunyikan dari screen reader. */
            clone.setAttribute('data-portfolio-clone', 'true');
            clone.setAttribute('aria-hidden', 'true');
            clone.setAttribute('tabindex', '-1');

            portfolioGrid.appendChild(clone);
        });
    }

    /*
     * Inti dari teknik "infinite marquee":
     * membangun ulang track = [kartu asli yang tampil] + [kloningan
     * berulang], lalu mengukur lebar satu pola penuh berdasarkan
     * posisi asli DOM (bukan tebak-tebakan lewat rumus CSS), supaya
     * hasilnya akurat di breakpoint manapun.
     */
    function buildPortfolioClones() {
        clearPortfolioClones();

        const visibleOriginals = getVisiblePortfolioItems();

        if (visibleOriginals.length === 0) {
            portfolioPatternWidth = 0;
            portfolioItemStep = 0;
            return;
        }

        /* Tempel satu set klon dulu untuk keperluan pengukuran. */
        appendPortfolioCloneSet(visibleOriginals);

        const firstOriginalRect =
            visibleOriginals[0].getBoundingClientRect();

        const firstClone =
            portfolioGrid.querySelector('.portfolio-item[data-portfolio-clone="true"]');

        const firstCloneRect = firstClone.getBoundingClientRect();

        /* Jarak dari kartu asli pertama ke klon pertama = 1 pola penuh. */
        portfolioPatternWidth = firstCloneRect.left - firstOriginalRect.left;
        portfolioItemStep = portfolioPatternWidth / visibleOriginals.length;

        if (!(portfolioPatternWidth > 0)) {
            portfolioPatternWidth = 0;
            return;
        }

        /*
         * Supaya tidak pernah ada area kosong (misalnya karena hasil
         * filter cuma menyisakan 1-2 kartu), gandakan terus sampai
         * total lebar track minimal 2x lebar viewport yang terlihat.
         */
        const viewportWidth = portfolioViewport.clientWidth || 0;
        const minTotalWidth = viewportWidth * 2;

        let extraRepeats =
            Math.ceil(minTotalWidth / portfolioPatternWidth) - 1;

        /* Batasi jumlah pengulangan supaya DOM tidak membengkak. */
        extraRepeats = Math.max(0, Math.min(extraRepeats, 24));

        for (let r = 0; r < extraRepeats; r++) {
            appendPortfolioCloneSet(visibleOriginals);
        }
    }

    /*
     * Loop animasi utama. Dipanggil terus oleh requestAnimationFrame
     * selama carousel aktif berjalan.
     */
    function portfolioAutoTick(now) {
        if (portfolioLastFrameTime === null) {
            portfolioLastFrameTime = now;
        }

        const deltaSeconds = (now - portfolioLastFrameTime) / 1000;
        portfolioLastFrameTime = now;

        /*
         * Jangan gerakkan otomatis kalau sedang ada animasi tombol
         * Next/Prev yang berjalan, supaya keduanya tidak "rebutan"
         * posisi track.
         */
        if (!portfolioIsAnimatingStep && portfolioPatternWidth > 0) {
            portfolioTranslateX -=
                PORTFOLIO_SPEED_PX_PER_SEC * deltaSeconds;

            /*
             * Titik kunci "seamless loop": begitu sudah bergeser
             * sejauh satu pola penuh, tambahkan kembali sebesar satu
             * pola. Karena klon di titik itu identik dengan kartu
             * asli di posisi awal, pengguna tidak akan melihat
             * lompatan ini sama sekali.
             */
            if (portfolioTranslateX <= -portfolioPatternWidth) {
                portfolioTranslateX += portfolioPatternWidth;
            }

            applyPortfolioTransform();
        }

        portfolioRafId = requestAnimationFrame(portfolioAutoTick);
    }

    function startPortfolioAutoSlide() {
        if (portfolioRafId !== null) {
            return;
        }

        if (portfolioPatternWidth <= 0 || portfolioReducedMotion) {
            return;
        }

        portfolioLastFrameTime = null;
        portfolioRafId = requestAnimationFrame(portfolioAutoTick);
    }

    function stopPortfolioAutoSlide() {
        if (portfolioRafId !== null) {
            cancelAnimationFrame(portfolioRafId);
            portfolioRafId = null;
        }
    }

    function pausePortfolioAndResume() {
        stopPortfolioAutoSlide();

        if (portfolioResumeTimer) {
            clearTimeout(portfolioResumeTimer);
        }

        /*
         * Setelah user selesai berinteraksi, tunggu 3 detik
         * sebelum marquee jalan otomatis lagi.
         */
        portfolioResumeTimer = setTimeout(function () {
            startPortfolioAutoSlide();
        }, 3000);
    }

    /*
     * Geser track sejauh satu kartu, dipakai oleh tombol Next/Prev.
     * direction: 1 = maju (Next), -1 = mundur (Prev).
     * Animasinya halus (eased), lalu di akhir animasi posisinya
     * dirapikan (dibungkus) supaya tetap berada dalam rentang satu
     * pola, sehingga marquee otomatis bisa lanjut tanpa ada celah.
     */
    function stepPortfolioTrack(direction) {
        if (portfolioPatternWidth <= 0 || portfolioIsAnimatingStep) {
            return;
        }

        portfolioIsAnimatingStep = true;

        const startX = portfolioTranslateX;
        const targetX = startX + (-direction * portfolioItemStep);
        const startTime = performance.now();

        function tick(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / PORTFOLIO_STEP_DURATION, 1);

            /* easeInOutQuad, biar gerakan halus di awal & akhir. */
            const eased = progress < 0.5
                ? 2 * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 2) / 2;

            portfolioTranslateX = startX + (targetX - startX) * eased;
            applyPortfolioTransform();

            if (progress < 1) {
                requestAnimationFrame(tick);
                return;
            }

            /*
             * Animasi selesai. Bungkus (wrap) posisi supaya tetap
             * berada di rentang (-portfolioPatternWidth, 0], persis
             * seperti yang dilakukan marquee otomatis. Karena
             * bungkusannya persis satu pola, tidak ada lompatan yang
             * terlihat.
             */
            while (portfolioTranslateX <= -portfolioPatternWidth) {
                portfolioTranslateX += portfolioPatternWidth;
            }

            while (portfolioTranslateX > 0) {
                portfolioTranslateX -= portfolioPatternWidth;
            }

            applyPortfolioTransform();
            portfolioIsAnimatingStep = false;
        }

        requestAnimationFrame(tick);
    }

    function nextPortfolio() {
        stepPortfolioTrack(1);
    }

    function prevPortfolio() {
        stepPortfolioTrack(-1);
    }

    /*
     * Membangun ulang carousel dari nol: dipakai saat pertama kali
     * halaman dibuka, saat filter kategori berganti, dan saat ukuran
     * layar berubah (resize).
     */
    function rebuildPortfolioCarousel() {
        stopPortfolioAutoSlide();

        portfolioTranslateX = 0;
        applyPortfolioTransform();

        buildPortfolioClones();

        const visibleOriginals = getVisiblePortfolioItems();

        if (visibleOriginals.length === 0) {
            /* Tidak ada kartu untuk kategori ini: sembunyikan tombol. */
            if (portfolioPrev) {
                portfolioPrev.classList.add('hidden');
            }

            if (portfolioNext) {
                portfolioNext.classList.add('hidden');
            }

            return;
        }

        /*
         * Ini carousel tanpa akhir (infinite), jadi tombol Next/Prev
         * selalu aktif selama ada minimal satu kartu untuk ditampilkan.
         */
        if (portfolioPrev) {
            portfolioPrev.classList.remove('hidden');
            portfolioPrev.classList.remove('disabled');
        }

        if (portfolioNext) {
            portfolioNext.classList.remove('hidden');
            portfolioNext.classList.remove('disabled');
        }

        startPortfolioAutoSlide();
    }

    if (portfolioGrid && portfolioViewport) {

        if (portfolioPrev) {
            portfolioPrev.addEventListener('click', function () {
                pausePortfolioAndResume();
                prevPortfolio();
            });
        }

        if (portfolioNext) {
            portfolioNext.addEventListener('click', function () {
                pausePortfolioAndResume();
                nextPortfolio();
            });
        }

        /*
         * Filter kategori (perilaku tombolnya sama seperti sebelumnya).
         */
        portfolioFilterButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const filter =
                    button.getAttribute('data-filter');

                portfolioFilterButtons.forEach(function (item) {

                    item.classList.remove(
                        'bg-brand-forest',
                        'text-white'
                    );

                    item.classList.add(
                        'bg-brand-cream',
                        'text-brand-forest'
                    );

                });

                button.classList.remove(
                    'bg-brand-cream',
                    'text-brand-forest'
                );

                button.classList.add(
                    'bg-brand-forest',
                    'text-white'
                );

                portfolioItems.forEach(function (item) {

                    const category =
                        item.getAttribute('data-category');

                    if (
                        filter === 'all' ||
                        category === filter
                    ) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }

                });

                /*
                 * Kategori berganti -> bangun ulang track (kloningan
                 * lama dibuang, dibuat ulang dari kartu yang sekarang
                 * terlihat), lalu marquee lanjut berjalan seamless.
                 */
                rebuildPortfolioCarousel();

                pausePortfolioAndResume();

            });

        });

        /*
         * Pause ketika mouse berada di area portfolio.
         * Saat mouse keluar, marquee berjalan lagi.
         */
        portfolioViewport.addEventListener('mouseenter', function () {
            stopPortfolioAutoSlide();

            if (portfolioResumeTimer) {
                clearTimeout(portfolioResumeTimer);
            }
        });

        portfolioViewport.addEventListener('mouseleave', function () {
            startPortfolioAutoSlide();
        });

        /*
         * Touch / swipe untuk HP.
         */
        portfolioViewport.addEventListener(
            'touchstart',
            function (event) {

                if (!event.touches || !event.touches[0]) {
                    return;
                }

                portfolioIsPointerDown = true;
                portfolioTouchStartX =
                    event.touches[0].clientX;

                portfolioTouchStartY =
                    event.touches[0].clientY;

                stopPortfolioAutoSlide();

                if (portfolioResumeTimer) {
                    clearTimeout(portfolioResumeTimer);
                }

            },
            { passive: true }
        );

        portfolioViewport.addEventListener(
            'touchend',
            function (event) {

                if (!portfolioIsPointerDown) {
                    return;
                }

                portfolioIsPointerDown = false;

                if (!event.changedTouches || !event.changedTouches[0]) {
                    startPortfolioAutoSlide();
                    return;
                }

                const touchEndX =
                    event.changedTouches[0].clientX;

                const touchEndY =
                    event.changedTouches[0].clientY;

                const diffX =
                    touchEndX - portfolioTouchStartX;

                const diffY =
                    touchEndY - portfolioTouchStartY;

                /*
                 * Hanya anggap sebagai swipe jika gerakan
                 * horizontal lebih besar daripada vertikal.
                 */
                if (
                    Math.abs(diffX) > 50 &&
                    Math.abs(diffX) > Math.abs(diffY)
                ) {

                    if (diffX < 0) {
                        nextPortfolio();
                    } else {
                        prevPortfolio();
                    }

                }

                pausePortfolioAndResume();

            },
            { passive: true }
        );

        /*
         * Kartu hasil kloning tidak punya event listener modal
         * sendiri (listener aslinya ditempel belakangan, khusus ke
         * kartu asli — lihat bagian "OPEN PORTFOLIO MODAL" di bawah).
         * Supaya tetap bisa dibuka detailnya, kita pakai delegasi
         * event di sini: klik pada kartu klon akan memanggil
         * openPortfolioModal() yang didefinisikan di bagian modal.
         */
        portfolioGrid.addEventListener('click', function (event) {

            const clone = event.target.closest(
                '.portfolio-item[data-portfolio-clone="true"]'
            );

            if (!clone) {
                return;
            }

            const id = clone.getAttribute('data-portfolio-id');

            if (typeof openPortfolioModal === 'function') {
                openPortfolioModal(id);
            }

        });

        /*
         * Resize browser: ukuran kartu berubah (3/2/1 kolom), jadi
         * track perlu dibangun ulang supaya pola & kecepatannya
         * tetap presisi.
         */
        let portfolioResizeTimer = null;

        window.addEventListener('resize', function () {

            clearTimeout(portfolioResizeTimer);

            portfolioResizeTimer = setTimeout(function () {
                rebuildPortfolioCarousel();
            }, 120);

        });

        /*
         * Inisialisasi pertama.
         */
        rebuildPortfolioCarousel();

    }

    /* =========================================================
       OPEN PORTFOLIO MODAL
    ========================================================== */

    const portfolioDataElement =
        document.getElementById('portfolio-data');

    let portfolioData = [];

    if (portfolioDataElement) {

        try {

            portfolioData =
                JSON.parse(
                    portfolioDataElement.textContent || '[]'
                );

        } catch (error) {

            console.error(
                'Gagal membaca data portfolio:',
                error
            );

            portfolioData = [];

        }

    }


    const portfolioModal =
        document.getElementById('portfolio-modal');

    const portfolioModalClose =
        document.getElementById('portfolio-modal-close');

    const portfolioModalBackdrop =
        document.getElementById('portfolio-modal-backdrop');

    const pmTitle =
        document.getElementById('pm-title');

    const pmCategory =
        document.getElementById('pm-category-badge');

    const pmMainImage =
        document.getElementById('pm-main-image');

    const pmTimeline =
        document.getElementById('pm-timeline');

    const pmPhaseBox =
        document.getElementById('pm-phase-box');

    const pmGallery =
        document.getElementById('pm-gallery');


    let activePortfolio = null;
    let activePhaseIndex = 0;


    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;

    }


    function findPortfolioById(id) {

        return portfolioData.find(function (portfolio) {

            return String(portfolio.id) === String(id);

        });

    }


    function setMainImage(url) {

        if (!pmMainImage || !url) return;

        pmMainImage.style.opacity = '0';

        setTimeout(function () {

            pmMainImage.src = url;
            pmMainImage.style.opacity = '1';

        }, 120);

    }


    function setActivePhase(index) {

        activePhaseIndex = index;

        renderPortfolioModal();

    }


    function renderPortfolioModal() {

        if (!activePortfolio) return;


        const phases =
            Array.isArray(activePortfolio.phases)
                ? activePortfolio.phases
                : [];


        if (pmTitle) {
            pmTitle.textContent =
                activePortfolio.title || '';
        }


        if (pmCategory) {
            pmCategory.textContent =
                activePortfolio.category || '';
        }


        if (!phases.length) {

            if (pmTimeline) {
                pmTimeline.innerHTML = '';
            }

            if (pmPhaseBox) {

                pmPhaseBox.innerHTML = `
                    <p class="text-sm text-stone-400">
                        Belum ada data progres untuk proyek ini.
                    </p>
                `;

            }

            if (pmGallery) {
                pmGallery.innerHTML = '';
            }

            setMainImage(
                activePortfolio.image_url || ''
            );

            return;

        }


        /* -----------------------------------------------------
           Timeline
        ------------------------------------------------------ */

        if (pmTimeline) {

            pmTimeline.innerHTML = `
                <div class="absolute left-0 right-0 top-3 h-px bg-white/15"></div>
            `;


            phases.forEach(function (phase, index) {

                const isActive =
                    index === activePhaseIndex;

                const isDone =
                    index < activePhaseIndex;


                const circleClass =
                    isActive
                        ? 'bg-brand-gold text-brand-forest ring-4 ring-brand-gold/25'
                        : isDone
                            ? 'bg-brand-gold/70 text-brand-forest'
                            : 'bg-white/10 text-white/60';


                const button =
                    document.createElement('button');

                button.type = 'button';

                button.className =
                    'relative z-10 flex flex-col items-center gap-2 flex-1 group';


                button.innerHTML = `
                    <span class="flex h-7 w-7 items-center justify-center rounded-full text-[11px] font-bold transition-all duration-300 ${circleClass}">
                        ${escapeHtml(phase.percentage ?? 0)}%
                    </span>

                    <span class="text-[11px] uppercase tracking-wide text-center transition-colors ${
                        isActive
                            ? 'text-white font-semibold'
                            : 'text-stone-400 group-hover:text-stone-200'
                    }">
                        ${escapeHtml(phase.title ?? '')}
                    </span>
                `;


                button.addEventListener(
                    'click',
                    function () {
                        setActivePhase(index);
                    }
                );


                pmTimeline.appendChild(button);

            });

        }


        /* -----------------------------------------------------
           Active phase
        ------------------------------------------------------ */

        const phase =
            phases[activePhaseIndex];


        if (pmPhaseBox) {

            pmPhaseBox.innerHTML = `

                <span class="text-brand-gold font-semibold text-xs uppercase tracking-wider block mb-1.5">
                    ${escapeHtml(phase.title ?? '')}
                </span>

                <p class="text-sm text-stone-300 leading-relaxed">
                    ${
                        phase.description
                            ? escapeHtml(phase.description)
                            : 'Belum ada dokumentasi untuk tahap ini.'
                    }
                </p>

            `;

        }


        /* -----------------------------------------------------
           Gallery
        ------------------------------------------------------ */

        const images =
            Array.isArray(phase.images)
                ? phase.images
                : [];


        if (!pmGallery) return;


        pmGallery.innerHTML = '';


        if (!images.length) {

            pmGallery.innerHTML = `
                <p class="col-span-full text-xs text-stone-400">
                    Belum ada foto pada tahap ini.
                </p>
            `;

            setMainImage(
                activePortfolio.image_url || ''
            );

            return;

        }


        images.forEach(function (url, index) {

            const button =
                document.createElement('button');

            button.type = 'button';

            button.className =
                'aspect-square overflow-hidden rounded-lg border border-white/10 hover:border-brand-gold transition-colors duration-200';


            const image =
                document.createElement('img');

            image.src = url;

            image.alt =
                'Galeri progres ' + (index + 1);

            image.className =
                'h-full w-full object-cover';


            button.appendChild(image);


            button.addEventListener(
                'click',
                function () {
                    setMainImage(url);
                }
            );


            pmGallery.appendChild(button);

        });


        setMainImage(images[0]);

    }


    function openPortfolioModal(id) {

        const project =
            findPortfolioById(id);

        if (!project || !portfolioModal) {
            return;
        }


        activePortfolio = project;
        activePhaseIndex = 0;


        renderPortfolioModal();


        portfolioModal.classList.remove('hidden');
        portfolioModal.classList.add('flex');

        portfolioModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow = 'hidden';

    }


    function closePortfolioModal() {

        if (!portfolioModal) return;


        portfolioModal.classList.add('hidden');
        portfolioModal.classList.remove('flex');

        portfolioModal.setAttribute(
            'aria-hidden',
            'true'
        );


        document.body.style.overflow = '';

        activePortfolio = null;

    }


    /* Portfolio card click */

    portfolioItems.forEach(function (item) {

        item.addEventListener('click', function () {

            const id =
                item.getAttribute('data-portfolio-id');

            openPortfolioModal(id);

        });

    });


    if (portfolioModalClose) {

        portfolioModalClose.addEventListener(
            'click',
            closePortfolioModal
        );

    }


    if (portfolioModalBackdrop) {

        portfolioModalBackdrop.addEventListener(
            'click',
            closePortfolioModal
        );

    }


    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                activePortfolio
            ) {

                closePortfolioModal();

            }

        }
    );


  /* =========================================================
   TESTIMONI SLIDER
   - 1 TESTIMONI PER TAMPILAN
   - AUTO GESER 3 DETIK
   - TRANSISI HALUS
   - PANAH KIRI / KANAN
   - DOTS
 ========================================================= */

 const slider = document.getElementById('testimonialSlider');
 const track = document.getElementById('testimonialTrack');
 const prevButton = document.getElementById('testimonialPrev');
 const nextButton = document.getElementById('testimonialNext');
 const dots = document.querySelectorAll('.testimonial-dot');
 const testimonialSlides = document.querySelectorAll('.testimonial-slide');

 let testimonialIndex = 0;
 let testimonialTimer = null;

 function updateTestimonial(index) {
     if (!track || !testimonialSlides.length) return;

     const total = testimonialSlides.length;

     if (index >= total) index = 0;
     if (index < 0) index = total - 1;

     testimonialIndex = index;

     /*
      * Geser TRACK, bukan masing-masing card.
      * Dengan cara ini 1 card selalu memenuhi viewport
      * dan card pertama langsung terlihat saat halaman dibuka.
      */
     track.style.transform = `translate3d(-${index * 100}%, 0, 0)`;

     dots.forEach(function (dot, i) {
         dot.classList.toggle('active', i === index);
     });
 }

 function nextTestimonial() {
     updateTestimonial(testimonialIndex + 1);
     restartTestimonialTimer();
 }

 function previousTestimonial() {
     updateTestimonial(testimonialIndex - 1);
     restartTestimonialTimer();
 }

 if (prevButton) {
     prevButton.addEventListener('click', previousTestimonial);
 }

 if (nextButton) {
     nextButton.addEventListener('click', nextTestimonial);
 }

 dots.forEach(function (dot, index) {
     dot.addEventListener('click', function () {
         updateTestimonial(index);
         restartTestimonialTimer();
     });
 });

 function startTestimonialTimer() {
     if (testimonialSlides.length <= 1) return;

     if (testimonialTimer) {
         clearInterval(testimonialTimer);
     }

     testimonialTimer = setInterval(function () {
         updateTestimonial(testimonialIndex + 1);
     }, 3000);
 }

 function restartTestimonialTimer() {
     startTestimonialTimer();
 }

 /* TAMPILKAN CARD PERTAMA SEJAK AWAL */
 updateTestimonial(0);
 startTestimonialTimer();

    /* =========================================================
       APPOINTMENT -> WHATSAPP
    ========================================================== */

    function handleFormSubmit(event) {

        event.preventDefault();


        const name =
            document.getElementById('form-name')?.value.trim() || '';

        const phone =
            document.getElementById('form-phone')?.value.trim() || '';

        const email =
            document.getElementById('form-email')?.value.trim() || '-';

        const address =
            document.getElementById('form-address')?.value.trim() || '';

        const project =
            document.getElementById('form-project')?.value.trim() || '';


        if (!name || !phone || !address || !project) {

            alert(
                'Mohon lengkapi data yang wajib diisi.'
            );

            return;

        }


        let waText =
            'Halo Bumiyuji Living,%0A%0A';

        waText +=
            'Saya ingin berkonsultasi mengenai desain interior.%0A%0A';

        waText +=
            '*Nama:* ' + name + '%0A';

        waText +=
            '*No. HP/WA:* ' + phone + '%0A';

        waText +=
            '*Email:* ' + email + '%0A';

        waText +=
            '*Alamat Proyek:* ' + address + '%0A';

        waText +=
            '*Rencana Project:* ' + project;


        const waNumber =
            @json($settings['wa_number'] ?? '6281311114523');


        const url =
            'https://wa.me/' +
            waNumber +
            '?text=' +
            encodeURIComponent(
                waText
                    .replaceAll('%0A', '\n')
            );


        window.open(
            url,
            '_blank',
            'noopener,noreferrer'
        );

    }


    /* =========================================================
       SMOOTH SCROLL
    ========================================================== */

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {

        link.addEventListener('click', function (event) {

            const targetId =
                link.getAttribute('href');

            if (
                !targetId ||
                targetId === '#'
            ) {
                return;
            }


            const target =
                document.querySelector(targetId);


            if (!target) {
                return;
            }


            event.preventDefault();


            const headerHeight =
                siteHeader
                    ? siteHeader.offsetHeight
                    : 0;


            const targetPosition =
                target.getBoundingClientRect().top +
                window.scrollY -
                headerHeight -
                10;


            window.scrollTo({

                top: targetPosition,

                behavior: 'smooth'

            });

        });

    });

</script>

</body>
</html>