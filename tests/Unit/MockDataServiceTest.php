<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use App\Services\MockDataService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MockDataServiceTest extends TestCase
{
    public function test_service_is_registered_as_a_singleton(): void
    {
        $this->assertSame(
            $this->app->make(MockDataService::class),
            $this->app->make(MockDataService::class),
        );
    }

    public function test_service_provides_all_mock_data_sets(): void
    {
        $service = $this->app->make(MockDataService::class);

        $this->assertContainsOnlyInstancesOf(Hotel::class, $service->hotels());
        $this->assertContainsOnlyInstancesOf(RoomType::class, $service->roomTypes());
        $this->assertContainsOnlyInstancesOf(HotelRoomType::class, $service->hotelRoomTypes());
        $this->assertContainsOnlyInstancesOf(Booking::class, $service->bookings());
        $this->assertGreaterThanOrEqual(2, $service->hotels()->count());
        $this->assertGreaterThanOrEqual(3, $service->roomTypes()->count());
        $this->assertGreaterThanOrEqual(5, $service->hotelRoomTypes()->count());
        $this->assertGreaterThanOrEqual(3, $service->bookings()->count());
    }

    public function test_hotel_room_types_have_coherent_loaded_relations_and_inventory(): void
    {
        $service = $this->app->make(MockDataService::class);

        $service->hotelRoomTypes()->each(function (HotelRoomType $hotelRoomType): void {
            $this->assertInstanceOf(Hotel::class, $hotelRoomType->hotel);
            $this->assertInstanceOf(RoomType::class, $hotelRoomType->roomType);
            $this->assertSame($hotelRoomType->hotel_code, $hotelRoomType->hotel->code);
            $this->assertSame($hotelRoomType->room_type_code, $hotelRoomType->roomType->code);
            $this->assertGreaterThan(0, $hotelRoomType->quantity);
            $this->assertGreaterThan(0, $hotelRoomType->price);
        });

        $service->hotels()->each(function (Hotel $hotel): void {
            $this->assertInstanceOf(Collection::class, $hotel->roomTypes);
            $this->assertNotEmpty($hotel->roomTypes);
            $hotel->roomTypes->each(function (HotelRoomType $hotelRoomType) use ($hotel): void {
                $this->assertSame($hotel->code, $hotelRoomType->hotel->code);
            });
        });
    }

    public function test_bookings_have_varied_coherent_values(): void
    {
        $service = $this->app->make(MockDataService::class);
        $hotelCodes = $service->hotels()->pluck('code');
        $roomTypeCodes = $service->roomTypes()->pluck('code');

        $this->assertEqualsCanonicalizing(
            ['CONFIRMED', 'CANCELLED'],
            $service->bookings()->pluck('status')->unique()->values()->all(),
        );
        $this->assertGreaterThan(1, $service->bookings()->pluck('hotel')->unique()->count());
        $this->assertGreaterThan(1, $service->bookings()->pluck('checkin')->unique()->count());

        $service->bookings()->each(function (Booking $booking) use ($hotelCodes, $roomTypeCodes): void {
            $this->assertContains($booking->hotel, $hotelCodes);
            $this->assertContains($booking->roomType, $roomTypeCodes);
            $this->assertLessThan($booking->checkout, $booking->checkin);
        });
    }
}
