@php
    $user = $this->getUserProperty();
@endphp

@if($user)
    <x-filament::modal width="5xl" alignment="center">
        <x-slot name="trigger">
            <div class="flex justify-center p-4 cursor-zoom-in hover:opacity-95 transition-opacity duration-200" title="Clic para ampliar carnet">
                @include('filament.admin.pages.partials.carnet-design', ['user' => $user])
            </div>
        </x-slot>

        <x-slot name="heading">
            Vista Previa del Carnet
        </x-slot>

        <div class="flex flex-col items-center justify-center w-full py-8 mx-auto">
             <!-- Wrapper with dimensions for 1.8x scale (342*1.8 ~ 616px width, 216*1.8 ~ 389px height) -->
             <div style="width: 620px; height: 400px; display: flex; align-items: center; justify-content: center; margin-left: 180px;" >
                 <div style="transform: scale(1.8); transform-origin: center center;" class="mx-auto">
                    @include('filament.admin.pages.partials.carnet-design', ['user' => $user])
                 </div>
             </div>
        </div>
        
        <x-slot name="footer">
             <div class="flex justify-center w-full">
                <x-filament::button color="gray" x-on:click="close">
                    Cerrar
                </x-filament::button>
             </div>
        </x-slot>
    </x-filament::modal>
@else
    <div class="text-center p-4 text-gray-500">
        <h3 class="text-lg font-medium">Seleccione un usuario</h3>
        <p>Complete el paso anterior para ver la vista previa.</p>
    </div>
@endif
