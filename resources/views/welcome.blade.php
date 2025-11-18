
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: (localStorage.getItem('dark') === '1') }" x-bind:class="{ 'dark': dark }" x-init="$watch('dark', value => localStorage.setItem('dark', value ? '1' : '0'))">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Biblioteca') }}</title>
    <script>
        document.documentElement.classList.toggle(
            'dark',
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        );
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* pequeño ajuste para transición tema */
        html { transition: background-color .2s, color .2s; }
    </style>
</head>
<body class="bg-white dark:bg-[#0a0a0a] text-slate-900 dark:text-slate-100 antialiased min-h-screen flex flex-col">
    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-amber-500 text-white font-semibold shadow">
                B
            </div>
            <div>
                <h1 class="text-lg font-semibold">{{ config('app.name', 'Biblioteca') }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">• Colección pública</p>
            </div>
        </div>

        <nav class="flex items-center gap-3">
            <button id="dark-toggle"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-transparent hover:border-slate-200 dark:hover:border-slate-700 text-sm"
                    aria-label="Toggle dark mode">
                <!-- icono sol (visible en claro) -->
                <svg id="icon-light" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 3v1m0 16v1m8.66-9h-1M4.34 12h-1M18.36 5.64l-.7.7M6.34 17.66l-.7.7M18.36 18.36l-.7-.7M6.34 6.34l-.7-.7"/>
                </svg>
                <!-- icono luna (visible en oscuro) -->
                <svg id="icon-dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z" />
                </svg>
                <span class="sr-only">Tema</span>
            </button>

            @auth
                <a href="{{ url('/dashboard') }}" class="px-4 py-1.5 rounded-md text-sm bg-slate-100 dark:bg-slate-800 border border-transparent hover:opacity-90">Dashboard</a>
            @else
                @php
                    $login = function_exists('filament') ? filament()->getLoginUrl() : url('/global/login');
                    $register = url('/global/register');
                @endphp

                <a href="{{ $login }}" class="px-4 py-1.5 rounded-md text-sm bg-amber-500 text-white hover:opacity-95">Iniciar sesión</a>
                <a href="{{ $register }}" class="px-3 py-1.5 rounded-md text-sm border border-slate-200 dark:border-slate-700">Crear cuenta</a>
            @endauth


        </nav>
    </header>

    <main class="flex-1 w-full max-w-6xl mx-auto px-6 py-12">
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-4xl lg:text-5xl font-extrabold leading-tight">Tu biblioteca, rediseñada para el siglo XXI</h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl">
                    Busca, reserva y administra colecciones con una interfaz limpia y rápida. Accede al panel de administración o al panel público según tu rol.
                </p>

                <div class="flex gap-3">
                    <a href="{{ $login }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-md bg-amber-500 text-white font-semibold shadow hover:shadow-md">
                        Explorar colección
                    </a>
                </div>

                <ul class="mt-6 grid grid-cols-2 gap-3 text-sm text-slate-600 dark:text-slate-400 max-w-md">
                    <li class="flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Préstamos y devoluciones</li>

                    <li class="flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Recursos digitales</li>

                </ul>
            </div>

            <div class="bg-gradient-to-br from-slate-50 to-white dark:from-slate-900 dark:to-slate-800 rounded-2xl p-8 shadow-md">
                <div class="rounded-lg overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800">
                    <img src="{{ asset('images/library-hero.jpg') }}" alt="Biblioteca" class="w-full h-56 object-cover block" />
                    <div class="p-6">
                        <h3 class="text-xl font-semibold">Colección destacada</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Descubre recomendaciones seleccionadas por nuestro equipo.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <a href="{{ $login }}" class="text-sm text-amber-600 dark:text-amber-400">Acceder</a>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-md border border-slate-100 dark:border-slate-800">
                        <p class="text-sm text-slate-500">Usuarios</p>
                        <p class="text-lg font-semibold">+1.2k</p>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-md border border-slate-100 dark:border-slate-800">
                        <p class="text-sm text-slate-500">Libros</p>
                        <p class="text-lg font-semibold">8.4k</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full border-t border-slate-100 dark:border-slate-800 py-6">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
            <div>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</div>
            <div class="flex items-center gap-4">
                <a href="/privacy" class="hover:underline">Privacidad</a>
                <a href="/terms" class="hover:underline">Términos</a>
            </div>
        </div>
    </footer>

    <!-- Small helper when no image exists -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersDarkMedia = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
    const root = document.documentElement;
    const toggle = document.getElementById('dark-toggle');
    const iconLight = document.getElementById('icon-light');
    const iconDark = document.getElementById('icon-dark');

    function systemPrefersDark() {
        return prefersDarkMedia ? prefersDarkMedia.matches : false;
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

    // aplicar estado inicial
    apply(isDark());

    if (toggle) {
        toggle.addEventListener('click', function () {
            const newDark = !root.classList.contains('dark');
            apply(newDark);
            // Cuando el usuario elige explícitamente:
            // - 'dark' para modo oscuro
            // - 'light' para modo claro
            localStorage.theme = newDark ? 'dark' : 'light';
            console.log('Tema toggled por botón:', newDark);
        });

        // opcional: doble click para volver a respetar la preferencia del SO
        toggle.addEventListener('dblclick', function () {
            localStorage.removeItem('theme');
            apply(isDark());
            console.log('Preferencia eliminada, ahora se respeta la preferencia del sistema');
        });
    } else {
        console.warn('dark-toggle no encontrado en el DOM');
    }

    // escuchar cambios en preferencia del sistema solo si el usuario no ha elegido explícitamente
    if (prefersDarkMedia && typeof prefersDarkMedia.addEventListener === 'function') {
        prefersDarkMedia.addEventListener('change', (e) => {
            if (!hasExplicitPreference()) {
                apply(e.matches);
            }
        });
    } else if (prefersDarkMedia && typeof prefersDarkMedia.addListener === 'function') {
        prefersDarkMedia.addListener((e) => {
            if (!hasExplicitPreference()) {
                apply(e.matches);
            }
        });
    }
});
</script>
</body>
</html>
