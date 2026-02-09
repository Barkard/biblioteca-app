<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

<script>
    // Helper to find elements more robustly
    window.findTutorialElement = function(selector, labelText = null) {
        if (!selector) return null;

        const isVisible = (el) => {
            if (!el) return false;
            if (el.closest('.fi-sidebar')) return false;

            const rect = el.getBoundingClientRect();
            return rect.width > 2 && rect.height > 2;
        };

        const getTargetFromCandidate = (el) => {
            if (!el) return null;
            if (isVisible(el)) return el;

            const wrapper = el.closest('.fi-fo-field-wrp, .fi-fo-field, .fi-fo-input-wrp, .fi-select-input, .choices, .fi-fo-field-content-col, .fi-wi-widget, .fi-fo-wizard-header-step, .fi-section');
            if (wrapper && isVisible(wrapper)) return wrapper;

            let parent = el.parentElement;
            for (let i = 0; i < 5 && parent && parent !== document.body; i++) {
                if (isVisible(parent) && !parent.closest('.fi-sidebar')) return parent;
                parent = parent.parentElement;
            }
            return null;
        };

        if (labelText) {
            const potentialTargets = Array.from(document.querySelectorAll('button, .fi-ac-btn-action, .fi-btn, .fi-button, .fi-fo-wizard-header-step, .fi-fo-wizard-header-step-label, .fi-fo-field-label-content, label, h2, h3'));
            const found = potentialTargets.find(b => {
                const text = b.textContent.trim();
                return (text === labelText || (text.includes(labelText) && !b.closest('.fi-sidebar'))) && isVisible(b);
            });
            if (found) {
                const target = getTargetFromCandidate(found);
                if (target) return target;
            }
        }

        if (selector === 'actions' || selector === 'submit' || selector.includes('actions')) {
            const btns = Array.from(document.querySelectorAll('button[type="submit"], .fi-form-actions button, button.fi-btn-color-primary, .fi-ac-btn-action[type="submit"]'));
            const found = btns.find(isVisible);
            if (found) return found;
        }

        const selectors = selector.split(',').map(s => s.trim());
        for (const s of selectors) {
            let candidates = Array.from(document.querySelectorAll(s));

            if (s.startsWith('[id*=')) {
                const termMatch = s.match(/id\*=["']([^"']+)["']/);
                const term = termMatch ? termMatch[1] : null;
                if (term) {
                    const cleanTerm = term.replace(/^\./, '');
                    candidates = candidates.concat(Array.from(document.querySelectorAll(`[id*="${cleanTerm}"], [name*="${cleanTerm}"], [wire\\:model*="${cleanTerm}"]`)));
                }
            }

            for (const cand of candidates) {
                if ((selector.includes('add') || selector.includes('Details')) &&
                    (cand.getAttribute('wire:click')?.includes('delete') || cand.getAttribute('wire:click')?.includes('remove'))) {
                    continue;
                }
                const target = getTargetFromCandidate(cand);
                if (target) return target;
            }
        }

        return null;
    };

    window.tutorialRegistry = {
        'dashboard': [
            { element: '.custom-welcome-widget', label: 'Bienvenido', popover: { title: 'Bienvenida', description: 'Resumen de actividad y accesos directos.', side: "bottom" } },
            { element: '.fi-wi-stats-overview-stat', popover: { title: 'Estadísticas', description: 'Total de libros, usuarios y préstamos activos.', side: "bottom" } },
            { element: '.custom-quick-actions-widget', label: 'Acciones Rápidas', popover: { title: 'Acciones Rápidas', description: 'Registra libros o préstamos rápidamente.', side: "top" } },
            { element: '.custom-activity-log', label: 'Historial', popover: { title: 'Historial', description: 'Supervisa los últimos cambios realizados.', side: "top" } }
        ],
        'resources': [
            { element: '.fi-header-actions .fi-ac-action[data-action-id="create"], a.fi-btn[href$="/create"]', popover: { title: 'Nuevo Registro', description: 'Añade un nuevo elemento.', side: "bottom" } },
            { element: 'input[id*="search"]', popover: { title: 'Búsqueda', description: 'Encuentra registros rápidamente.', side: "bottom" } }
        ],
        'forms/carnet': [
            { element: '.fi-fo-wizard-header-step', label: 'Seleccionar Usuario', popover: { title: 'Paso 1', description: 'Primero seleccionamos al usuario que recibirá el carnet.', side: "bottom" } },
            { element: '[id*="user_id"]', label: 'Buscar Usuario', popover: { title: 'Búsqueda', description: 'Busca por nombre o cédula.', side: "bottom" } },
            { element: '.fi-fo-wizard-header-step', label: 'Previsualización', popover: { title: 'Paso 2', description: 'Aquí podrás ver cómo quedará el diseño del carnet.', side: "bottom" } },
            { element: '.fi-fo-wizard-header-step', label: 'Descargar', popover: { title: 'Paso 3', description: 'Paso final para obtener el documento.', side: "bottom" } },
            { element: 'button', label: 'Generar Carnet PDF', popover: { title: 'Finalizar', description: 'Haz clic aquí para generar el archivo PDF y descargarlo.', side: "top" } }
        ],
        'forms/books': [
            { element: '[id*="title"]', label: 'Título', popover: { title: 'Título del Libro', description: 'Ingresa el nombre completo de la obra.', side: "bottom" } },
            { element: '[id*="author_id"]', label: 'Autor', popover: { title: 'Autor', description: 'Selecciona al autor del libro o crea uno nuevo.', side: "bottom" } },
            { element: '[id*="publisher_id"]', label: 'Editorial', popover: { title: 'Editorial', description: 'Indica la casa editora correspondiente.', side: "bottom" } },
            { element: '[id*="category_id"]', label: 'Categoría', popover: { title: 'Categoría', description: 'Clasifica el libro para facilitar su búsqueda.', side: "bottom" } },
            { element: 'actions', popover: { title: 'Finalizar Registro', description: 'Haz clic aquí para guardar y crear el libro en la biblioteca.', side: "top" } }
        ],
        'forms/loans': [
            { element: '[id*="user_id"]', label: 'Usuario', popover: { title: 'Seleccionar Usuario', description: 'Busca y selecciona al usuario que solicita el préstamo.', side: "bottom" } },
            { element: 'button', label: 'Añadir ejemplar o libro', popover: { title: 'Añadir Ejemplar', description: 'Selecciona los libros para el préstamo.', side: "top" } },
            { element: 'actions', popover: { title: 'Finalizar Préstamo', description: 'Registra el préstamo en el sistema.', side: "top" } }
        ],
        'forms/reservations': [
            { element: '[id*="user_id"]', label: 'Usuario', popover: { title: '1. Seleccionar Usuario', description: 'Elige al usuario solicitante.', side: "bottom" } },
            { element: '[id*="book_id"]', label: 'Libro', popover: { title: '2. Elegir Libro', description: 'Busca el libro a reservar.', side: "bottom" } },
            { element: '[id*="copy_book_id"]', label: 'Ejemplar', popover: { title: '3. Seleccionar Ejemplar', description: 'Selecciona la cota específica.', side: "bottom" } },
            { element: 'button', label: 'Añadir', popover: { title: '4. Añadir más', description: 'Reserva otro libro en esta orden.', side: "top" } },
            { element: 'button', label: 'Continuar con la reserva', popover: { title: '5. Continuar', description: 'Prepara la confirmación.', side: "top" } },
            { element: 'actions', popover: { title: '6. Finalizar Reserva', description: 'Cierra el proceso oficialmente.', side: "top" } }
        ],
        'forms/default': [
            { element: '.fi-fo-field-wrp:first-of-type, .fi-fo-field', popover: { title: 'Formulario', description: 'Completa los datos.', side: "bottom" } },
            { element: 'actions', popover: { title: 'Guardar', description: 'Guarda tus cambios.', side: "top" } }
        ]
    };

    window.startContextTutorial = function(force = false) {
        const path = window.location.pathname.toLowerCase();
        let context = 'dashboard';

        if (path.includes('/generate-carnet') || path.includes('/generar-carnet')) {
            context = 'forms/carnet';
        } else if (path.includes('/create') || path.includes('/edit')) {
            if (path.includes('/books') || path.includes('/libros')) context = 'forms/books';
            else if (path.includes('/users') || path.includes('/usuarios')) context = 'forms/users';
            else if (path.includes('/roles')) context = 'forms/roles';
            else if (path.includes('/loan-returns') || path.includes('/prestamos')) context = 'forms/loans';
            else if (path.includes('/reservations') || path.includes('/reservas')) context = 'forms/reservations';
            else context = 'forms/default';
        } else if (path.includes('/admin/')) {
            const segments = path.split('/').filter(p => p);
            if (segments.length >= 2) context = 'resources';
        }

        console.log('Tutorial Context:', context);
        let steps = (window.tutorialRegistry[context] || []).map(step => {
            return { ...step, foundElement: window.findTutorialElement(step.element, step.label) };
        });

        steps = steps.filter(step => step.foundElement).map(step => {
            return { ...step, element: step.foundElement };
        });

        if (steps.length === 0) {
            if (force) alert('No hay un tutorial específico para esta sección.');
            return;
        }

        if (window.activeTutorial) return;

        window.activeTutorial = true;
        try {
            const driverObj = window.driver.js.driver({
                showProgress: true,
                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                doneBtnText: 'Finalizar',
                allowClose: true,
                overlayColor: 'rgba(0,0,0,0.5)',
                steps: steps,
                onDestroyed: () => {
                    window.activeTutorial = false;
                }
            });
            driverObj.drive();
        } catch (e) {
            console.error('Tutorial Error:', e);
            window.activeTutorial = false;
        }
    }

    // ELIMINADO: inicio automático mediante timeout
    // El tutorial solo se activará mediante el botón de ayuda que invoca window.startContextTutorial(true)
</script>
