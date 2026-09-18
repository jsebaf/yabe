"""Local MCP server exposing the application's booking data."""

from __future__ import annotations

import json
import logging
import os
import subprocess
import anyio
from pathlib import Path
from typing import Any

from mcp.server.stdio import stdio_server
from mcp.server.fastmcp import FastMCP
from mcp.shared.message import SessionMessage


BASE_DIR = Path(__file__).resolve().parent
APP_DIR = BASE_DIR.parent
LOG_DIR = BASE_DIR / "logs"
LOG_DIR.mkdir(parents=True, exist_ok=True)


def configure_logging() -> logging.Logger:
    logger = logging.getLogger("yabe.mcp")
    logger.setLevel(logging.INFO)
    logger.propagate = False

    if not logger.handlers:
        handler = logging.FileHandler(LOG_DIR / "mcp.log", encoding="utf-8")
        handler.setFormatter(logging.Formatter("%(asctime)s %(levelname)s %(message)s"))
        logger.addHandler(handler)

    return logger


logger = configure_logging()
mcp = FastMCP("yabe-booking-engine")

# The SDK owns stdio framing; protocol.log remains available for SDK diagnostics.
protocol_logger = logging.getLogger("mcp.protocol")
protocol_logger.setLevel(logging.INFO)
protocol_logger.propagate = False
if not protocol_logger.handlers:
    protocol_handler = logging.FileHandler(LOG_DIR / "protocol.log", encoding="utf-8")
    protocol_handler.setFormatter(logging.Formatter("%(asctime)s %(message)s"))
    protocol_logger.addHandler(protocol_handler)


class ProtocolReceiveStream:
    def __init__(self, stream: Any) -> None:
        self.stream = stream

    async def __aiter__(self):
        async for message in self.stream:
            protocol_logger.info("received=%s", message.message.model_dump_json() if isinstance(message, SessionMessage) else message)
            yield message

    async def aclose(self) -> None:
        await self.stream.aclose()

    async def __aenter__(self):
        await self.stream.__aenter__()
        return self

    async def __aexit__(self, *args: Any) -> None:
        await self.stream.__aexit__(*args)


class ProtocolSendStream:
    def __init__(self, stream: Any) -> None:
        self.stream = stream

    async def send(self, message: SessionMessage) -> None:
        protocol_logger.info("sent=%s", message.message.model_dump_json())
        await self.stream.send(message)

    async def aclose(self) -> None:
        await self.stream.aclose()

    async def __aenter__(self):
        await self.stream.__aenter__()
        return self

    async def __aexit__(self, *args: Any) -> None:
        await self.stream.__aexit__(*args)


async def run_server() -> None:
    async with stdio_server() as (read_stream, write_stream):
        await mcp._mcp_server.run(
            ProtocolReceiveStream(read_stream),
            ProtocolSendStream(write_stream),
            mcp._mcp_server.create_initialization_options(),
        )




def record_call(tool_name: str, arguments: dict[str, Any], result: Any) -> Any:
    logger.info(
        "tool=%s arguments=%s result=%s",
        tool_name,
        json.dumps(arguments, sort_keys=True),
        json.dumps(result, sort_keys=True),
    )
    return result


def query_application(expression: str) -> Any:
    """Run an Eloquent query through the application's own Laravel bootstrap."""
    process = subprocess.run(
        ["php", "artisan", "tinker", "--execute", f"echo json_encode({expression});"],
        cwd=APP_DIR,
        capture_output=True,
        text=True,
        timeout=30,
        env=os.environ.copy(),
        check=False,
    )
    if process.returncode != 0:
        details = process.stderr.strip() or process.stdout.strip()
        raise RuntimeError(details or "Application query failed")

    try:
        return json.loads(process.stdout)
    except json.JSONDecodeError as error:
        raise RuntimeError("Application returned invalid JSON") from error


def call_tool(tool_name: str, arguments: dict[str, Any], expression: str) -> Any:
    try:
        return record_call(tool_name, arguments, query_application(expression))
    except (OSError, subprocess.SubprocessError, RuntimeError) as error:
        result = {"error": str(error)}
        logger.exception("tool=%s query failed", tool_name)
        return record_call(tool_name, arguments, result)


@mcp.tool()
def get_hotels() -> list[dict[str, Any]]:
    """Return hotels from the application's database."""
    return call_tool("get_hotels", {}, "\\App\\Models\\Hotel::query()->get()->toArray()")


@mcp.tool()
def get_room_types() -> list[dict[str, Any]]:
    """Return room types from the application's database."""
    return call_tool("get_room_types", {}, "\\App\\Models\\RoomType::query()->get()->toArray()")


@mcp.tool()
def get_bookings() -> list[dict[str, Any]]:
    """Return bookings from the application's database."""
    return call_tool("get_bookings", {}, "\\App\\Models\\Booking::query()->get()->toArray()")


@mcp.tool()
def get_bookings_statistics() -> dict[str, Any]:
    """Return booking status statistics calculated from the application's database."""
    expression = "\\App\\Models\\Booking::query()->get()->groupBy('status')->mapWithKeys(fn($items, $status) => [strtolower($status) => $items->count()])->prepend(\\App\\Models\\Booking::query()->count(), 'total')->toArray()"
    return call_tool("get_bookings_statistics", {}, expression)


if __name__ == "__main__":
    anyio.run(run_server)
