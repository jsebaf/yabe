# Crear comandos y skills para el workflow de features

## Objetivos

- Definir un workflow reproducible para desarrollar features a partir de GitHub Issues.
- Crear los skills `feature-workflow` y `pull-request`.
- Crear los comandos `/start-feature`, `/create-pr` y `/finish-feature`.
- Activar el workflow de features de forma condicional desde `AGENTS.md`.
- Mantener `context/current-feature.md` como descriptor de la feature activa, preservando su histórico.
- Permitir iniciar, implementar, verificar, publicar para revisión y finalizar una feature sin avanzar automáticamente entre fases.
- Representar los estados de la feature mediante los labels `in-progress` y `done`, sin cerrar manualmente el issue.

### Criterios de aceptación

- Existen los dos skills y los tres comandos especificados en la issue.
- `/start-feature` consulta el issue, actualiza el descriptor, asocia el issue y lo marca como `in-progress`, deteniéndose antes de implementar.
- `/create-pr` verifica y publica los cambios en un Pull Request contra `main`, incluyendo `Closes #<issue-number>`.
- `/finish-feature` actualiza y limpia el descriptor, conserva su histórico, publica en la misma rama y cambia el issue de `in-progress` a `done`.
- Los comandos no hacen push directamente a `main`, no crean Pull Requests duplicados y requieren confirmación explícita para operaciones externas.
- Los commits no incluyen cambios ajenos a la tarea.

## Notas

- Issue: #9
- Issue: https://github.com/jsebaf/yabe/issues/9
- El Pull Request debe poder recibir nuevos commits tras su creación y quedar listo para merge al finalizar la feature.

## Histórico

- 2026-09-14: Creada la issue para inicializar el proyecto Laravel.
