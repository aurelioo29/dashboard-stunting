<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                Cerita dan Wawasan Seputar Stunting
            </h2>
            <p class="mt-3 text-slate-600">
                Temukan berita, riset, dan kisah nyata di balik upaya mencegah stunting di Indonesia.
            </p>Stunting blog with fresh stories & insights.
            </p>
        </div>

        {{-- Controls (kanan) --}}
        <div class="mt-8 flex items-center justify-end gap-3">
            <button type="button"
                class="news-prev inline-flex h-9 w-9 items-center justify-center rounded-full ring-1 ring-slate-300 hover:bg-slate-50">
                ‹
            </button>
            <button type="button"
                class="news-next inline-flex h-9 w-9 items-center justify-center rounded-full ring-1 ring-slate-300 hover:bg-slate-50">
                ›
            </button>
        </div>

        {{-- Swiper --}}
        <div class="news-swiper swiper mt-6">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    <div class="swiper-slide">
                        <article class="h-full">
                            <div
                                class="h-[340px] md:h-[360px] lg:h-[380px] flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-200 transition hover:shadow-md">
                                {{-- Image: fixed aspect so always same height --}}
                                <a href="{{ route('news.show', $post->slug ?? $post->id) }}" class="block">
                                    <div class="aspect-[16/9] w-full overflow-hidden rounded-t-2xl">
                                        <img src="{{ $post->cover_url }}" alt="{{ $post->title }}"
                                            class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
                                    </div>
                                </a>

                                <div class="flex flex-1 flex-col p-5">
                                    <h3 class="text-base font-semibold text-slate-900 line-clamp-2">
                                        <a href="{{ route('news.show', $post->slug ?? $post->id) }}"
                                            class="hover:underline">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <div class="mt-auto pt-3">
                                        <a href="{{ route('news.show', $post->slug ?? $post->id) }}"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-[#56ced6] hover:opacity-90">
                                            Read more
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"
                                                aria-hidden="true">
                                                <path d="M13 5l7 7-7 7v-4H4v-6h9V5z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="news-pagination mt-6"></div>
        </div>
    </div>
</section>
