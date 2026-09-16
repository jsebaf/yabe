# Implementar endpoints de consulta

## Objetivos

Implementar los endpoints de consulta del API para obtener hoteles y tipos de habitación usando el servicio de datos mock existente, conforme a la especificación OpenAPI.

### Requisitos

- Implementar `GET /api/v1/hotels`.
- Implementar `GET /api/v1/room-types`.
- Hacer que ambos endpoints utilicen el servicio de datos mock existente.
- Evitar el acceso directo a los datos mock desde los controllers.
- Mantener fuera de alcance la persistencia, disponibilidad, reservas, paginación, filtrado, ordenación y autenticación.

### Criterios de aceptación

- `GET /api/v1/hotels` devuelve un array conforme al esquema `Hotel` de OpenAPI.
- Cada hotel incluye sus `HotelRoomType`, incluyendo el `RoomType` y `quantity`.
- `GET /api/v1/room-types` devuelve un array conforme al esquema `RoomType` de OpenAPI.
- Los endpoints son accesibles sin autenticación.
- Existen Feature Tests para ambos endpoints que verifican al menos el código de respuesta y la estructura.
- La suite completa de tests continúa pasando.

## Notas

- Issue: #4
- La issue está abierta y actualmente no tiene labels ni comentarios.

## Histórico

- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
