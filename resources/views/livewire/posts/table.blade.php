@php
    $iconBtn =
        'inline-flex items-center justify-center rounded-md p-2 transition focus:outline-none focus:ring-2 focus:ring-offset-2';
@endphp


<div class="w-full space-y-4 bg-white shadow sm:rounded-lg p-6">
    @if (session('success'))
        <div class="rounded border border-emerald-300 bg-emerald-50 text-emerald-800 px-3 py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- TOOLBAR --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        {{-- Left: Filters --}}
        <div class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <select wire:model.live="filterType" class="rounded border px-3 py-2 pe-9">
                    <option value="">All Types</option>
                    <option value="news">News</option>
                    <option value="tips">Tips</option>
                </select>

            </div>

            <div class="relative">
                <select wire:model.live="filterStatus" class="rounded border px-3 py-2 pe-9">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>

        {{-- Right: Search + Add --}}
        <div class="flex items-center gap-2 md:min-w-[520px] md:justify-end">
            {{-- Search box with icon + clear + live results --}}
            <div x-data="{ open: false }" class="relative w-full max-w-[320px]">
                <input wire:model.live.debounce.300ms="filterSearch" x-on:focus="open = true"
                    x-on:click.outside="open = false" x-on:keydown.escape.window="open=false"
                    class="w-full rounded border ps-9 pe-8 py-2" placeholder="Cari judul/excerpt" autocomplete="off" />

                {{-- search icon --}}
                <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-gray-400">
                    🔎
                </span>

                {{-- clear button --}}
                @if ($filterSearch !== '')
                    <button type="button" wire:click="$set('filterSearch','')"
                        class="absolute inset-y-0 right-2 my-auto h-6 w-6 rounded-full text-gray-500 hover:bg-gray-100"
                        title="Clear">✕</button>
                @endif

                {{-- live suggestions --}}
                @if ($filterSearch !== '' && $this->suggestions->isNotEmpty())
                    <div x-show="open"
                        class="absolute z-10 mt-1 w-full overflow-hidden rounded-md border bg-white shadow-lg">
                        @foreach ($this->suggestions as $s)
                            <a href="{{ route('dashboard.posts.edit', $s->id) }}"
                                class="flex items-start gap-2 px-3 py-2 hover:bg-gray-50">
                                <span
                                    class="mt-0.5 text-xs uppercase tracking-wide text-gray-500">{{ $s->type }}</span>
                                <span class="line-clamp-2">{{ $s->title }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Add Posting --}}
            <a href="{{ route('dashboard.posts.create') }}"
                class="inline-flex items-center gap-2 rounded bg-black px-3 py-2 text-white hover:opacity-90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor">
                    <path
                        d="M25 4.03c-.765 0-1.517.3-2.094.876L13 14.78l-.22.22l-.06.313l-.69 3.5l-.31 1.468l1.467-.31l3.5-.69l.313-.06l.22-.22l9.874-9.906A2.968 2.968 0 0 0 25 4.032zm0 1.94c.235 0 .464.12.688.343c.446.446.446.928 0 1.375L16 17.374l-1.72.344l.345-1.72l9.688-9.688c.223-.223.452-.343.687-.343zM4 8v20h20V14.812l-2 2V26H6V10h9.188l2-2H4z" />
                </svg>
                <span>Add Posting</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2 w-28">Tipe</th>
                    <th class="w-auto">Judul</th>
                    <th class="w-36">Status</th>
                    <th class="w-52">Published At</th>
                    <th class="w-48">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($posts as $row)
                    @php
                        // Tentukan kelas badge
                        $badge = match ($row->status) {
                            'published' => 'bg-emerald-600 text-white',
                            'scheduled' => 'bg-amber-500 text-white',
                            default => 'bg-gray-200 text-gray-700',
                        };
                    @endphp

                    <tr class="border-b">
                        <td class="py-2 capitalize">{{ $row->type }}</td>

                        {{-- Judul dipotong; full title muncul di tooltip --}}
                        <td class="max-w-[28rem]">
                            <span class="block truncate" title="{{ $row->title }}">
                                {{ \Illuminate\Support\Str::limit($row->title, 60) }}
                            </span>
                        </td>

                        {{-- Status badge --}}
                        <td>
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>

                        <td class="text-gray-700">
                            {{ $row->published_at_local?->format('d M Y H:i') }}
                        </td>

                        {{-- Aksi pakai ikon kamu + warna --}}
                        <td class="">
                            <div class="inline-flex items-center gap-1">

                                {{-- EDIT (biru) --}}
                                <a href="{{ route('dashboard.posts.edit', $row->id) }}"
                                    class="{{ $iconBtn }} text-sky-600 hover:bg-sky-50 focus:ring-sky-300"
                                    title="Edit">
                                    <span class="sr-only">Edit</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 26 26"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M20.094.25a2.245 2.245 0 0 0-1.625.656l-1 1.031l6.593 6.625l1-1.03a2.319 2.319 0 0 0 0-3.282L21.75.937A2.36 2.36 0 0 0 20.094.25zm-3.75 2.594l-1.563 1.5l6.875 6.875L23.25 9.75l-6.906-6.906zM13.78 5.438L2.97 16.155a.975.975 0 0 0-.5.625L.156 24.625a.975.975 0 0 0 1.219 1.219l7.844-2.313a.975.975 0 0 0 .781-.656l10.656-10.563l-1.468-1.468L8.25 21.813l-4.406 1.28l-.938-.937l1.344-4.593L15.094 6.75L13.78 5.437zm2.375 2.406l-10.968 11l1.593.343l.219 1.47l11-10.97l-1.844-1.843z" />
                                    </svg>
                                </a>

                                {{-- DELETE (merah) --}}
                                <button type="button"
                                    x-on:click="if(confirm('Hapus post ini?')) $wire.delete({{ $row->id }})"
                                    class="{{ $iconBtn }} text-red-600 hover:bg-red-50 focus:ring-red-300"
                                    title="Delete">
                                    <span class="sr-only">Delete</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="m9.129 0l1.974.005c.778.094 1.46.46 2.022 1.078c.459.504.7 1.09.714 1.728h5.475a.69.69 0 0 1 .686.693a.689.689 0 0 1-.686.692l-1.836-.001v11.627c0 2.543-.949 4.178-3.041 4.178H5.419c-2.092 0-3.026-1.626-3.026-4.178V4.195H.686A.689.689 0 0 1 0 3.505c0-.383.307-.692.686-.692h5.47c.014-.514.205-1.035.554-1.55C7.23.495 8.042.074 9.129 0Zm6.977 4.195H3.764v11.627c0 1.888.52 2.794 1.655 2.794h9.018c1.139 0 1.67-.914 1.67-2.794l-.001-11.627ZM6.716 6.34c.378 0 .685.31.685.692v8.05a.689.689 0 0 1-.686.692a.689.689 0 0 1-.685-.692v-8.05c0-.382.307-.692.685-.692Zm2.726 0c.38 0 .686.31.686.692v8.05a.689.689 0 0 1-.686.692a.689.689 0 0 1-.685-.692v-8.05c0-.382.307-.692.685-.692Zm2.728 0c.378 0 .685.31.685.692v8.05a.689.689 0 0 1-.685.692a.689.689 0 0 1-.686-.692v-8.05a.69.69 0 0 1 .686-.692ZM9.176 1.382c-.642.045-1.065.264-1.334.662c-.198.291-.297.543-.313.768l4.938-.001c-.014-.291-.129-.547-.352-.792c-.346-.38-.73-.586-1.093-.635l-1.846-.002Z" />
                                    </svg>
                                </button>

                                @if ($row->status === 'draft')
                                    {{-- PUBLISH (hijau) --}}
                                    <button type="button" wire:click="publishNow({{ $row->id }})"
                                        class="{{ $iconBtn }} text-emerald-600 hover:bg-emerald-50 focus:ring-emerald-300"
                                        title="Publish">
                                        <span class="sr-only">Publish</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M11 20v-8.15l-2.6 2.6L7 13l5-5l5 5l-1.4 1.45l-2.6-2.6V20h-2ZM4 9V6q0-.825.588-1.413T6 4h12q.825 0 1.413.588T20 6v3h-2V6H6v3H4Z" />
                                        </svg>
                                    </button>
                                @else
                                    {{-- UNPUBLISH (oranye) --}}
                                    <button type="button" wire:click="unpublish({{ $row->id }})"
                                        class="{{ $iconBtn }} text-amber-600 hover:bg-amber-50 focus:ring-amber-300"
                                        title="Unpublish">
                                        <span class="sr-only">Unpublish</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 2048 2048"
                                            fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M768 347L365 749l-90-90l557-557l557 557l-90 90l-403-402v1317H768V347zm1280 1253q0 93-35 174t-96 143t-142 96t-175 35q-93 0-174-35t-143-96t-96-142t-35-175q0-93 35-174t96-143t142-96t175-35q93 0 174 35t143 96t96 142t35 175zm-272 267l-443-443q-26 39-39 84t-14 92q0 67 25 125t68 101t102 69t125 25q47 0 92-13t84-40zm144-267q0-66-25-124t-69-101t-102-69t-124-26q-47 0-92 13t-84 40l443 443q26-39 39-84t14-92zm-835 320q22 37 48 69t59 59H0v-384h128v256h957z" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- SCHEDULE (ungu) --}}
                                <button type="button"
                                    x-on:click="const dt = prompt('Schedule datetime (YYYY-MM-DDTHH:MM)'); if (dt) $wire.schedule({{ $row->id }}, dt)"
                                    class="{{ $iconBtn }} text-violet-600 hover:bg-violet-50 focus:ring-violet-300"
                                    title="Schedule">
                                    <span class="sr-only">Schedule</span>
                                    {{-- boleh tetap pakai ikon lama atau ganti; ini biarkan yang lama --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7.1a6.5 6.5 0 1 0 6.9-10.4V6a2 2 0 0 0-2-2zm0 14H5V9h14v1.1A6.5 6.5 0 0 0 12.1 18H19zM18.5 22a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm.5-3h-3v-2h2v-2h1v4z" />
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-xs text-gray-500">
                Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }}
                results
            </div>

            <div class="flex justify-end">
                {{-- onEachSide(1) biar pager nggak kepanjangan --}}
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    {{-- <div class="mt-4">{{ $posts->links() }}</div> --}}
</div>
