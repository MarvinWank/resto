<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    abstract public function handle(Request  $request): JsonResponse;

    protected function respondWithSuccess(array  $data = []): JsonResponse
    {
        $data['status'] = "ok";
        return response()->json($data);
    }

    protected function responseWithError(string $message): JsonResponse
    {
        return response()->json([
            "status" => "error",
            "message" => $message
        ]);
    }
}
