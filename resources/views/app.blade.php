<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-900">{{ config('app.name') }}</a>
                </div>

                <div class="flex items-center">
                    <!-- Dark mode toggle -->
                    <button id="dark-toggle" aria-label="Toggle dark mode" class="mr-4 inline-flex items-center justify-center w-10 h-10 rounded-md border border-transparent bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <svg id="icon-light" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-9h-1M4.34 12h-1M18.36 5.64l-.7.7M6.34 17.66l-.7.7M18.36 18.36l-.7-.7M6.34 6.34l-.7-.7"/>
                        </svg>
                        <svg id="icon-dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    <a href="{{ url('/admin') }}" class="mr-4 text-sm text-gray-700 hover:text-gray-900">Admin</a>

                    @guest
                        {{-- <a href="{{ filament()->getLoginUrl() }}" class="mr-4 text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Login</a> --}}
                        <button type="button" class="text-heading bg-yellow-500 box-border border border-transparent hover:bg-yellow-600 cursor-pointer focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Login</button>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="mr-4 text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Register</a>
                        @endif
                    @else
                        <span class="mr-4 text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ url('/admin/logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>



    

    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')

            <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
        </div>
    </main>

    <script>
    // Theme toggle: apply initial state and handle toggle
    (function () {
        const root = document.documentElement;
        const toggle = document.getElementById('dark-toggle');
        const iconLight = document.getElementById('icon-light');
        const iconDark = document.getElementById('icon-dark');

        function systemPrefersDark() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        function hasExplicitPreference() {
            return 'theme' in localStorage;
        }

        function isDark() {
            if (hasExplicitPreference()) {
                return localStorage.theme === 'dark';
            }
            return systemPrefersDark();
        }

        function apply(dark) {
            root.classList.toggle('dark', dark);
            if (iconLight && iconDark) {
                iconLight.classList.toggle('hidden', dark);
                iconDark.classList.toggle('hidden', !dark);
            }
        }

        apply(isDark());

        if (!toggle) return;

        toggle.addEventListener('click', function () {
            const newDark = !root.classList.contains('dark');
            apply(newDark);
            localStorage.theme = newDark ? 'dark' : 'light';
        });

        toggle.addEventListener('dblclick', function () {
            localStorage.removeItem('theme');
            apply(isDark());
        });
    })();
    </script>

    @stack('scripts')
</body>
</html>
