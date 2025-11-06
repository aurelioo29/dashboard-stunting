{{-- HERO: Stunting --}}
<section class="relative overflow-hidden bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 py-14 md:grid-cols-2 md:py-20">

            {{-- Left: copy + CTA --}}
            <div>
                <h1 class="text-3xl font-bold leading-tight text-slate-800 sm:text-4xl lg:text-5xl">
                    Pelajaran & Wawasan
                    <span class="block text-[#56ced6]">Tentang Stunting</span>
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-6 text-slate-600 sm:text-base">
                    Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis dan infeksi berulang,
                    ditandai tinggi badan anak lebih pendek dari standar usianya. Dampaknya bukan hanya soal tinggi—
                    otak, imunitas, dan masa depan ikut kena.
                </p>

                <div class="mt-6">
                    <a href="{{ route('news.show', $latestPosts->first()->slug ?? 'pelajari-stunting') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#56ced6] px-5 py-3 text-sm font-semibold text-slate-900 hover:brightness-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#56ced6]/60">
                        Pelajari Pencegahannya
                        <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                            <path d="M13 5l7 7-7 7v-4H4v-6h9V5z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Right: illustration --}}
            <div class="relative">
                {{-- ilustrasi SVG sederhana (bisa ganti ke asset sendiri) --}}
                <div class="relative mx-auto max-w-md">
                    <img src="{{ asset('placeholder.jpg') }}" alt="Ilustrasi pencegahan stunting"
                        class="w-full drop-shadow-md" />
                </div>
                {{-- dekor bayangan --}}
                <div
                    class="pointer-events-none absolute -bottom-6 left-1/2 h-24 w-2/3 -translate-x-1/2 rounded-full bg-slate-300/30 blur-2xl">
                </div>
            </div>

        </div>
    </div>
</section>
