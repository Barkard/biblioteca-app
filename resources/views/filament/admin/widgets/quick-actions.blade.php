<x-filament::widget>
    <x-filament::section class="custom-quick-actions-widget">
        <style>
            .custom-quick-actions-widget { background-color: #997d5f !important; }
            .dark .custom-quick-actions-widget { background-color: #181415 !important; }
        </style>
        <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white mb-4">
            Accesos Directos
        </h2>
        <div class="flex flex-row">
            <x-filament::button
                tag="a"
                href="{{ $this->getBookCreateUrl() }}"
                icon="heroicon-m-book-open"
                color="success"
                class="flex-1 mr-[15px]"
            >
                Registrar Libro
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ $this->getUserCreateUrl() }}"
                icon="heroicon-m-user-plus"
                color="primary"
                class="flex-1 mr-[15px]"
            >
                Registrar Usuario
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ $this->getLoanCreateUrl() }}"
                icon="heroicon-m-arrow-path-rounded-square"
                color="warning"
                class="flex-1"
            >
                Registrar Préstamo
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament::widget>
