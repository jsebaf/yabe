# Dockerizar aplicación para ejecución local

## Objetivos

Preparar la aplicación para ejecutarse completamente mediante Docker Compose, sin instalar PHP, Composer, Node.js ni las dependencias de la aplicación en el sistema anfitrión, dejando una base reutilizable para un futuro despliegue de la misma imagen en un VPS.

### Requisitos

- Crear un `Dockerfile` para construir la imagen de la aplicación.
- Instalar las dependencias PHP mediante `composer install`.
- Instalar las dependencias JavaScript mediante `npm ci`.
- Construir los assets de React/Vite mediante `npm run build`.
- Utilizar SQLite como base de datos.
- Inicializar la base de datos mediante las migraciones y el seed de Laravel.
- Crear un `compose.yaml` que permita levantar la aplicación con un único comando.
- Exponer la aplicación al host mediante el puerto `8000`.
- Ejecutar Laravel en una interfaz accesible desde fuera del contenedor.
- Permitir eliminar y recrear el contenedor sin reconstruir manualmente el entorno.
- Gestionar coherentemente los datos necesarios para la base de datos SQLite.

### Criterios de aceptación

- Desde una instalación limpia, `docker compose up --build` debe arrancar correctamente la aplicación.
- La aplicación debe estar disponible en `http://localhost:8000`.
- La aplicación debe disponer de la estructura de base de datos y los datos iniciales de las migraciones y el seed de Laravel.
- Debe ser posible detener, eliminar y volver a levantar el entorno siguiendo las instrucciones documentadas.
- La documentación debe estar en español e incluir cómo construir, arrancar, acceder, detener, eliminar y reconstruir el entorno.
- La documentación debe explicar las decisiones relevantes sobre la persistencia de SQLite.

## Notas

- Issue: #21
- Fuera del alcance: despliegue en VPS, SSH, GitHub Actions, configuración de producción, HTTPS, PostgreSQL y servidores web externos como Nginx.

## Histórico

- 2026-09-18: Conectado el servidor MCP con la persistencia real de Laravel, estadísticas, manejo de errores, logging de protocolo y configuración de OpenCode; publicado en el Pull Request #23.

- 2026-09-17: Finalizada la implementación y verificación del servidor MCP local; publicada en el Pull Request #20.

- 2026-09-17: Implementado y verificado el servidor MCP local en Python con herramientas simuladas, transporte `stdio`, logging y documentación.

- 2026-09-17: Implementada y publicada la interfaz React de consulta de disponibilidad en el Pull Request #19.

- 2026-09-17: Sustituido el servicio mock por persistencia Eloquent, con migraciones, seeders y pruebas actualizadas; creado el Pull Request #18.

- 2026-09-16: Implementada y verificada la consulta de disponibilidad con filtros, capacidad, inventario, solapamiento de bookings y precios.
- 2026-09-16: Finalizada la implementación y verificación de los endpoints de consulta; creado el Pull Request #14.
- 2026-09-16: Implementado el workflow de features con skills, comandos y activación condicional en `AGENTS.md`; creado el Pull Request #13.
- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
