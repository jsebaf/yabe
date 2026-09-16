<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MockDataService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct(private readonly MockDataService $mockDataService) {}

    public function store(): JsonResponse
    {
        return response()->json($this->mockDataService->bookings()->first(), 201);
    }
}
