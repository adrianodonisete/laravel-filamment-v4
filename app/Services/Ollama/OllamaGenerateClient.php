<?php

namespace App\Services\Ollama;

use Cloudstudio\Ollama\Facades\Ollama;

final class OllamaGenerateClient
{
    /**
     * @return array<string, mixed>
     */
    public function generate(string $prompt, string $model, array $options): array
    {
        // agent('Você é especialista em expandir nomes de produtos para português claro (Brasil).')
        // ->

        $result = Ollama::prompt($prompt)
            ->model($model)
            ->options($options)
            ->stream(false)
            ->ask();

        if (is_array($result)) {
            return $result;
        }

        if (is_string($result)) {
            return ['response' => $result];
        }

        return ['response' => json_encode($result)];
    }
}
