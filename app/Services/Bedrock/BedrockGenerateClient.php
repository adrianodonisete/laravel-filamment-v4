<?php

namespace App\Services\Bedrock;

use Prism\Bedrock\Bedrock;
use Prism\Prism\Prism;
use Prism\Prism\Text\Response as TextResponse;

final class BedrockGenerateClient
{
    public function __construct(
        private Prism $prism,
    ) {}

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function generate(string $prompt, string $model, array $options): array
    {
        $temperature = (float) ($options['temperature'] ?? 0.2);

        /** @var TextResponse $response */
        $response = $this->prism->text()
            ->using(Bedrock::KEY, $model)
            ->usingTemperature($temperature)
            ->withMaxTokens(2048)
            ->withPrompt($prompt)
            ->asText();

        return [
            'response' => trim($response->text),
            'prism_response' => $response->toArray(),
        ];
    }
}
