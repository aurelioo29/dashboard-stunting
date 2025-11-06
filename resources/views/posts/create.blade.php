<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard.posts.index') }}" class="hover:underline">← Kembali</a>
        </div>
    </x-slot> --}}

    <div class="max-w-7xl mx-auto p-6">
        @livewire('posts.form')
    </div>
</x-app-layout>
