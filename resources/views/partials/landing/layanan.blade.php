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


        {{-- =====================================================
             SERVICE CARD
             Kartu layanan: gambar lebih tinggi + rounded lebih
             besar + border tipis + garis emas kecil di bawah
             judul, supaya card terasa lebih "berisi" dan premium.

             Ubah jumlah kolom: ganti "md:grid-cols-3".
             Ubah jarak antar kartu: ganti "gap-8".
             Ubah tinggi gambar: ganti "h-64" -> "h-72" di kelas img.
             Ubah radius sudut: ganti "rounded-2xl".
             Ubah bayangan: ganti "shadow-sm" / "hover:shadow-xl".
        ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @forelse($services as $index => $service)

                @php
                    $imageUrl = $service->image
                        ? Storage::url($service->image)
                        : $defaultServiceImages[$index % count($defaultServiceImages)];
                @endphp

                <article
                    class="reveal group bg-gradient-to-br from-white via-brand-cream to-brand-gold/15 rounded-2xl border border-brand-forest/10 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5"
                    @if($index > 0)
                        style="transition-delay: {{ min($index * 100, 500) }}ms"
                    @endif
                >

                    <div class="overflow-hidden">

                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $service->title }}"
                            loading="lazy"
                            class="h-56 sm:h-64 lg:h-72 w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            onerror="this.src='{{ $defaultServiceImages[0] }}'"
                        >

                    </div>

                    <div class="p-6">

                        <h3 class="title-underline font-serif font-bold text-xl text-brand-forest mb-2">
                            {{ $service->title }}
                        </h3>

                        <div class="w-10 h-[2px] bg-brand-gold mb-3"></div>

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
