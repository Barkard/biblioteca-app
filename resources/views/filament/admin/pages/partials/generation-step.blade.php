<div 
    class="flex flex-col items-center justify-center p-6 space-y-6 min-h-[300px]"
    x-data="{ generated: false }"
    x-on:start-generation.window="generated = true"
>
    <!-- Estado Inicial: Listo -->
    <div 
        x-show="!generated" 
        wire:loading.remove 
        wire:target="generate" 
        class="text-center space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-500"
    >
        <div class="p-6 bg-primary-50 rounded-full inline-block dark:bg-gray-800 ring-1 ring-gray-200 dark:ring-gray-700 shadow-sm">
            <x-heroicon-o-document-arrow-down class="text-primary-600 dark:text-primary-400" style="width: 4rem; height: 4rem;" />
        </div>
        <div class="space-y-1">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                Listo para generar
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                Haga clic en el botón "Generar Carnet PDF" para iniciar la descarga.
            </p>
        </div>
    </div>

    <!-- Estado Exito: Descarga Completada -->
    <div 
        x-show="generated" 
        x-cloak 
        wire:loading.remove 
        wire:target="generate" 
        class="text-center space-y-4 animate-in zoom-in duration-500"
    >
        <div class="p-6 bg-green-50 rounded-full inline-block dark:bg-gray-800 ring-1 ring-green-200 dark:ring-green-900/30 shadow-sm">
             <x-heroicon-o-check-circle class="text-green-600 dark:text-green-400" style="width: 4rem; height: 4rem;" />
        </div>
        <div class="space-y-1">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                ¡Descarga Completada!
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                Su carnet se ha generado y descargado correctamente.
            </p>
            <button 
                type="button" 
                x-on:click="generated = false" 
                class="text-sm font-medium text-primary-600 hover:text-primary-500 hover:underline mt-4 transition-colors"
            >
                Generar nuevo carnet
            </button>
        </div>
    </div>

    <!-- Estado Carga: Barra de Progreso -->
    <div 
        wire:loading 
        wire:target="generate" 
        class="w-full max-w-lg space-y-8 text-center animate-in fade-in duration-300"
    >
        <div class="space-y-2">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Generando Carnet...</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Por favor espere, procesando PDF.</p>
        </div>

        <div class="relative pt-2 px-4">
            <div class="overflow-hidden h-3 mb-2 text-xs flex rounded-full bg-gray-200 dark:bg-gray-700 w-full shadow-inner">
                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-600 h-full rounded-full w-full relative overflow-hidden">
                     <div class="absolute inset-0 bg-white/30 w-full h-full animate-[shimmer_1.5s_infinite] origin-left" style="transform: skewX(-20deg);"></div>
                </div>
            </div>
            <div class="flex justify-between text-xs text-gray-400 px-1">
                <span>Procesando datos</span>
                <span>Generando diseño</span>
                <span>Descargando</span>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes shimmer {
  0% { transform: translateX(-150%) skewX(-20deg); }
  50% { transform: translateX(0%) skewX(-20deg); }
  100% { transform: translateX(150%) skewX(-20deg); }
}
</style>
