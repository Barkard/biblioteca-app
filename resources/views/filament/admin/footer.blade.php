<style>
    /* Estilos base (Modo Claro -> Se verá OSCURO) */
    .fi-custom-footer {
        width: 100%;
        padding: 48px 16px;
        margin-top: 40px;
        position: relative;
        z-index: 10;
        transition: all 0.3s ease;
        background-color: #2e1c08b6; /* Negro/Oscuro */
        color: #ffffff;
    }
    .footer-text-muted { color: #afa39cff; }
    .footer-text-highlight { color: #ebe7e5ff; }
    .footer-border { border-top: 1px solid #1f2937; }
    .footer-copy { color: #d1bdafff; }

    /* Estilos Inversos (Modo Oscuro -> Se verá CLARO) */
    html.dark .fi-custom-footer {
        background-color: #f6f3f511; /* Blanco/Gris muy claro */
        color: #ceb1c1cc; /* Texto Negro */
    }
    html.dark .footer-text-muted { color: #976f7dff; }
    html.dark .footer-text-highlight { color: #be97adff; }
    html.dark .footer-border { border-top: 1px solid #d1d5db; }
    html.dark .footer-copy { color: #9ca3af; }
    
    /* Ajuste para el icono de Github en modo inverso */
    html.dark .github-icon { color: #374151; }
</style>

<footer class="fi-custom-footer">
    <div style="max-width: 1280px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 24px;">
        
        {{-- Bloque 1: Créditos --}}
        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <p style="font-size: 1.125rem; font-weight: 500; display: flex; align-items: center; gap: 8px; margin: 0;">
                Diseñado y desarrollado por:
            </p>
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 1.5rem; font-weight: 700; letter-spacing: -0.025em;">Leon Pineda</span>
                <a href="https://github.com/Barkard" target="_blank" rel="noopener noreferrer" class="github-icon" style="text-decoration: none; color: inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="display: block;">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Bloque 2: Contacto --}}
        <div class="footer-text-muted" style="font-size: 0.875rem;">
            Teléfono y Email: <span class="footer-text-highlight">+58 414-741 7970 | leonpineda.dev1506@gmail.com</span>
        </div>

        {{-- Bloque 3: Redes Sociales --}}
        <div style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 20px;">
            <a href="https://www.facebook.com/share/1C86sKZ4Lc/" target="_blank" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #2563eb; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                </svg>
            </a>
            <a href="https://www.instagram.com/leonpf.exe?igsh=MXQ1NWdsOG93aHEyZQ==" target="_blank" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(45deg, #f59e0b, #ec4899, #8b5cf6); text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.332 2.633-1.308 3.608-.975.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.332-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07M12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.28.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.668-.072-4.948-.197-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                </svg>
            </a>
        </div>

        {{-- Bloque 4: Copyright --}}
        <div class="footer-border footer-copy" style="padding-top: 24px; width: 100%; max-width: 400px; font-size: 0.75rem;">
            &copy; {{ date('Y') }} The Literary Haven. All rights reserved.
        </div>
    </div>
</footer>