# Conectar el MCP Server con los datos reales

## Objetivos

Completar la implementación del MCP Server para que sus herramientas consulten los datos reales de la aplicación usando la misma configuración de persistencia del entorno local.

### Requisitos

- Sustituir los datos simulados de `get_hotels`, `get_room_types`, `get_bookings` y `get_bookings_statistics` por consultas a la persistencia real.
- Proporcionar información suficiente para consultar los hoteles y las reservas existentes.
- Mantener el logging de consultas y resultados en `mcp.log`.
- Gestionar los errores de consulta y comunicarlos al cliente MCP sin terminar inesperadamente el servidor.

### Criterios de aceptación

- El MCP Server continúa ejecutándose localmente mediante `stdio` y puede ser utilizado por OpenCode.
- `get_hotels` devuelve los hoteles existentes en la persistencia local de la aplicación.
- `get_room_types` devuelve los tipos de habitación existentes en la persistencia local de la aplicación.
- `get_bookings` devuelve las reservas existentes en la persistencia local de la aplicación.
- `get_bookings_statistics` devuelve estadísticas calculadas a partir de los datos reales de reservas.
- Las herramientas no utilizan datos simulados.
- El MCP Server utiliza la configuración de acceso a la persistencia existente en el entorno local.
- Las invocaciones de las herramientas y sus resultados continúan registrándose en `mcp/logs/mcp.log`.
- Los mensajes del protocolo MCP continúan registrándose en `mcp/logs/protocol.log` cuando el mecanismo de captura existente lo permita.
- Es posible utilizar OpenCode para realizar consultas en lenguaje natural cuya respuesta requiera utilizar los datos reales de la aplicación.

### Fuera de alcance

- Nuevas herramientas MCP distintas de las definidas en la primera iteración.
- `resources` MCP.
- Transporte HTTP.
- Autenticación o autorización específica del MCP Server.
- Análisis avanzado, generación de informes o integración con servicios o fuentes externas.

## Notas

- Issue: #17
- Issue abierta, sin labels ni comentarios al iniciar la feature.

## Histórico

- 2026-09-17: Finalizada la implementación y verificación del servidor MCP local; publicada en el Pull Request #20.

- 2026-09-17: Implementado y verificado el servidor MCP local en Python con herramientas simuladas, transporte `stdio`, logging y documentación.

- 2026-09-17: Implementada y publicada la interfaz React de consulta de disponibilidad en el Pull Request #19.

- 2026-09-17: Sustituido el servicio mock por persistencia Eloquent, con migraciones, seeders y pruebas actualizadas; creado el Pull Request #18.

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
