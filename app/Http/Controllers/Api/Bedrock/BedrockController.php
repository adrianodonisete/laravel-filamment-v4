<?php

namespace App\Http\Controllers\Api\Bedrock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ollama\ExpandProductNameRequest;
use App\Services\Bedrock\BedrockProductNameExpansionService;
use App\Services\Bedrock\Exceptions\BedrockUnavailableException;
use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use Illuminate\Http\JsonResponse;

class BedrockController extends Controller
{
    public function expandProductName(
        ExpandProductNameRequest $request,
        BedrockProductNameExpansionService $expansionService,
    ): JsonResponse {
        $productName = $request->validated('product_name');

        try {
            $result = $expansionService->expand($productName);
        } catch (BedrockUnavailableException $e) {
            return response()->json([
                'message' => 'O serviço de IA não está disponível. Tente novamente.',
                'error' => $e->getMessage(),
            ], 502);
        } catch (InvalidExpansionResponseException $e) {
            return response()->json([
                'message' => 'Não foi possível interpretar a resposta do modelo.',
                'error' => $e->getMessage(),
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
