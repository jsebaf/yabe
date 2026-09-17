# Sustituir el servicio mock por persistencia

## Objetivos

### Requisitos

- Implementar el acceso a los datos utilizando los modelos Eloquent existentes en `app/Models`.
- Mantener el contrato definido en `app/Contracts`.
- Sustituir la implementación mock actualmente utilizada por el servicio de datos.
- Utilizar las relaciones Eloquent existentes entre los modelos cuando sea necesario.
- Crear o completar las migraciones necesarias para representar en la base de datos el modelo de datos utilizado actualmente por la aplicación.
- Crear o completar los seeders necesarios para disponer de datos de prueba reproducibles.
- Mantener el contrato de los endpoints existentes.
- Eliminar la dependencia del mock en el funcionamiento normal de la aplicación.
- Adaptar los tests existentes cuando sea necesario y añadir los tests necesarios para verificar la persistencia.

### Criterios de aceptación

- La aplicación puede ejecutarse utilizando exclusivamente los datos almacenados en la base de datos.
- Los datos utilizados por los endpoints de consulta proceden de Eloquent.
- El endpoint de disponibilidad funciona utilizando los datos persistidos.
- Los datos iniciales pueden generarse mediante los seeders de Laravel.
- Los endpoints mantienen el contrato existente.
- Los tests existentes continúan pasando.
- La implementación mock deja de utilizarse en el flujo normal de la aplicación.
- La aplicación funciona correctamente utilizando SQLite en el entorno local y PostgreSQL en producción, sin cambios en la lógica de acceso a datos.

### Fuera de alcance

- No añadir nuevos endpoints.
- No modificar el contrato de la API existente.
- No añadir nuevas funcionalidades al dominio de reservas.
- No implementar todavía nuevas operaciones de escritura sobre reservas.
- No modificar el frontend.

## Notas

- Issue: #10
- La issue está abierta y no tiene labels ni comentarios.
- La implementación debe ser compatible con SQLite en desarrollo local y PostgreSQL en producción.

## Histórico

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
