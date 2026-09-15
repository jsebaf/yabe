<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function store(): JsonResponse
    {
        return response()->json([], 201);
    }
}
