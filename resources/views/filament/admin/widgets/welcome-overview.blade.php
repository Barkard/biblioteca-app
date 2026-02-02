<x-filament::widget>
    <x-filament::section class="custom-welcome-widget">
        <style>
            .custom-welcome-widget { background-color: #997d5f !important; }
            .dark .custom-welcome-widget { background-color: #181415 !important; }
        </style>
        <div class="flex items-center gap-x-3">
            <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Bienvenido, {{ $this->getUserName() }}
            </h2>
        </div>
    </x-filament::section>
</x-filament::widget>
