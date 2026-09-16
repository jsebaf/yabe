<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MockDataService;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function __construct(private readonly MockDataService $mockDataService) {}

    public function index(): JsonResponse
    {
        return response()->json($this->mockDataService->hotels()->values());
    }
}
