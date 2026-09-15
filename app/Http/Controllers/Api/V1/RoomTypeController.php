<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RoomTypeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([]);
    }
}
