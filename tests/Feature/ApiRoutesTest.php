<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    public function test_get_hotels_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/hotels');

        $response->assertOk()
            ->assertJsonCount(2)
            ->assertJsonPath('0.code', 'GRAND')
            ->assertJsonPath('0.room_types.0.room_type.code', 'STANDARD');
    }

    public function test_get_room_types_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/room-types');

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonPath('0.code', 'STANDARD')
            ->assertJsonPath('1.maxOccupancy', 3);
    }

    public function test_post_availability_returns_ok(): void
    {
        $response = $this->postJson('/api/v1/availability');

        $response->assertOk()
            ->assertJsonCount(5)
            ->assertJsonPath('0.hotel.code', 'GRAND')
            ->assertJsonPath('0.room_type.code', 'STANDARD')
            ->assertJsonPath('0.quantity', 20);
    }

    public function test_post_bookings_returns_created(): void
    {
        $response = $this->postJson('/api/v1/bookings');

        $response->assertCreated()
            ->assertJsonPath('locator', 'ABC123')
            ->assertJsonPath('hotel', 'GRAND')
            ->assertJsonPath('status', 'CONFIRMED');
    }
}
