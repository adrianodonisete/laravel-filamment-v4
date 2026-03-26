<?php

namespace App\Http\Controllers\Api\OpenAI;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Responses\CreateResponse;

class OpenAIController
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt', 'Hello!');

        $response = OpenAI::responses()->create([
            'model' => 'gpt-5-mini',
            'input' => $prompt,
        ]);

        return response()->json($response->outputText);
    }

    public function fake(): JsonResponse
    {
        // Setup a fake response for OpenAI API.
        // This intercepts OpenAI::responses() calls and returns the provided fake data.
        $response = OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'text' => 'awesome!',
                        'query' => 'PHP is ',
                    ],
                ],
            ]),
        ])
            ->responses()
            ->create([
                'model' => 'gpt-5',
                'input' => 'PHP is ',
            ]);

        return response()->json($response);
    }
}
