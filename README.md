# yabe
Yet another booking engine

## Ejecución local con Docker

La aplicación puede ejecutarse sin instalar PHP, Composer, Node.js ni las dependencias del proyecto en el sistema anfitrión. Solo se necesita tener Docker con Docker Compose disponible.

### Construir y arrancar

Desde la raíz del proyecto, ejecuta:

```bash
docker compose up --build
```

El contenedor instala las dependencias PHP y JavaScript, construye los assets, genera la clave de Laravel si es necesario, ejecuta las migraciones y carga los datos iniciales en el primer arranque.

La aplicación estará disponible en [http://localhost:8000](http://localhost:8000).

### Detener el entorno

Para detener los contenedores sin eliminar los datos:

```bash
docker compose stop
```

También puedes detenerlos y eliminar los contenedores y la red del proyecto:

```bash
docker compose down
```

### Eliminar los datos de SQLite

La base de datos SQLite se almacena en el volumen nombrado `yabe-data`. `docker compose down` no elimina ese volumen, por lo que los datos sobreviven al recrear el contenedor.

Para eliminar también la base de datos y volver a inicializarla desde cero:

```bash
docker compose down --volumes
```

### Reconstruir la imagen

Después de modificar el `Dockerfile`, las dependencias o los assets, reconstruye la imagen con:

```bash
docker compose build --no-cache
docker compose up
```

## Servidor MCP local

El servidor MCP de prueba está en `mcp/server.py` y expone herramientas con datos simulados. No accede a la persistencia de la aplicación.

### Instalación

Desde la raíz del proyecto, crea y activa un entorno virtual e instala el SDK oficial:

```bash
python3 -m venv .venv
source .venv/bin/activate
python -m pip install -r mcp/requirements.txt
```

### Configuración de OpenCode

Configura el servidor MCP local con un comando explícito:

```json
{
  "mcp": {
    "yabe": {
      "type": "local",
      "command": [".venv/bin/python", "mcp/server.py"]
    }
  }
}
```

Las rutas relativas dependen del directorio de trabajo desde el que OpenCode ejecute el servidor. Comprueba la conexión con:

```bash
opencode mcp list
```

El servidor debe aparecer conectado, sin `Connection closed`. Las operaciones y resultados se escriben en `mcp/logs/mcp.log`; `stdout` queda reservado para MCP y los diagnósticos no se envían por ese canal.
