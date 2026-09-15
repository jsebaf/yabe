<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    public function test_get_hotels_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/hotels');

        $response->assertStatus(200);
    }

    public function test_get_room_types_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/room-types');

        $response->assertStatus(200);
    }

    public function test_post_availability_returns_ok(): void
    {
        $response = $this->postJson('/api/v1/availability');

        $response->assertStatus(200);
    }

    public function test_post_bookings_returns_created(): void
    {
        $response = $this->postJson('/api/v1/bookings');

        $response->assertStatus(201);
    }
}
