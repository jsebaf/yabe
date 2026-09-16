<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Support\Collection;

class MockDataService
{
    /**
     * @var Collection<int, Hotel>
     */
    private Collection $hotels;

    /**
     * @var Collection<int, RoomType>
     */
    private Collection $roomTypes;

    /**
     * @var Collection<int, HotelRoomType>
     */
    private Collection $hotelRoomTypes;

    /**
     * @var Collection<int, Booking>
     */
    private Collection $bookings;

    public function __construct()
    {
        $this->roomTypes = collect([
            new RoomType([
                'name' => 'Standard Room',
                'code' => 'STANDARD',
                'maxOccupancy' => 2,
            ]),
            new RoomType([
                'name' => 'Deluxe Room',
                'code' => 'DELUXE',
                'maxOccupancy' => 3,
            ]),
            new RoomType([
                'name' => 'Family Suite',
                'code' => 'FAMILY',
                'maxOccupancy' => 4,
            ]),
        ]);

        $this->hotels = collect([
            new Hotel([
                'name' => 'Grand Hotel',
                'code' => 'GRAND',
            ]),
            new Hotel([
                'name' => 'Seaside Resort',
                'code' => 'SEASIDE',
            ]),
        ]);

        $this->hotelRoomTypes = collect([
            $this->hotelRoomType('GRAND', 'STANDARD', 20, 95.00),
            $this->hotelRoomType('GRAND', 'DELUXE', 10, 125.50),
            $this->hotelRoomType('GRAND', 'FAMILY', 4, 180.00),
            $this->hotelRoomType('SEASIDE', 'STANDARD', 15, 110.00),
            $this->hotelRoomType('SEASIDE', 'DELUXE', 8, 145.00),
        ]);

        $this->hotels->each(function (Hotel $hotel): void {
            $hotel->setRelation(
                'roomTypes',
                $this->hotelRoomTypes->where('hotel_code', $hotel->code)->values(),
            );
        });

        $this->bookings = collect([
            new Booking([
                'locator' => 'ABC123',
                'hotel' => 'GRAND',
                'roomType' => 'DELUXE',
                'paxes' => 2,
                'checkin' => '2026-10-01',
                'checkout' => '2026-10-05',
                'status' => 'CONFIRMED',
            ]),
            new Booking([
                'locator' => 'DEF456',
                'hotel' => 'GRAND',
                'roomType' => 'STANDARD',
                'paxes' => 1,
                'checkin' => '2026-11-10',
                'checkout' => '2026-11-12',
                'status' => 'CANCELLED',
            ]),
            new Booking([
                'locator' => 'GHI789',
                'hotel' => 'SEASIDE',
                'roomType' => 'STANDARD',
                'paxes' => 2,
                'checkin' => '2026-12-20',
                'checkout' => '2026-12-27',
                'status' => 'CONFIRMED',
            ]),
        ]);
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function hotels(): Collection
    {
        return $this->hotels;
    }

    /**
     * @return Collection<int, RoomType>
     */
    public function roomTypes(): Collection
    {
        return $this->roomTypes;
    }

    /**
     * @return Collection<int, HotelRoomType>
     */
    public function hotelRoomTypes(): Collection
    {
        return $this->hotelRoomTypes;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function bookings(): Collection
    {
        return $this->bookings;
    }

    private function hotelRoomType(
        string $hotelCode,
        string $roomTypeCode,
        int $quantity,
        float $price,
    ): HotelRoomType {
        $hotelRoomType = new HotelRoomType([
            'hotel_code' => $hotelCode,
            'room_type_code' => $roomTypeCode,
            'quantity' => $quantity,
            'price' => $price,
        ]);

        $hotelRoomType->setRelation('hotel', $this->hotels->firstWhere('code', $hotelCode));
        $hotelRoomType->setRelation('roomType', $this->roomTypes->firstWhere('code', $roomTypeCode));

        return $hotelRoomType;
    }
}
