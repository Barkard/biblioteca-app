
<!DOCTYPE html>
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
                        <button type="button" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="text-heading bg-yellow-500 box-border border border-transparent hover:bg-yellow-600 cursor-pointer focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Login</button>
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
        @php
            $login = filament()->getLoginUrl();
            $register = 'admin/register';
        @endphp

            <style>
                /* pequeño ajuste para transición tema */
                html { transition: background-color .2s, color .2s; }
            </style>

            <main class="flex-1 w-full max-w-6xl mx-auto px-6 py-12">
                <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h2 class="text-4xl lg:text-5xl font-extrabold leading-tight">Tu biblioteca, rediseñada para el siglo XXI</h2>
                        <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl">
                            Busca, reserva y administra colecciones con una interfaz limpia y rápida. Accede al panel de administración según tu rol.
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


    </main>








<!-- Login Form modal -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Inicio de sesión
                </h3>
                <button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="reader-login-form" action="#" class="pt-4 md:pt-6">
                <div class="mb-4">
                    <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Your email</label>
                    <input type="email" id="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="example@company.com" required />
                </div>
                <div>
                    <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Your password</label>
                    <input type="password" id="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="•••••••••" required />
                </div>
                <div id="reader-login-error" class="mt-3 text-sm text-red-600 hidden"></div>
                <div class="flex items-start my-6">
                    <div class="flex items-center">
                        <input id="checkbox-remember" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                        <label for="checkbox-remember" class="ms-2 text-sm font-medium text-heading">Remember me</label>
                    </div>
                    <a href="#" class="ms-auto text-sm font-medium text-fg-brand hover:underline">Lost Password?</a>
                </div>
                <button type="submit" id="reader-login-submit" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3">Login to your account</button>
                <div class="text-sm font-medium text-body">Not registered? <a href="#" class="text-fg-brand hover:underline">Create account</a></div>
            </form>
        </div>
    </div>
</div>

 <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
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

    <script>
    // AJAX login for reader
    (function () {
        const form = document.getElementById('reader-login-form');
        const submit = document.getElementById('reader-login-submit');
        const errBox = document.getElementById('reader-login-error');

        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            errBox.classList.add('hidden');
            errBox.textContent = '';

            submit.disabled = true;
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch("{{ route('reader.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await res.json().catch(() => ({}));

                if (res.ok && data.success) {
                    // redirect to dashboard
                    window.location.href = data.redirect || '/dashboard';
                    return;
                }

                // show error
                const message = data.message || 'Error al iniciar sesión';
                errBox.textContent = message;
                errBox.classList.remove('hidden');

            } catch (err) {
                errBox.textContent = 'Error de red. Intenta nuevamente.';
                errBox.classList.remove('hidden');
            } finally {
                submit.disabled = false;
            }
        });
    })();
    </script>



    @stack('scripts')
</body>
</html>
