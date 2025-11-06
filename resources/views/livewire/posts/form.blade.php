@php
    $maxTitle = 160;
    $maxExcerpt = 200;
@endphp

<div class="w-full bg-white shadow sm:rounded-lg" x-data="{
    pub: @entangle('is_published'),
    titleCount: @entangle('title').length || 0,
    excCount: @entangle('excerpt').length || 0
}"
    @scrolltop.window="window.scrollTo({top:0,behavior:'smooth'})">

    <div class="border-b px-6 py-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold">
            {{ $editingId ? 'Edit Post' : 'Create Post' }}
        </h3>
        <div class="text-xs text-gray-500">
            {{ $editingId ? 'ID: ' . $editingId : 'New' }}
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid md:grid-cols-2 gap-4">

            {{-- Tipe --}}
            <div>
                <label class="block text-sm font-medium">Tipe</label>
                <select wire:model="type" class="w-full rounded border px-3 py-2">
                    <option value="news">News</option>
                    <option value="tips">Tips (Stunting)</option>
                </select>
                @error('type')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Judul --}}
            <div>
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium">Judul</label>
                    <span class="text-xs text-gray-500" x-text="titleCount + ' / {{ $maxTitle }}'"></span>
                </div>
                <input wire:model.live="title" @input="titleCount = $event.target.value.length"
                    maxlength="{{ $maxTitle }}" class="w-full rounded border px-3 py-2" placeholder="Judul post">
                @error('title')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div class="md:col-span-2">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium">Excerpt</label>
                    <span class="text-xs text-gray-500" x-text="excCount + ' / {{ $maxExcerpt }}'"></span>
                </div>
                <textarea wire:model.live="excerpt" @input="excCount = $event.target.value.length" maxlength="{{ $maxExcerpt }}"
                    rows="2" class="w-full rounded border px-3 py-2"
                    placeholder="Ringkasan singkat untuk card/list/SEO (tanpa HTML)"></textarea>
                @error('excerpt')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konten --}}
            <div class="md:col-span-2">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium">Konten</label>
                    <span class="text-xs text-gray-500">Bisa HTML/Markdown</span>
                </div>
                <textarea wire:model="content" rows="8" class="w-full rounded border px-3 py-2 font-mono"
                    placeholder="Tulis konten di sini..."></textarea>
                @error('content')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jadwal publish --}}
            <div>
                <label class="block text-sm font-medium">Publish At (opsional)</label>

                <!-- Disable kalau pub = true (checkbox dicentang) -->
                <input type="datetime-local" wire:model.live="published_at" :disabled="pub"
                    class="w-full rounded border px-3 py-2 disabled:bg-gray-100 disabled:text-gray-500">

                <p class="text-xs text-gray-500 italic pt-3">
                    NOTE: Centang <b>Published</b> untuk publish sekarang, atau atur waktu jika ingin terjadwal.
                </p>
                @error('published_at')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status publish --}}
            <div class="flex items-center gap-2 pt-6">
                <input id="pub" type="checkbox" x-model="pub" wire:model.live="is_published"
                    class="cursor-pointer">
                <label for="pub" class="text-sm font-medium cursor-pointer">Published</label>
            </div>

            <!-- Tambahkan x-effect agar saat Published dicentang, tanggal langsung dikosongkan -->
            <div x-effect="if (pub) { $wire.set('published_at', null) }"></div>

            {{-- Cover --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Cover (opsional)</label>
                <input type="file" wire:model="cover_image" class="block">
                @error('cover_image')
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
                <div wire:loading wire:target="cover_image" class="text-xs text-gray-500 mt-1">Uploading…</div>

                @if ($cover_image)
                    <div class="mt-3">
                        <div class="text-xs text-gray-500 mb-1">Preview</div>
                        <img src="{{ $cover_image->temporaryUrl() }}" class="h-36 rounded border object-cover">
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div class="border-t px-6 py-4 flex items-center justify-end gap-2">
        <button wire:click="resetForm" type="button" class="rounded border px-4 py-2">Reset</button>
        <button wire:click="save" class="rounded bg-black px-4 py-2 text-white">
            {{ $editingId ? 'Update' : 'Create' }}
        </button>
    </div>
</div>
