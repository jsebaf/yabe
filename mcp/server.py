"""Local MCP server exposing simulated booking-engine tools."""

from __future__ import annotations

import json
import logging
from pathlib import Path
from typing import Any

from mcp.server.fastmcp import FastMCP


BASE_DIR = Path(__file__).resolve().parent
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




def record_call(tool_name: str, arguments: dict[str, Any], result: Any) -> Any:
    logger.info(
        "tool=%s arguments=%s result=%s",
        tool_name,
        json.dumps(arguments, sort_keys=True),
        json.dumps(result, sort_keys=True),
    )
    return result


@mcp.tool()
def get_hotels() -> list[dict[str, Any]]:
    """Return simulated hotels."""
    result = [
        {"id": 1, "name": "Hotel Central", "city": "Madrid"},
        {"id": 2, "name": "Hotel Mar", "city": "Barcelona"},
    ]
    return record_call("get_hotels", {}, result)


@mcp.tool()
def get_room_types() -> list[dict[str, Any]]:
    """Return simulated room types."""
    result = [
        {"id": 1, "name": "Standard", "capacity": 2},
        {"id": 2, "name": "Suite", "capacity": 4},
    ]
    return record_call("get_room_types", {}, result)


@mcp.tool()
def get_bookings() -> list[dict[str, Any]]:
    """Return simulated bookings."""
    result = [
        {"id": 1, "hotel_id": 1, "room_type_id": 1, "status": "confirmed"},
        {"id": 2, "hotel_id": 2, "room_type_id": 2, "status": "pending"},
    ]
    return record_call("get_bookings", {}, result)


@mcp.tool()
def get_bookings_statistics() -> dict[str, Any]:
    """Return simulated booking statistics."""
    result = {"total": 2, "confirmed": 1, "pending": 1, "cancelled": 0}
    return record_call("get_bookings_statistics", {}, result)


if __name__ == "__main__":
    mcp.run(transport="stdio")
