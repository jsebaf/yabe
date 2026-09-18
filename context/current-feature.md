# Automatizar el despliegue mediante GitHub Actions

## Objetivos

Crear un workflow de GitHub Actions que permita desplegar la aplicación en un VPS mediante SSH.

La imagen Docker debe construirse en GitHub Actions y trasladarse al VPS como artefacto. El VPS no debe construir la imagen: debe recibirla, cargarla en Docker y ejecutarla mediante Docker Compose.

### Requisitos

1. Workflow en `.github/workflows/` ejecutable manualmente con `workflow_dispatch`.
2. Obtener el código del repositorio.
3. Construir la imagen Docker con el `Dockerfile` existente.
4. Exportar la imagen con `docker save`.
5. Comprimir el archivo si resulta conveniente para la transferencia.
6. Transferir la imagen al VPS mediante SSH/SCP.
7. Transferir al VPS el `compose.yaml` necesario.
8. Conectarse al VPS mediante SSH.
9. Cargar la imagen en Docker.
10. Ejecutar o actualizar la aplicación mediante Docker Compose.
11. Dejar la aplicación accesible en el puerto configurado.
12. Permitir re-ejecución para actualizar una instalación existente.

### Seguridad

- Usar GitHub Secrets: `VPS_HOST`, `VPS_USER`, `VPS_SSH_KEY`.
- Ningún secreto almacenado directamente en el repositorio.

### Restricciones de ejecución

- **No ejecutar el workflow de GitHub Actions.**
- **No realizar ningún despliegue en el VPS.**
- **No conectarse mediante SSH al VPS.**
- Validación limitada a análisis local y validación sintáctica/estática.

### Criterios de aceptación

- El workflow aparece en `.github/workflows/` y usa `workflow_dispatch`.
- El workflow contiene todos los pasos: construir, empaquetar, transferir y desplegar la imagen.
- El workflow usa GitHub Secrets para las credenciales del VPS.
- El VPS no necesita ejecutar `docker build`.
- El `compose.yaml` de despliegue usa la imagen construida por el workflow.
- La configuración conserva los datos de SQLite mediante volumen Compose.
- El workflow puede re-ejecutarse para actualizar la aplicación.
- Los archivos han sido validados localmente.
- Ningún secreto o clave privada está en el repositorio.

## Notas

- Issue: #22

## Histórico

- 2026-09-18: Dockerizada la aplicación con Dockerfile multietapa, docker-compose.yml, entrypoint idempotente y documentación en español; publicado en el Pull Request #24.

- 2026-09-18: Conectado el servidor MCP con la persistencia real de Laravel, estadísticas, manejo de errores, logging de protocolo y configuración de OpenCode; publicado en el Pull Request #23.

- 2026-09-17: Finalizada la implementación y verificación del servidor MCP local; publicada en el Pull Request #20.

- 2026-09-17: Implementado y verificado el servidor MCP local en Python con herramientas simuladas, transporte `stdio`, logging y documentación.

- 2026-09-17: Implementada y publicada la interfaz React de consulta de disponibilidad en el Pull Request #19.

- 2026-09-17: Sustituido el servicio mock por persistencia Eloquent, con migraciones, seeders y pruebas actualizadas; creado el Pull Request #18.

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
