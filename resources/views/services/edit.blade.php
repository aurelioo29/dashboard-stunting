@php
    /** @var \App\Models\Service $service */
    $service = \App\Models\Service::findOrFail(request()->route('service'));
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Edit Layanan</h2>
            <a href="{{ route('dashboard.services.index') }}" class="hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        @livewire('services.form', ['editingId' => $service->id])
    </div>
</x-app-layout>
