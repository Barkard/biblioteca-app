# Manual de Usuario - Sistema de Gestión de Biblioteca

Este manual proporciona una guía detallada sobre el funcionamiento y las características del sistema de biblioteca.

---

## 1. Acceso al Sistema

Para ingresar al sistema, el usuario debe dirigirse a la página de inicio de sesión e introducir sus credenciales (correo electrónico y contraseña).

- Si el usuario no tiene cuenta, puede utilizar el botón de registro (si está habilitado) o solicitar al administrador su creación.
- El sistema cuenta con un selector de tema (claro/oscuro) en la parte superior derecha antes de ingresar.

## 2. Interfaz Principal (Dashboard)

Una vez dentro, el Dashboard ofrece una visión general del estado de la biblioteca:

- **Resumen de Estadísticas:** Contadores en tiempo real de Usuarios registrados, Libros en inventario y Préstamos activos.
- **Acciones Rápidas:** Botones directos para tareas comunes como registrar un libro, un usuario o un nuevo préstamo.
- **Historial (Activity Log):** Una tabla que muestra las últimas acciones realizadas en el sistema (quién hizo qué y cuándo).

## 3. Generación de Carnet

El sistema permite generar carnets de identificación para los usuarios:

1. Diríjase al módulo **Generar Carnet** en el menú lateral.
2. **Paso 1:** Busque el usuario por su Cédula o Nombre.
3. **Paso 2:** Verifique los datos en la previsualización del carnet.
4. **Paso 3:** Haga clic en "Generar Carnet PDF" para descargar el documento listo para imprimir.

## 4. Módulo de Libros

Aquí se gestiona el catálogo bibliográfico:

- Registro de libros con detalles como título, edición, sinopsis y portada.
- Relación con **Autores**, **Categorías** y **Editoriales** para una búsqueda organizada.

## 5. Ejemplares y Autenticaciones

Un libro puede tener múltiples copias físicas (Ejemplares):

- **Cota:** Cada ejemplar tiene un código único llamado "Cota" que sirve como su identificador principal ("autenticación" física).
- El sistema valida automáticamente que no existan cotas duplicadas.
- Al registrar un ejemplar, se debe buscar y seleccionar el libro base del catálogo.

## 6. Préstamos

Gestión de salida de libros:

- Al crear un préstamo, se selecciona al usuario y uno o varios ejemplares disponibles.
- El sistema cambia automáticamente el estado del ejemplar a "Prestado".
- **Devoluciones:** Desde la vista de detalles del préstamo, el bibliotecario puede marcar cada libro como devuelto con un solo clic.

## 7. Reservas

Permite a los usuarios asegurar un libro que actualmente no está disponible:

- El sistema muestra la fecha estimada de disponibilidad.
- Una vez que el ejemplar vuelve a estar disponible, la reserva puede convertirse directamente en un préstamo activo.

## 8. Roles

El sistema utiliza roles para controlar el acceso:

- **Administrador:** Acceso total a todas las funciones.
- **Otros niveles:** Acceso limitado según las necesidades del personal (ej. solo gestionar préstamos).

## 10. Usuarios (Gestión de Personal)

- Solo el **Administrador** tiene los permisos para crear y gestionar nuevos usuarios.
- Se debe registrar Nombre, Apellido, Cédula/RIF, correo, fecha de nacimiento y asignar un rol específico.
- Es posible activar o desactivar usuarios para restringir su acceso.

## 11. Registro de Visitas

Módulo para llevar el control de afluencia en la biblioteca:

- Se registra la Cédula, Género y Edad de cada visitante.
- **Reportes:** El sistema permite generar reportes en Excel filtrados por rango de fechas (desde/hasta) para obtener estadísticas de visitas.

---

_Manual generado automáticamente por el sistema de gestión de biblioteca._
