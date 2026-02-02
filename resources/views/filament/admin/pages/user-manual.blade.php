<script src="https://cdn.tailwindcss.com"></script>
<x-filament-panels::page>
    <div class="space-y-6 pb-12">
        <!-- Encabezado -->
        <div class="p-6 rounded-xl shadow-lg text-white mb-8" style="background-color: #997d5f;">
            <h2 class="text-3xl font-bold italic">Manual de Usuario</h2>
            <p class="mt-2 opacity-90">Guía paso a paso sobre el funcionamiento del Sistema de Gestión de Biblioteca.</p>
        </div>

        <!-- Secciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- 1. Acceso y Dashboard -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-lock-closed class="w-5 h-5" />
                        <span>1. Acceso y Dashboard</span>
                    </div>
                </x-slot>
                <p><strong>Acceso:</strong> Ingrese con correo y contraseña. Use el selector de tema (Sol/Luna) para ajustar la vista.</p>
                <p class="mt-2 text-sm text-gray-500"><strong>Dashboard:</strong> Visualice contadores de libros, usuarios y préstamos activos, además del historial de acciones.</p>
            </x-filament::section>

            <!-- 2. Generación de Carnet -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-identification class="w-5 h-5" />
                        <span>2. Generación de Carnet</span>
                    </div>
                </x-slot>
                <p>Vaya a <strong>Generar Carnet</strong>. Siga el asistente:</p>
                <ul class="list-disc list-inside mt-2 text-sm space-y-1">
                    <li>Seleccione al usuario (por cédula o nombre).</li>
                    <li>Previsualice el diseño del carnet.</li>
                    <li>Descargue el PDF para impresión.</li>
                </ul>
            </x-filament::section>

            <!-- 3. Libros y Ejemplares -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-book-open class="w-5 h-5" />
                        <span>3. Libros y Ejemplares</span>
                    </div>
                </x-slot>
                <p><strong>Libros:</strong> Registre la información base (Título, Autor, Editorial).</p>
                <p class="mt-2"><strong>Ejemplares (Cota):</strong> Cada copia física tiene una "Cota" única. El sistema autentica que no existan duplicados antes de guardar.</p>
            </x-filament::section>

            <!-- 4. Préstamos y Reservas -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-arrow-path-rounded-square class="w-5 h-5" />
                        <span>4. Préstamos y Reservas</span>
                    </div>
                </x-slot>
                <p><strong>Préstamos:</strong> Seleccione usuario y libros. Marque devoluciones con un clic desde el detalle.</p>
                <p class="mt-2"><strong>Reservas:</strong> Asegure libros prestados. El sistema avisará cuando estén disponibles para convertirlos a préstamo.</p>
            </x-filament::section>

            <!-- 5. Usuarios y Roles -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-users class="w-5 h-5" />
                        <span>5. Usuarios y Roles</span>
                    </div>
                </x-slot>
                <p>Solo el <strong>Administrador</strong> puede gestionar usuarios. Se requiere Cédula, Nombre y asignación de un Rol (Admin, Bibliotecario, etc.) para controlar permisos.</p>
            </x-filament::section>

            <!-- 6. Registro de Visitas -->
            <x-filament::section collapsible hoverable>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5" />
                        <span>6. Registro de Visitas</span>
                    </div>
                </x-slot>
                <p>Registre la entrada de visitantes mediante su Cédula, Género y Edad. Use el botón <strong>Generar Reporte</strong> para descargar el archivo Excel mensual.</p>
            </x-filament::section>
        </div>
        
        <!-- Footer del Manual -->
        <div class="mt-8 text-center text-gray-400 text-sm">
            <p>© 2026 Sistema de Gestión de Biblioteca - Todos los derechos reservados.</p>
        </div>
    </div>
</x-filament-panels::page>
