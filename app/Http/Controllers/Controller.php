<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function responseWithError(string $message): JsonResponse
    {
        return response()->json([
            "status" => "error",
            "message" => $message
        ]);
    }
}
