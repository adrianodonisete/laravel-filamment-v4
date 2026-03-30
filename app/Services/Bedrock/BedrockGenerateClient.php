<?php

namespace App\Services\Bedrock;

use Prism\Bedrock\Bedrock;
use Prism\Prism\Prism;
use Prism\Prism\Text\PendingRequest;
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
    public function generate(string $prompt, string $model, array $options, ?int $maxTokens = null): array
    {
        $temperature = (float) ($options['temperature'] ?? 0.2);

        /** @var PendingRequest $pending */
        $pending = $this->prism->text()
            ->using(Bedrock::KEY, $model)
            ->usingTemperature($temperature)
            ->withPrompt($prompt);

        if ($maxTokens !== null) {
            $pending = $pending->withMaxTokens($maxTokens);
        }

        /** @var TextResponse $response */
        $response = $pending->asText();

        return [
            'response' => trim($response->text),
        ];
    }
}
