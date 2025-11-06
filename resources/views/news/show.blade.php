<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $post->title }} | E-Stunting</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Open Graph (biar cakep kalau dishare) --}}
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ $post->cover_url }}">
    <meta property="og:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}">
</head>

<body class="font-sans bg-white text-slate-800">

    {{-- Navbar kamu di-include kalau mau --}}
    @includeIf('partials.navbar')

    <main class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('welcome') }}" class="text-sm text-slate-500 hover:text-slate-700">← Back</a>

            <h1 class="mt-3 text-3xl text-center font-bold tracking-tight text-slate-900">{{ $post->title }}</h1>
            <p class="mt-3 text-sm text-slate-500 text-center">
                {{ optional($post->published_at)->timezone(config('app.timezone'))->format('d M Y, H:i') }}
            </p>

            @if ($post->cover_url)
                <img src="{{ $post->cover_url }}" alt="{{ $post->title }}"
                    class="mt-6 w-3/4 mx-auto rounded-2xl object-cover">
            @endif

            <article class="prose prose-slate max-w-none mt-8">
                {!! $post->content !!}
            </article>

            {{-- Baca juga --}}
            @if ($related->isNotEmpty())
                <section class="mt-12 border-t pt-8">
                    <h2 class="text-lg font-semibold">Baca juga</h2>
                    <div class="mt-4 grid gap-5 sm:grid-cols-3">
                        @foreach ($related as $r)
                            <a href="{{ route('news.show', $r->slug ?? $r->id) }}"
                                class="group overflow-hidden rounded-2xl ring-1 ring-slate-200 hover:shadow-md transition">
                                <img src="{{ $r->cover_url }}" alt="{{ $r->title }}"
                                    class="h-40 w-full object-cover">
                                <div class="p-4">
                                    <h3 class="line-clamp-2 font-medium text-slate-900 group-hover:underline">
                                        {{ $r->title }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </main>

    {{-- Footer kamu --}}
    @includeIf('partials.footer')

</body>

</html>
