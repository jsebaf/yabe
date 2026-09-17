# Implementar base de servidor MCP local

## Objetivos

Crear un servidor MCP local en Python dentro de `mcp/`, utilizando el SDK oficial de MCP para Python y el transporte `stdio`, para que OpenCode pueda conectarse, descubrir e invocar herramientas sin implementar acceso a la persistencia de la aplicación.

### Requisitos

- Exponer las herramientas `get_hotels`, `get_room_types`, `get_bookings` y `get_bookings_statistics`.
- Permitir resultados simulados sin lógica de acceso a datos ni lógica de negocio de reservas.
- Almacenar los logs en `mcp/logs/`.
- Registrar en `mcp/logs/mcp.log` la operación MCP, la herramienta, los argumentos y el resultado o respuesta.
- Registrar en `mcp/logs/protocol.log`, si es técnicamente posible, los mensajes JSON-RPC intercambiados por `stdio`.
- Mantener `stdout` exclusivamente para la comunicación MCP; enviar diagnósticos a ficheros o `stderr`.
- Documentar en español la instalación, el entorno virtual, la dependencia `mcp`, la configuración explícita de OpenCode y la dependencia de las rutas relativas respecto al directorio de trabajo.
- No depender de APIs internas ni monkey patches del SDK para interceptar solicitudes.
- Verificar los logs mediante una conexión real de cliente MCP.

### Criterios de aceptación

- Existe un servidor MCP Python funcional dentro de `mcp/` que usa el SDK oficial.
- OpenCode puede iniciarlo y conectarse mediante `stdio`, y `opencode mcp list` lo muestra conectado sin `Connection closed`.
- OpenCode puede descubrir las cuatro herramientas mediante `tools/list`.
- OpenCode puede invocar al menos una herramienta mediante `tools/call` y recibe una respuesta válida.
- Las herramientas no acceden a la persistencia y pueden utilizar datos simulados.
- Existen `mcp/logs/` y los ficheros de log se almacenan allí.
- `mcp.log` identifica las operaciones y resultados; `protocol.log` registra el tráfico JSON-RPC cuando el mecanismo lo permite.
- El logging no altera ni interrumpe la comunicación MCP.
- La configuración y las instrucciones de ejecución y conexión con OpenCode están documentadas en español.
- Quedan fuera de alcance la persistencia, consultas reales, autenticación, autorización, análisis de datos, recursos MCP, transporte HTTP y lógica de negocio de reservas.

## Notas

- Issue: #16
- No hay comentarios ni notas adicionales en el issue.
- La configuración debe usar un comando explícito como `"command": [".venv/bin/python", "mcp/server.py"]`.

## Histórico

- 2026-09-17: Implementado y verificado el servidor MCP local en Python con herramientas simuladas, transporte `stdio`, logging y documentación.

- 2026-09-17: Implementada y publicada la interfaz React de consulta de disponibilidad en el Pull Request #19.

- 2026-09-17: Sustituido el servicio mock por persistencia Eloquent, con migraciones, seeders y pruebas actualizadas; creado el Pull Request #18.

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
