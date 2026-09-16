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
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'code',
                    'room_types' => [
                        '*' => [
                            'room_type' => ['name', 'code', 'maxOccupancy'],
                            'quantity',
                            'price',
                        ],
                    ],
                ],
            ])
            ->assertJsonPath('0.code', 'GRAND')
            ->assertJsonPath('0.room_types.0.room_type.code', 'STANDARD')
            ->assertJsonPath('0.room_types.0.quantity', 20)
            ->assertJsonPath('0.room_types.0.price', 95);
    }

    public function test_get_room_types_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/room-types');

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['name', 'code', 'maxOccupancy'],
            ])
            ->assertJsonPath('0.code', 'STANDARD')
            ->assertJsonPath('1.maxOccupancy', 3);
    }

    public function test_post_availability_returns_ok(): void
    {
        $response = $this->postJson('/api/v1/availability', [
            'paxes' => 2,
            'checkin' => '2026-10-01',
            'checkout' => '2026-10-05',
        ]);

        $response->assertOk()
            ->assertJsonCount(5)
            ->assertJsonPath('0.hotel.code', 'GRAND')
            ->assertJsonPath('0.roomType.code', 'STANDARD')
            ->assertJsonPath('0.price', 95);
    }

    public function test_post_availability_excludes_insufficient_capacity_and_cancelled_bookings(): void
    {
        $response = $this->postJson('/api/v1/availability', [
            'paxes' => 3,
            'checkin' => '2026-11-10',
            'checkout' => '2026-11-12',
        ]);

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonPath('0.roomType.code', 'DELUXE')
            ->assertJsonPath('1.roomType.code', 'FAMILY')
            ->assertJsonPath('2.roomType.code', 'DELUXE');
    }

    public function test_post_availability_filters_by_hotel_and_room_type(): void
    {
        $response = $this->postJson('/api/v1/availability', [
            'hotel' => 'SEASIDE',
            'roomType' => 'STANDARD',
            'paxes' => 2,
            'checkin' => '2027-01-01',
            'checkout' => '2027-01-02',
        ]);

        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.hotel.code', 'SEASIDE')
            ->assertJsonPath('0.roomType.code', 'STANDARD')
            ->assertJsonPath('0.price', 110);
    }

    public function test_post_availability_uses_non_overlapping_intervals(): void
    {
        $response = $this->postJson('/api/v1/availability', [
            'hotel' => 'GRAND',
            'roomType' => 'DELUXE',
            'paxes' => 2,
            'checkin' => '2026-10-05',
            'checkout' => '2026-10-06',
        ]);

        $response->assertOk()->assertJsonCount(1);
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
