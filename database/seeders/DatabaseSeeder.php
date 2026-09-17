<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roomTypes = collect([
            ['name' => 'Standard Room', 'code' => 'STANDARD', 'maxOccupancy' => 2],
            ['name' => 'Deluxe Room', 'code' => 'DELUXE', 'maxOccupancy' => 3],
            ['name' => 'Family Suite', 'code' => 'FAMILY', 'maxOccupancy' => 4],
        ])->mapWithKeys(fn (array $data): array => [$data['code'] => RoomType::query()->create($data)]);

        $hotels = collect([
            ['name' => 'Grand Hotel', 'code' => 'GRAND'],
            ['name' => 'Seaside Resort', 'code' => 'SEASIDE'],
        ])->mapWithKeys(fn (array $data): array => [$data['code'] => Hotel::query()->create($data)]);

        collect([
            ['hotel' => 'GRAND', 'roomType' => 'STANDARD', 'quantity' => 20, 'price' => 95.00],
            ['hotel' => 'GRAND', 'roomType' => 'DELUXE', 'quantity' => 10, 'price' => 125.50],
            ['hotel' => 'GRAND', 'roomType' => 'FAMILY', 'quantity' => 4, 'price' => 180.00],
            ['hotel' => 'SEASIDE', 'roomType' => 'STANDARD', 'quantity' => 15, 'price' => 110.00],
            ['hotel' => 'SEASIDE', 'roomType' => 'DELUXE', 'quantity' => 8, 'price' => 145.00],
        ])->each(fn (array $data) => HotelRoomType::query()->create([
            'hotel_id' => $hotels[$data['hotel']]->id,
            'room_type_id' => $roomTypes[$data['roomType']]->id,
            'quantity' => $data['quantity'],
            'price' => $data['price'],
        ]));

        Booking::insert([
            ['locator' => 'ABC123', 'hotel' => 'GRAND', 'roomType' => 'DELUXE', 'paxes' => 2, 'checkin' => '2026-10-01', 'checkout' => '2026-10-05', 'status' => 'CONFIRMED'],
            ['locator' => 'DEF456', 'hotel' => 'GRAND', 'roomType' => 'STANDARD', 'paxes' => 1, 'checkin' => '2026-11-10', 'checkout' => '2026-11-12', 'status' => 'CANCELLED'],
            ['locator' => 'GHI789', 'hotel' => 'SEASIDE', 'roomType' => 'STANDARD', 'paxes' => 2, 'checkin' => '2026-12-20', 'checkout' => '2026-12-27', 'status' => 'CONFIRMED'],
        ]);
    }
}
