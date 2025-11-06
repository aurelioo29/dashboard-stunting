<nav class="flex items-center gap-3">
    @auth
        <a href="{{ url('/dashboard') }}"
            class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">
            Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:text-primaryDark">
            Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primaryDark focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60">
                Sign up
            </a>
        @endif
    @endauth
</nav>
