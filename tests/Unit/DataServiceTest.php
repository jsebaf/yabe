<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use App\Services\DataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_reads_seeded_data_from_database(): void
    {
        $this->seed();
        $service = $this->app->make(DataService::class);

        $this->assertContainsOnlyInstancesOf(Hotel::class, $service->hotels());
        $this->assertContainsOnlyInstancesOf(RoomType::class, $service->roomTypes());
        $this->assertContainsOnlyInstancesOf(HotelRoomType::class, $service->hotelRoomTypes());
        $this->assertContainsOnlyInstancesOf(Booking::class, $service->bookings());
        $this->assertDatabaseCount('hotels', 2);
        $this->assertDatabaseCount('room_types', 3);
        $this->assertDatabaseCount('hotel_room_types', 5);
        $this->assertDatabaseCount('bookings', 3);
    }
}
