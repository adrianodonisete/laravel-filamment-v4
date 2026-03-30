<?php

namespace App\Http\Controllers\Api\Bedrock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedrock\ExpandProductNamesBatchRequest;
use App\Http\Requests\Ollama\ExpandProductNameRequest;
use App\Services\Bedrock\BedrockBatchExpansionService;
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
            'result' => $result,
        ];

        if (config('app.debug')) {
            $payload['raw'] = $result['raw'];
            $payload['model'] = config('prism.providers.bedrock.model');
            $payload['region'] = config('prism.providers.bedrock.region');
        }

        return response()->json($payload);
    }

    public function expandProductNamesBatch(
        ExpandProductNamesBatchRequest $request,
        BedrockBatchExpansionService $batchService,
    ): JsonResponse {
        $productNames = $request->validated('product_names');

        try {
            $results = $batchService->expandBatch($productNames);
        } catch (BedrockUnavailableException $e) {
            return response()->json([
                'message' => 'O serviço de IA não está disponível. Tente novamente.',
                'error' => $e->getMessage(),
            ], 502);
        }

        $fromCache = count(array_filter($results, fn ($r) => $r['cached'] === true));
        $fromModel = count($results) - $fromCache;

        return response()->json([
            'results'    => $results,
            'total'      => count($results),
            'from_cache' => $fromCache,
            'from_model' => $fromModel,
        ]);
    }

    public function testProfile(): JsonResponse
    {
        return response()->json([
            'message' => 'Profile test',
            'env' => [
                'AWS_USE_DEFAULT_CREDENTIAL_PROVIDER' => env('AWS_USE_DEFAULT_CREDENTIAL_PROVIDER'),
                'AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID'),
                'AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY'),
                'AWS_REGION' => env('AWS_REGION'),
                'AWS_BEDROCK_EXPANSION_TEMPERATURE' => env('AWS_BEDROCK_EXPANSION_TEMPERATURE'),
                'AWS_BEDROCK_MODEL' => env('AWS_BEDROCK_MODEL'),
            ],
            'config' => [
                'AWS_USE_DEFAULT_CREDENTIAL_PROVIDER' => config('prism.providers.bedrock.use_default_credential_provider'),
                'AWS_ACCESS_KEY_ID' => config('prism.providers.bedrock.api_key'),
                'AWS_SECRET_ACCESS_KEY' => config('prism.providers.bedrock.api_secret'),
                'AWS_REGION' => config('prism.providers.bedrock.region'),
                'AWS_BEDROCK_EXPANSION_TEMPERATURE' => config('prism.providers.bedrock.expansion_temperature'),
                'AWS_BEDROCK_MODEL' => config('prism.providers.bedrock.model'),
            ],
        ]);
    }
}
