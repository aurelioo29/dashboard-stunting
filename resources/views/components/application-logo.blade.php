@props(['class' => 'h-20 w-20'])

<img src="{{ asset('logo.svg') }}" {{-- atau png --}} alt="{{ config('app.name', 'App') }} logo"
    class="{{ $class }}" />
