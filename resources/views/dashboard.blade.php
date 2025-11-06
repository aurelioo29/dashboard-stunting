<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ==== STAT CARDS ==== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $stats = [
                        ['label' => 'Total Posts', 'value' => $cards['total'], 'class' => 'bg-slate-50'],
                        ['label' => 'Published', 'value' => $cards['published'], 'class' => 'bg-emerald-50'],
                        ['label' => 'Scheduled', 'value' => $cards['scheduled'], 'class' => 'bg-amber-50'],
                        ['label' => 'Drafts', 'value' => $cards['drafts'], 'class' => 'bg-slate-50'],
                    ];
                @endphp
                @foreach ($stats as $s)
                    <div class="rounded-2xl p-4 border {{ $s['class'] }}">
                        <div class="text-xs uppercase tracking-wide text-gray-500">{{ $s['label'] }}</div>
                        <div class="mt-2 text-3xl font-bold">{{ number_format($s['value']) }}</div>
                    </div>
                @endforeach
            </div>

            {{-- ==== CHARTS ==== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Line: Published per Day --}}
                <div class="lg:col-span-2 rounded-2xl border bg-white p-4">
                    <div class="mb-3 font-semibold">Posts Published (14 days)</div>
                    <canvas id="chartLine" data-labels='@json($dayLabels)'
                        data-values='@json($dayValues)' height="90"></canvas>
                </div>

                {{-- Donut: Type Composition --}}
                <div class="rounded-2xl border bg-white p-4">
                    <div class="mb-3 font-semibold">Composition by Type</div>
                    <canvas id="chartDonut" data-labels='@json($typeLabels)'
                        data-values='@json($typeValues)' height="90"></canvas>
                </div>
            </div>

            {{-- ==== TOP POSTS ==== --}}
            <div class="rounded-2xl border bg-white">
                <div class="px-4 py-3 border-b font-semibold">Top Posts</div>
                <div class="p-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">Title</th>
                                <th class="w-32 text-right">Views</th>
                                <th class="w-24"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topPosts as $p)
                                <tr class="border-b">
                                    <td class="py-2">
                                        <span class="block max-w-3xl truncate" title="{{ $p->title }}">
                                            {{ $p->title }}
                                        </span>
                                    </td>
                                    <td class="text-right">{{ number_format($p->view_count) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('dashboard.posts.edit', $p->id) }}"
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded border hover:bg-slate-50">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
