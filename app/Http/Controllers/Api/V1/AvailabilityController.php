<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function __construct(private readonly DataService $dataService) {}

    public function check(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'hotel' => ['sometimes', 'string'],
            'roomType' => ['sometimes', 'string'],
            'paxes' => ['required', 'integer', 'min:1'],
            'checkin' => ['required', 'date_format:Y-m-d'],
            'checkout' => ['required', 'date_format:Y-m-d', 'after:checkin'],
        ]);

        $checkin = $validated['checkin'];
        $checkout = $validated['checkout'];

        $available = $this->dataService->hotelRoomTypes()
            ->filter(function ($hotelRoomType) use ($validated, $checkin, $checkout): bool {
                $roomType = $hotelRoomType->roomType;

                if ($roomType->maxOccupancy < $validated['paxes']) {
                    return false;
                }

                if (isset($validated['hotel']) && $hotelRoomType->hotel_code !== $validated['hotel']) {
                    return false;
                }

                if (isset($validated['roomType']) && $hotelRoomType->room_type_code !== $validated['roomType']) {
                    return false;
                }

                $bookings = $this->dataService->bookings()
                    ->where('hotel', $hotelRoomType->hotel_code)
                    ->where('roomType', $hotelRoomType->room_type_code)
                    ->where('status', 'CONFIRMED')
                    ->filter(fn ($booking): bool => $booking->checkin->format('Y-m-d') < $checkout
                        && $booking->checkout->format('Y-m-d') > $checkin);

                return $bookings->count() < $hotelRoomType->quantity;
            })
            ->map(fn ($hotelRoomType): array => [
                'hotel' => $hotelRoomType->hotel,
                'roomType' => $hotelRoomType->roomType,
                'price' => $hotelRoomType->price,
            ])
            ->values();

        return response()->json($available);
    }
}
