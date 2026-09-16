# Preparar servicio de datos mock

## Objetivos

- Implementar un servicio dedicado que proporcione datos mock en memoria.
- Encapsular los datos mock para mantener los controllers independientes de su estructura concreta.
- Proporcionar hoteles, tipos de habitación, relaciones `HotelRoomType` con la cantidad de unidades disponibles y bookings.
- Utilizar los modelos Eloquent existentes (`Hotel`, `RoomType`, `HotelRoomType` y `Booking`) para representar los datos.
- Mantener relaciones coherentes y suficiente variedad de hoteles, tipos de habitación y bookings con distintas fechas para probar posteriormente los endpoints y el cálculo de disponibilidad.
- Mantener la suite de tests existente pasando.

### Fuera de alcance

- Persistencia en base de datos, migraciones y seeders.
- Implementación de endpoints del API.
- Cálculo de disponibilidad.
- Creación o cancelación de bookings mediante el API.
- Control de concurrencia.
- Modificación del contrato OpenAPI.

## Notas

- Los datos deben mantenerse en memoria y no requieren base de datos.
- No se implementará lógica de negocio en esta tarea.

## Histórico

- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
