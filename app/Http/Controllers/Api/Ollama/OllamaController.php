<?php

namespace App\Http\Controllers\Api\Ollama;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ollama\ExpandProductNameRequest;
use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use App\Services\Ollama\Exceptions\OllamaUnavailableException;
use App\Services\Ollama\ProductNameExpansionService;
use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OllamaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'nullable|string',
        ]);

        $prompt = $request->input('prompt', 'How to check route list in Laravel 12?');

        $model = (string) config('ollama-laravel.model');
        $temperature = (float) config('ollama-laravel.chat_temperature', 0.5);

        $response = Ollama::prompt($prompt)
            ->model($model)
            ->options(['temperature' => $temperature])
            ->stream(false)
            ->ask();

        return response()->json($response);
    }

    public function expandProductName(
        ExpandProductNameRequest $request,
        ProductNameExpansionService $expansionService
    ): JsonResponse {
        $productName = $request->validated('product_name');

        try {
            $result = $expansionService->expand($productName);
        } catch (OllamaUnavailableException) {
            return response()->json([
                'message' => 'O serviço de IA não está disponível. Tente novamente.',
            ], 502);
        } catch (InvalidExpansionResponseException) {
            return response()->json([
                'message' => 'Não foi possível interpretar a resposta do modelo.',
            ], 422);
        }

        $payload = [
            'original' => $productName,
            'expanded_name' => $result['expanded_name'],
            'model' => $result['model'],
        ];

        if (config('app.debug')) {
            $payload['raw'] = $result['raw'];
        }

        return response()->json($payload);
    }
}
