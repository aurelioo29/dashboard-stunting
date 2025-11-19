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

    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap items-center gap-2">
            <select wire:model.live="filterStatus" class="rounded border px-3 py-2 pe-9">
                <option value="">All Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>

        <div class="flex items-center gap-2 md:min-w-[520px] md:justify-end">
            <div class="relative w-full max-w-[320px]">
                <input wire:model.live.debounce.300ms="filterSearch" class="w-full rounded border ps-3 pe-8 py-2"
                    placeholder="Cari judul layanan" autocomplete="off" />
                @if ($filterSearch !== '')
                    <button type="button" wire:click="$set('filterSearch','')"
                        class="absolute inset-y-0 right-2 my-auto h-6 w-6 rounded-full text-gray-500 hover:bg-gray-100"
                        title="Clear">✕</button>
                @endif
            </div>

            <a href="{{ route('dashboard.services.create') }}"
                class="inline-flex items-center gap-2 rounded bg-black px-3 py-2 text-white hover:opacity-90">
                <span>Tambah Layanan</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="w-16 py-2">Icon</th>
                    <th>Judul</th>
                    <th class="w-28">Status</th>
                    <th class="w-24 text-center">Urutan</th>
                    <th class="w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $row)
                    <tr class="border-b">
                        <td class="py-2">
                            <img src="{{ $row->icon_url }}" class="h-10 w-10 rounded border object-contain bg-gray-50"
                                alt="{{ $row->title }}">
                        </td>
                        <td class="max-w-[28rem]">
                            <span class="block truncate" title="{{ $row->title }}">
                                {{ \Illuminate\Support\Str::limit($row->title, 60) }}
                            </span>
                        </td>
                        <td>
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $row->is_active ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{ $row->sort_order }}
                        </td>
                        <td>
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('dashboard.services.edit', $row->id) }}"
                                    class="{{ $iconBtn }} text-sky-600 hover:bg-sky-50 focus:ring-sky-300"
                                    title="Edit">
                                    ✏️
                                </a>

                                <button type="button"
                                    x-on:click="if(confirm('Hapus layanan ini?')) $wire.delete({{ $row->id }})"
                                    class="{{ $iconBtn }} text-red-600 hover:bg-red-50 focus:ring-red-300"
                                    title="Delete">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">
                            Belum ada layanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-xs text-gray-500">
                Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of
                {{ $services->total() }} results
            </div>
            <div class="flex justify-end">
                {{ $services->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
