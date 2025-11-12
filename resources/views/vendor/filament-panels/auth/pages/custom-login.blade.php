<x-filament-panels::page>
    @php
        $hasLogo = filled(\Filament\Facades\Filament::getBrandLogo());
    @endphp

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center">
                @if ($hasLogo)
                    <div class="flex justify-center mb-6">
                        <img
                            src="{{ \Filament\Facades\Filament::getBrandLogo() }}"
                            alt="{{ \Filament\Facades\Filament::getBrandName() }}"
                            class="h-16 w-auto"
                        >
                    </div>
                @else
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ \Filament\Facades\Filament::getBrandName() }}
                    </h1>
                @endif

                <h2 class="text-xl font-semibold text-gray-700 mb-2">
                    Iniciar Sesión
                </h2>
                <p class="text-gray-500 text-sm">
                    Ingresa tus credenciales para acceder al sistema
                </p>
            </div>

            <!-- Form -->
            <form wire:submit="authenticate" class="space-y-6">
                {{ $this->form }}

                <!-- Forgot Password Link -->
                <div class="text-right">
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors duration-200"
                    >
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Iniciar Sesión
                </button>
            </form>

            <!-- Additional Links -->
            <div class="text-center space-y-3">
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-xs text-gray-500">
                        ¿No tienes una cuenta?
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 ml-1">
                            Contacta al administrador
                        </a>
                    </p>
                </div>

                <!-- Social Login (opcional) -->
                <div class="pt-2">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">O continúa con</span>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0110 4.837c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.934.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.163 20 14.418 20 10c0-5.523-4.477-10-10-10z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados adicionales */
        .fi-simple-input {
            border-radius: 0.75rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
        }

        .fi-simple-input:focus {
            border-color: #6366f1;
            ring: 2px;
            ring-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .fi-simple-checkbox {
            border-radius: 0.375rem;
        }

        .fi-btn {
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }
    </style>
</x-filament-panels::page>
