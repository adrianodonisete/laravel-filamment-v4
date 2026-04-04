<?php

namespace App\Http\Controllers\Api\Ollama;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LlmController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Hello World',
        ]);
    }
}
