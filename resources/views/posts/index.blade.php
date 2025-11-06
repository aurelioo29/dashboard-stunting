<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Posts (News & Tips Stunting)</h2>
            <a href="{{ route('dashboard.posts.create') }}"
                class="inline-flex items-center rounded bg-black px-3 py-2 text-white">
                Create Postingan
            </a>
        </div>
    </x-slot> --}}

    <div class="max-w-7xl mx-auto p-6">
        @livewire('posts.table')
    </div>
</x-app-layout>
