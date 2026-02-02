<style>
    .floating-help-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        z-index: 50;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
        /* Colores por defecto (Modo Claro) */
        background-color: #997d5f;
        color: white;
    }

    .floating-help-btn:hover {
        transform: scale(1.1);
        background-color: #80664a;
    }

    /* Estilos para Modo Oscuro (detectando la clase .dark de Filament) */
    html.dark .floating-help-btn {
        background-color: #181415;
        border: 1px solid #374151; /* gray-700 */
    }

    html.dark .floating-help-btn:hover {
        background-color: #2c2225;
    }
</style>

<a
    href="{{ url('admin/manual-de-usuario') }}"
    title="Manual de Usuario"
    class="floating-help-btn"
>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 24px; height: 24px;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
    </svg>
</a>