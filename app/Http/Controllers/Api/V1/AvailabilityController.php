<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MockDataService;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    public function __construct(private readonly MockDataService $mockDataService) {}

    public function check(): JsonResponse
    {
        return response()->json($this->mockDataService->hotelRoomTypes()->values());
    }
}
