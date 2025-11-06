{{-- SECTION: Cara Mencegah (Intervensi Spesifik & Sensitif) --}}
<section class="py-16 sm:py-20">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:px-8">

        {{-- LEFT: Illustration (ganti dengan asset kamu) --}}
        <div class="relative">
            <img src="{{ asset('placeholder.jpg') }}" alt="Ilustrasi pencegahan stunting"
                class="w-full max-w-md mx-auto drop-shadow-sm" />
            {{-- fallback kalau belum ada file --}}
            {{-- <div class="aspect-[4/3] max-w-md mx-auto rounded-2xl bg-slate-100 ring-1 ring-slate-200" /> --}}
        </div>

        {{-- RIGHT: Copy + lists --}}
        <div>
            <h2 class="text-3xl font-bold leading-tight text-slate-800 sm:text-4xl">
                Cara Mencegah
                <span class="block text-[#56ced6]">Intervensi Spesifik &amp; Sensitif</span>
            </h2>

            <p class="mt-4 max-w-2xl text-slate-600">
                Fokusnya sederhana: gizi tepat + lingkungan sehat. Lakukan yang bisa dikendalikan hari ini,
                jangan nunggu “nanti” karena jendela 1000&nbsp;HPK nggak nunggu kita.
            </p>

            {{-- Cards: Spesifik & Sensitif --}}
            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                {{-- Spesifik (langsung ke gizi/medis) --}}
                <div class="rounded-2xl bg-white p-5 ring-1 ring-inset ring-slate-200 shadow-sm">
                    <div
                        class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-[#56ced6]/15 text-[#56ced6]">
                        {{-- icon pill --}}
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                            <path d="M4 12a6 6 0 0 1 6-6h0a6 6 0 0 1 0 12H10A6 6 0 0 1 4 12Zm8.5-4.5-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Intervensi Spesifik</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-slate-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            Asam folat &amp; zat besi untuk ibu hamil; tablet tambah darah untuk remaja putri.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            ASI eksklusif 6 bulan, lanjut ASI sampai 2 tahun.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            MP-ASI padat gizi mulai 6 bulan: protein hewani, lemak sehat, sayur, buah, fortifikasi bila
                            perlu.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            Imunisasi lengkap, vitamin A sesuai jadwal, tata laksana diare/ISPA.
                        </li>
                    </ul>
                </div>

                {{-- Sensitif (lingkungan & perilaku) --}}
                <div class="rounded-2xl bg-white p-5 ring-1 ring-inset ring-slate-200 shadow-sm">
                    <div
                        class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-[#56ced6]/15 text-[#56ced6]">
                        {{-- icon water/hand --}}
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C8 7 6 9.5 6 13a6 6 0 1 0 12 0c0-3.5-2-6-6-11Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Intervensi Sensitif</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-slate-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            Akses air bersih, jamban layak, cuci tangan pakai sabun.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            Edukasi pola asuh responsif &amp; stimulasi dini (bicara, bermain, membaca).
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 flex-none rounded-full bg-[#56ced6]"></span>
                            Ketahanan pangan keluarga &amp; dukungan sosial (Posyandu aktif, PKK, sekolah).
                        </li>
                    </ul>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-8">
                <a href="{{ url('/pencegahan-stunting') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#56ced6] px-5 py-3 text-sm font-semibold text-slate-900 hover:brightness-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#56ced6]/60">
                    Pelajari Pencegahannya
                    <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                        <path d="M13 5l7 7-7 7v-4H4v-6h9V5z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
