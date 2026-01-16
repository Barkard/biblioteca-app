<x-filament::widget>
    <x-filament::section>
        <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white mb-4">
            Accesos Directos
        </h2>
        <div class="flex flex-col gap-2">
            <x-filament::button
                tag="a"
                href="{{ $this->getBookCreateUrl() }}"
                icon="heroicon-m-book-open"
                color="success"
                class="w-full"
            >
                Registrar Libro
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ $this->getUserCreateUrl() }}"
                icon="heroicon-m-user-plus"
                color="primary"
                class="w-full"
            >
                Registrar Usuario
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ $this->getLoanCreateUrl() }}"
                icon="heroicon-m-arrow-path-rounded-square"
                color="warning"
                class="w-full"
            >
                Registrar Préstamo
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament::widget>
