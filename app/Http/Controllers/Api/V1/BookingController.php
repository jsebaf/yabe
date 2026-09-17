<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct(private readonly DataService $dataService) {}

    public function store(): JsonResponse
    {
        return response()->json($this->dataService->bookings()->first(), 201);
    }
}
