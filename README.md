# yabe
Yet another booking engine

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
