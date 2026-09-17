"""Run a real MCP client session against the local stdio server."""

import asyncio
import json
import sys
from pathlib import Path

from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client


async def main() -> None:
    parameters = StdioServerParameters(
        command=sys.executable,
        args=[str(Path(__file__).with_name("server.py"))],
    )

    async with stdio_client(parameters) as (read_stream, write_stream):
        async with ClientSession(read_stream, write_stream) as session:
            await session.initialize()
            tools = await session.list_tools()
            result = await session.call_tool("get_bookings_statistics", {})
            print(json.dumps({"tools": [tool.name for tool in tools.tools], "result": result.model_dump()}, indent=2))


if __name__ == "__main__":
    asyncio.run(main())
