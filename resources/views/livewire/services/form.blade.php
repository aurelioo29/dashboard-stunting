@php
    $maxTitle = 160;
@endphp

<div class="w-full bg-white shadow sm:rounded-lg" x-data="{
    titleCount: @entangle('title').length || 0
}"
    @scrolltop.window="window.scrollTo({ top: 0, behavior: 'smooth' })">

    <div class="border-b px-6 py-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold">
            {{ $editingId ? 'Edit Layanan' : 'Tambah Layanan' }}
        </h3>
        <div class="text-xs text-gray-500">
            {{ $editingId ? 'ID: ' . $editingId : 'New' }}
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid md:grid-cols-2 gap-4">

            {{-- Title --}}
            <div class="md:col-span-2">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium">Judul Layanan</label>
                    <span class="text-xs text-gray-500" x-text="titleCount + ' / {{ $maxTitle }}'"></span>
                </div>
                <input wire:model.live="title" @input="titleCount = $event.target.value.length"
                    maxlength="{{ $maxTitle }}" class="w-full rounded border px-3 py-2"
                    placeholder="Contoh: Konsultasi Gizi Ibu & Anak">
                @error('title')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Sort order --}}
            <div>
                <label class="block text-sm font-medium">Urutan Tampilan</label>
                <input type="number" wire:model="sort_order" class="w-full rounded border px-3 py-2" min="0"
                    step="1">
                <p class="text-xs text-gray-500 mt-1">
                    Angka lebih kecil tampil lebih dulu. Bisa diabaikan kalau belum perlu.
                </p>
                @error('sort_order')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-2 pt-6">
                <input id="active" type="checkbox" wire:model="is_active" class="cursor-pointer">
                <label for="active" class="text-sm font-medium cursor-pointer">Aktif?</label>
            </div>

            {{-- Icon --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Icon (PNG/SVG)</label>
                <input type="file" wire:model="icon_file" class="block">
                <p class="text-xs text-gray-500 mt-1">
                    Max 2MB. Disarankan ukuran square (mis. 256x256).
                </p>
                @error('icon_file')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror

                <div wire:loading wire:target="icon_file" class="text-xs text-gray-500 mt-1">
                    Uploading…
                </div>

                @if ($icon_file)
                    <div class="mt-3">
                        <div class="text-xs text-gray-500 mb-1">Preview</div>
                        {{-- Untuk PNG bisa tampil. SVG kadang tidak di-embed, tapi gak apa-apa --}}
                        <img src="{{ $icon_file->temporaryUrl() }}"
                            class="h-20 w-20 rounded border object-contain bg-gray-50">
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div class="border-t px-6 py-4 flex items-center justify-end gap-2">
        <button wire:click="resetForm" type="button" class="rounded border px-4 py-2">
            Reset
        </button>
        <button wire:click="save" class="rounded bg-black px-4 py-2 text-white">
            {{ $editingId ? 'Update' : 'Create' }}
        </button>
    </div>
</div>
