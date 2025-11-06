@php
    /** @var \App\Models\Post $post */
    $post = \App\Models\Post::findOrFail(request()->route('post'));
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Edit</h2>
            <a href="{{ route('dashboard.posts.index') }}" class="hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        @livewire('posts.form', ['editingId' => $post->id]) {{-- mode edit --}}
    </div>
</x-app-layout>
