<section id="testimoni" class="py-20 bg-brand-cream relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        {{-- HEADER --}}
        <div class="text-center mb-10 lg:mb-14 reveal">

            <h2 class="text-4xl sm:text-5xl lg:text-[52px] font-semibold tracking-tight text-black">
                TESTIMONI &amp; FAQ
            </h2>

            <div class="divider-grow origin-center w-20 h-[1.5px] bg-brand-gold mx-auto mt-3" data-divider></div>

            <p class="mt-5 max-w-2xl mx-auto text-sm sm:text-base text-stone-500">
                Kepuasan klien adalah prioritas kami. Berikut testimoni dari pelanggan kami
                serta jawaban atas pertanyaan yang sering diajukan.
            </p>

        </div>


        {{-- =================================================
             DUA KOLOM: TESTIMONI (kiri) + FAQ (kanan)
             Di mobile, tumpuk ke bawah (1 kolom).
        ================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1.15fr_1fr] gap-10 lg:gap-12 items-start">

            {{-- =================================================
                 KOLOM KIRI — TESTIMONI SLIDER
            ================================================== --}}
            <div class="reveal reveal-left">

                @if(empty($testimonials) || count($testimonials) === 0)

                    <div class="flex h-full min-h-[400px] items-center justify-center rounded-[30px] border border-dashed border-brand-gold/30 bg-white/60 text-center py-12">
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
                        class="testimonial-slider !mx-0 !max-w-none"
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


            {{-- =================================================
                 KOLOM KANAN — FAQ ACCORDION
            ================================================== --}}
            <div class="reveal reveal-right">

                <div class="relative h-full rounded-[30px] border border-brand-gold/15 bg-white/80 backdrop-blur-sm shadow-sm p-6 sm:p-8 overflow-hidden">

                    {{-- dekorasi blob halus di pojok --}}
                    <div class="pointer-events-none absolute -top-10 -right-10 h-32 w-32 rounded-full bg-brand-gold/10"></div>

                    {{-- HEADER FAQ --}}
                    <div class="relative flex items-center gap-3 mb-6">

                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-forest text-brand-gold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>

                        <div>
                            <h3 class="font-serif text-2xl font-semibold text-black leading-none">FAQ</h3>
                            <p class="text-xs text-stone-400 mt-1">Pertanyaan yang sering ditanyakan</p>
                        </div>

                    </div>

                    {{-- JIKA BELUM ADA FAQ --}}
                    @if(empty($faqs) || count($faqs) === 0)

                        <div class="relative rounded-2xl border border-dashed border-brand-gold/30 py-10 text-center">
                            <p class="text-stone-400 text-sm">Belum ada FAQ.</p>
                        </div>

                    @else

                        <div id="faqAccordion" class="relative space-y-3">

                            @foreach($faqs as $index => $faq)

                                <div class="faq-item rounded-2xl overflow-hidden transition-colors duration-300 {{ $index === 0 ? 'bg-brand-forest' : 'bg-brand-cream/70 hover:bg-brand-gold/10' }}">

                                    <button
                                        type="button"
                                        class="faq-question w-full flex items-center justify-between gap-4 text-left px-5 py-4"
                                        data-faq-toggle="{{ $index }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    >
                                        <span class="flex items-start gap-3">
                                            <span class="text-xs font-semibold mt-0.5 {{ $index === 0 ? 'text-brand-gold' : 'text-brand-gold/80' }}">
                                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <span class="text-sm sm:text-[15px] font-medium leading-snug {{ $index === 0 ? 'text-white' : 'text-stone-800' }}">
                                                {{ $faq->question }}
                                            </span>
                                        </span>

                                        <span class="faq-icon flex h-6 w-6 shrink-0 items-center justify-center rounded-full border {{ $index === 0 ? 'border-white/30 text-white' : 'border-brand-forest/20 text-brand-forest' }}">
                                            <svg class="faq-icon-plus h-3.5 w-3.5 {{ $index === 0 ? 'hidden' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                            <svg class="faq-icon-minus h-3.5 w-3.5 {{ $index === 0 ? '' : 'hidden' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15"/></svg>
                                        </span>
                                    </button>

                                    <div
                                        class="faq-panel px-5 grid transition-[grid-template-rows] duration-300 ease-out"
                                        style="grid-template-rows: {{ $index === 0 ? '1fr' : '0fr' }};"
                                    >
                                        <div class="overflow-hidden">
                                            <p class="pb-4 text-sm leading-relaxed {{ $index === 0 ? 'text-white/85' : 'text-stone-500' }}">
                                                {{ $faq->answer }}
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                    <p class="relative mt-8 text-right font-serif italic text-brand-gold/70 text-sm sm:text-base">
                        Jadikan Ruang <br class="hidden sm:block"> Lebih Bermakna
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

@if(!empty($faqs) && count($faqs) > 0)
    <script>
        (function () {
            const accordion = document.getElementById('faqAccordion');
            if (!accordion) return;

            const items = Array.from(accordion.querySelectorAll('.faq-item'));

            function setOpen(item, open) {
                const panel = item.querySelector('.faq-panel');
                const plus = item.querySelector('.faq-icon-plus');
                const minus = item.querySelector('.faq-icon-minus');
                const btn = item.querySelector('.faq-question');
                const question = item.querySelector('.faq-question > span:first-child > span:last-child');
                const number = item.querySelector('.faq-question > span:first-child > span:first-child');
                const iconWrap = item.querySelector('.faq-icon');
                const answer = item.querySelector('.faq-panel p');

                panel.style.gridTemplateRows = open ? '1fr' : '0fr';
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');

                plus.classList.toggle('hidden', open);
                minus.classList.toggle('hidden', !open);

                item.classList.toggle('bg-brand-forest', open);
                item.classList.toggle('bg-brand-cream/70', !open);
                item.classList.toggle('hover:bg-brand-gold/10', !open);

                question.classList.toggle('text-white', open);
                question.classList.toggle('text-stone-800', !open);

                number.classList.toggle('text-brand-gold', open);
                number.classList.toggle('text-brand-gold/80', !open);

                iconWrap.classList.toggle('border-white/30', open);
                iconWrap.classList.toggle('text-white', open);
                iconWrap.classList.toggle('border-brand-forest/20', !open);
                iconWrap.classList.toggle('text-brand-forest', !open);

                answer.classList.toggle('text-white/85', open);
                answer.classList.toggle('text-stone-500', !open);
            }

            items.forEach((item) => {
                const btn = item.querySelector('.faq-question');
                btn.addEventListener('click', () => {
                    const isOpen = btn.getAttribute('aria-expanded') === 'true';

                    items.forEach((other) => setOpen(other, false));

                    setOpen(item, !isOpen);
                });
            });
        })();
    </script>
@endif
