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
                 <!-- Mostrar frente y reverso uno debajo del otro -->
                 <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start; width: 100%; min-height: 900px; gap: 48px;">
                      <div style="width: 420px; height: 260px; margin-bottom: 0; display: flex; align-items: center; justify-content: center;">
                          @include('filament.admin.pages.partials.carnet-design', ['user' => $user])
                      </div>

                      <div style="width: 420px; height: 260px; margin-top: 0; display: flex; align-items: center; justify-content: center;">
                          @include('filament.admin.pages.partials.carnet-reverse', ['user' => $user])
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
