<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function __construct(private readonly DataService $dataService) {}

    public function index(): JsonResponse
    {
        return response()->json($this->dataService->hotels()->values());
    }
}
