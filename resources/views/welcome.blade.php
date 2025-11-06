<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Stunting | Home</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans bg-white text-slate-800">
    <!-- NAVBAR -->
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- LEFT: Logo only -->
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="E-Stunting" class="h-8 w-auto sm:h-12">
                </a>

                <!-- RIGHT: Auth -->
                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </div>
        </div>
    </header>

    <!-- Page content -->
    <main>
        @include('partials.hero')
        @include('partials.why-stunting')
        @include('partials.stunting-stats')
        @include('partials.antisipate')
        @include('partials.home-news', ['posts' => $latestPosts])
        @include('partials.download')
        @include('partials.faq')
    </main>

    <!-- FOOTER -->
    @include('partials.footer')
</body>

</html>
