<?php

namespace App\Http\Controllers\Ollama;

use App\Http\Controllers\Controller;
use Cloudstudio\Ollama\Facades\Ollama;

class OllamaController extends Controller
{
    public function index()
    {
        $response = Ollama::prompt('How do I create a route in Laravel 12?')
            ->model('smollm:135m')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        return response()->json($response);
    }
}
