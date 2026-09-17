<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Support\Collection;

class DataService
{
    /** @return Collection<int, Hotel> */
    public function hotels(): Collection
    {
        return Hotel::with('roomTypes.roomType')->get();
    }

    /** @return Collection<int, RoomType> */
    public function roomTypes(): Collection
    {
        return RoomType::all();
    }

    /** @return Collection<int, HotelRoomType> */
    public function hotelRoomTypes(): Collection
    {
        return HotelRoomType::with(['hotel', 'roomType'])->get()->each(function (HotelRoomType $item): void {
            $item->setAttribute('hotel_code', $item->hotel->code);
            $item->setAttribute('room_type_code', $item->roomType->code);
        });
    }

    /** @return Collection<int, Booking> */
    public function bookings(): Collection
    {
        return Booking::all();
    }
}
