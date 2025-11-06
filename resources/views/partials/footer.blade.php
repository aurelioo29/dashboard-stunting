    <footer class="bg-slate-900 text-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid gap-10 md:grid-cols-2">

                {{-- LEFT: Brand + copyright + socials --}}
                <div class="space-y-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="E-Stunting" class="h-12 w-auto">
                    </a>

                    <div class="text-sm text-slate-400 leading-relaxed">
                        <p>Copyright © {{ date('Y') }} E-Stunting Team.</p>
                        <p>All rights reserved</p>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Instagram --}}
                        <a href="#" aria-label="Instagram"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-800/70 hover:bg-slate-700 transition">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path
                                    d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 3.5a5.5 5.5 0 1 1 0 11.001 5.5 5.5 0 0 1 0-11zm0 2a3.5 3.5 0 1 0 .001 7.001A3.5 3.5 0 0 0 12 9.5zM17.5 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                        </a>
                        {{-- Dribbble --}}
                        <a href="#" aria-label="Dribbble"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-800/70 hover:bg-slate-700 transition">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path
                                    d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm6.93 8h-4.51a22.7 22.7 0 0 0-1.76-3.86A8 8 0 0 1 18.93 10zM12 4a8 8 0 0 1 4.64 1.5 24.4 24.4 0 0 1 2.1 4.06H16a24.9 24.9 0 0 0-2.07-4.19A7.9 7.9 0 0 0 12 4zm-2.38.44A23.6 23.6 0 0 1 12.7 8H5.07A8 8 0 0 1 9.62 4.44zM4.07 10H12c.3.58.58 1.18.83 1.81-3.1.91-6.02 2.84-7.77 5.59A7.97 7.97 0 0 1 4.07 10zm1.83 7.23c1.6-2.39 4.15-4.13 7.2-4.98.52 1.48.9 3.1 1.12 4.87A7.97 7.97 0 0 1 5.9 17.23zM14.8 17c-.2-1.56-.55-3.02-1.02-4.34 1.44-.28 3-.43 4.73-.43.47 0 .93.01 1.39.03a8 8 0 0 1-5.1 4.74z" />
                            </svg>
                        </a>
                        {{-- Twitter/X --}}
                        <a href="#" aria-label="Twitter"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-800/70 hover:bg-slate-700 transition">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path
                                    d="M18.244 2H21l-6.52 7.46L22 22h-6.91l-5.41-6.64L3.53 22H1l7.05-8.06L2 2h6.91l4.93 6.05L18.244 2Zm-2.42 18h1.33L8.3 4H6.97l8.855 16Z" />
                            </svg>
                        </a>
                        {{-- YouTube --}}
                        <a href="#" aria-label="YouTube"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-800/70 hover:bg-slate-700 transition">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                                <path
                                    d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.7 3.5 12 3.5 12 3.5s-7.7 0-9.4.6A3 3 0 0 0 .5 6.2 31.7 31.7 0 0 0 0 12a31.7 31.7 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.7.6 9.4.6 9.4.6s7.7 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.7 31.7 0 0 0 24 12a31.7 31.7 0 0 0-.5-5.8ZM9.75 15.02V8.98L15.5 12l-5.75 3.02Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Newsletter --}}
                <div class="md:pl-16">
                    <h3 class="text-lg font-semibold">Stay up to date</h3>
                    <form action="#" method="POST" class="mt-4">
                        @csrf
                        <div class="flex items-stretch gap-2">
                            <label for="newsletter-email" class="sr-only">Email address</label>
                            <input id="newsletter-email" name="email" type="email" required
                                placeholder="Your email address"
                                class="w-full rounded-xl bg-slate-800/70 px-4 py-3 text-sm text-slate-100 placeholder-slate-400 ring-1 ring-slate-700 focus:outline-none focus:ring-2 focus:ring-[#56ced6]">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 bg-[#56ced6] hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-[#56ced6]/60">
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                    <path d="M2 21 23 12 2 3v7l15 2-15 2v7z" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-slate-400">We respect your inbox. Unsubscribe anytime.</p>
                    </form>
                </div>
            </div>
        </div>
    </footer>
