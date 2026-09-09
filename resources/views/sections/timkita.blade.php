{{-- =========================
    OUR TEAM
========================= --}}

<section
    id="our-team"
    class="team-section relative overflow-hidden bg-[#f9f8f6] py-24 lg:py-32"
>
    <div class="mx-auto max-w-6xl px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="reveal mb-16 max-w-2xl mx-auto text-center">
            <div class="mb-5 flex items-center justify-center gap-4">
                <span class="h-px w-10 bg-[#c5a880]"></span>
                <span class="text-xs font-medium uppercase tracking-[0.25em] text-[#c5a880]">
                    Our Team
                </span>
                <span class="h-px w-10 bg-[#c5a880]"></span>
            </div>

            <h2 class="font-serif text-4xl leading-tight text-[#2c3e35] sm:text-5xl">
                Meet Our Team
            </h2>

            <p class="mt-5 mx-auto max-w-xl text-sm leading-7 text-[#6d756f]">
                Tim profesional BumiYuji Living yang berdedikasi menghadirkan
                desain interior dan arsitektur yang elegan, fungsional,
                dan sesuai dengan kebutuhan setiap klien.
            </p>
        </div>

        {{-- Team Grid --}}
        @if ($team->isNotEmpty())

            <div class="grid grid-cols-1 gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($team as $index => $member)

                    <div class="team-card reveal group flex flex-col items-center text-center" style="transition-delay: {{ min($index * 90, 360) }}ms">

                        {{-- Circular Photo --}}
                        <div class="team-image relative mb-6 h-40 w-40 sm:h-44 sm:w-44">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-[#c5a880]/40 to-transparent opacity-0 blur-md transition-opacity duration-500 group-hover:opacity-100"></div>

                            <div class="relative aspect-square h-full w-full overflow-hidden rounded-full border-4 border-white shadow-md ring-1 ring-[#e4ddce] transition-all duration-500 ease-out group-hover:-translate-y-1.5 group-hover:shadow-xl">
                                @if ($member->image_path)
                                    <img
                                        src="{{ Storage::url($member->image_path) }}"
                                        alt="{{ $member->name }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover object-center transition-transform duration-500 ease-out group-hover:scale-[1.06]"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-[#eee9df]">
                                        <span class="font-serif text-2xl text-[#a89f8d]">
                                            {{ collect(explode(' ', $member->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Name --}}
                        <h3 class="team-content font-serif text-xl text-[#2c3e35]">
                            {{ $member->name }}
                        </h3>

                        {{-- Role --}}
                        @if ($member->position)
                            <span class="mt-1.5 block text-xs font-medium uppercase tracking-[0.18em] text-[#9a9488]">
                                {{ $member->position }}
                            </span>
                        @endif

                        {{-- Social --}}
                        @if ($member->instagram || $member->linkedin)
                            <div class="team-social mt-4 flex translate-y-2 gap-3 opacity-0 transition-all duration-500 ease-out group-hover:translate-y-0 group-hover:opacity-100">

                                @if ($member->instagram)
                                    <a
                                        href="{{ $member->instagram }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Instagram {{ $member->name }}"
                                        class="flex h-9 w-9 items-center justify-center rounded-full border border-[#dedbd4] text-[#6d756f] transition-colors duration-300 hover:border-[#c5a880] hover:bg-[#c5a880] hover:text-white"
                                    >
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    </a>
                                @endif

                                @if ($member->linkedin)
                                    <a
                                        href="{{ $member->linkedin }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="LinkedIn {{ $member->name }}"
                                        class="flex h-9 w-9 items-center justify-center rounded-full border border-[#dedbd4] text-[#6d756f] transition-colors duration-300 hover:border-[#c5a880] hover:bg-[#c5a880] hover:text-white"
                                    >
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 11.001-4.124 2.062 2.062 0 010 4.124zM7.114 20.452H3.558V9h3.556v11.452z"/></svg>
                                    </a>
                                @endif

                            </div>
                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="border border-[#dedbd4] bg-white px-6 py-12 text-center">
                <p class="text-sm text-[#6d756f]">
                    Data anggota tim belum tersedia.
                </p>
            </div>

        @endif

    </div>
</section>
