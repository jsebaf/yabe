# Crear interfaz web de consulta de disponibilidad

## Objetivos

Crear una interfaz web mínima integrada en el proyecto Laravel existente, utilizando React y Tailwind CSS, para consultar la disponibilidad mediante el API existente sin modificarlo.

### Requisitos

- Crear una pantalla React con fondo blanco y presentación sencilla.
- Permitir introducir fecha de entrada, fecha de salida y número de huéspedes.
- Permitir seleccionar opcionalmente un hotel, cargado mediante `GET /api/v1/hotels`.
- No incluir selector de tipo de habitación.
- Enviar `POST /api/v1/availability` con los nombres y formatos del contrato OpenAPI.
- Mostrar los resultados bajo el formulario, incluyendo hotel, tipo de habitación y precio.
- Mostrar estados de carga y errores comprensibles para ambas peticiones.
- Mantener el funcionamiento con los datos actuales del API y la configuración existente.

### Criterios de aceptación

- La pantalla de consulta aparece al acceder a la interfaz web.
- El selector de hoteles se carga desde `/api/v1/hotels` y permite consultar sin hotel.
- Las consultas con y sin hotel envían correctamente fechas, huéspedes y, cuando corresponde, el código del hotel.
- Los resultados del API aparecen bajo el formulario con hotel, tipo de habitación y precio.
- La interfaz informa visualmente durante las peticiones y muestra los errores al usuario.
- No se modifica el contrato ni la implementación de los endpoints existentes.
- La aplicación puede construirse y ejecutarse con la configuración actual.

## Notas

- Issue: #11
- Fuera de alcance: autenticación, creación de reservas, selección de tipo de habitación, cambios en endpoints y administración de hoteles o habitaciones.
- No hay comentarios adicionales en la issue.

## Histórico

- 2026-09-17: Sustituido el servicio mock por persistencia Eloquent, con migraciones, seeders y pruebas actualizadas; creado el Pull Request #18.

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
