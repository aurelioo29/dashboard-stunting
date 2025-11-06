{{-- SECTION: Angka Kunci Stunting --}}
<section class="bg-slate-50 py-14 sm:py-20">
    <div class="mx-auto grid max-w-7xl items-start gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">

        {{-- LEFT: headline --}}
        <div>
            <h2 class="text-3xl font-bold leading-tight text-slate-800 sm:text-4xl">
                Mempercepat penurunan
                <span class="block text-[#56ced6]">stunting secara terukur</span>
            </h2>
            <p class="mt-3 max-w-xl text-slate-600">
                Ringkasan indikator utama yang kami pantau: prevalensi, estimasi balita terdampak,
                jangkauan intervensi gizi, dan layanan kesehatan ibu/anak. Angka di bawah dapat
                dipetakan per kab/kota maupun provinsi.
            </p>
        </div>

        {{-- RIGHT: metric tiles --}}
        <div class="grid w-full grid-cols-1 gap-6 sm:grid-cols-2">
            @php
                $fallback = [
                    [
                        'icon' => 'users',
                        'label' => 'Prevalensi Nasional',
                        'value' => 218,
                        'suffix' => '‰',
                        'help' => 'per 1000 balita (contoh)',
                    ],
                    [
                        'icon' => 'child',
                        'label' => 'Estimasi Balita Stunting',
                        'value' => 1490000,
                        'suffix' => '',
                        'help' => 'nasional (contoh)',
                    ],
                    [
                        'icon' => 'drop',
                        'label' => 'Jangkauan Intervensi Gizi',
                        'value' => 72,
                        'suffix' => '%',
                        'help' => 'PMT, vitamin, dsb.',
                    ],
                    [
                        'icon' => 'hospital',
                        'label' => 'Kunjungan ANC/PNC',
                        'value' => 64,
                        'suffix' => '%',
                        'help' => 'ibu hamil & nifas',
                    ],
                ];
                $data = isset($stats) && is_iterable($stats) && count($stats) ? $stats : $fallback;
            @endphp

            @foreach ($data as $i => $s)
                <div class="flex items-start gap-4 rounded-2xl bg-white p-5 ring-1 ring-inset ring-slate-200 shadow-sm">
                    {{-- icon --}}
                    <div
                        class="mt-1 inline-flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-[#56ced6]/15 text-[#56ced6]">
                        @switch($s['icon'] ?? '')
                            @case('users')
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                                    <path
                                        d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 2a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 3v1h8v-1c0-1.66-2.67-3-6-3Zm8-2c-2.67 0-5.33 1.34-6 3v1h12v-1c-.67-1.66-3.33-3-6-3Z" />
                                </svg>
                            @break

                            @case('child')
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                                    <path d="M12 3a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM6 22v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2H6Z" />
                                </svg>
                            @break

                            @case('drop')
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                                    <path d="M12 2C8 7 6 9.5 6 13a6 6 0 1 0 12 0c0-3.5-2-6-6-11Z" />
                                </svg>
                            @break

                            @case('hospital')
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                                    <path
                                        d="M3 21V7a2 2 0 0 1 2-2h4V3h6v2h4a2 2 0 0 1 2 2v14h-6v-4H9v4H3Zm8-10h2V9h2V7h-2V5h-2v2H9v2h2v2Z" />
                                </svg>
                            @break

                            @default
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                                    <path d="M11 2h2v20h-2z" />
                                </svg>
                        @endswitch
                    </div>

                    {{-- numbers --}}
                    <div>
                        <div class="text-2xl font-bold text-slate-800">
                            <span class="counter"
                                data-target="{{ (int) ($s['value'] ?? 0) }}">{{ number_format((int) ($s['value'] ?? 0)) }}</span>
                            <span>{{ $s['suffix'] ?? '' }}</span>
                        </div>
                        <div class="text-sm font-medium text-slate-800">{{ $s['label'] ?? '-' }}</div>
                        @if (!empty($s['help']))
                            <div class="text-xs text-slate-500">{{ $s['help'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
