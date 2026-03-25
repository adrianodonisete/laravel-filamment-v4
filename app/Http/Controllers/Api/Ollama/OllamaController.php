<?php

namespace App\Http\Controllers\Api\Ollama;

use App\Http\Controllers\Controller;
use Cloudstudio\Ollama\Facades\Ollama;

class OllamaController extends Controller
{
    public function index()
    {
        $response = Ollama::prompt('How to check route list in Laravel 12?')
            ->model('qwen:0.5b')
            ->options(['temperature' => 0.5])
            ->stream(false)
            ->ask();

        // $response = [
        //     'message' => 'Hello, how can I assist you today?',
        // ];

        return response()->json($response);
    }
}
