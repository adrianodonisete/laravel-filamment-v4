<?php

namespace App\Services\Ollama;

use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use App\Services\Ollama\Exceptions\OllamaUnavailableException;
use Throwable;

final class ProductNameExpansionService
{
    public function __construct(
        private OllamaGenerateClient $client,
        private ProductNameExpansionResponseParser $parser,
    ) {}

    /**
     * @return array{expanded_name: string, raw: array<string, mixed>, model: string}
     */
    public function expand(string $productName): array
    {
        $model = 'qwen:0.5b';
        $temperature = 0.8;
        $prompt = $this->buildPrompt($productName);

        try {
            $raw = $this->client->generate($prompt, $model, ['temperature' => $temperature]);
        } catch (Throwable $e) {
            throw new OllamaUnavailableException($e->getMessage(), 0, $e);
        }

        $text = $this->extractModelText($raw);
        $expandedName = $this->parser->parse($text);

        return [
            'expanded_name' => $expandedName,
            'raw' => $raw,
            'model' => $model,
        ];
    }

    private function buildPrompt(string $productName): string
    {
        $instructions = <<<'PROMPT'
Você expande abreviações em nomes de produtos (farmacêuticos e embalagem) para português claro (Brasil).

Regras:
- Não altere dosagens (mg, ml, %, etc.) nem quantidades numéricas.
- Não invente substâncias ou dados que não estejam no nome.
- Se uma abreviação for ambígua, use a forma mais comum em rótulos no Brasil ou mantenha o trecho original.
- Se o nome do produto for uma abreviação, use a forma mais comum em rótulos no Brasil ou mantenha o trecho original.
- Substitua hífens, parênteses, colchetes, aspas ou chaves por espaços 
- Não remover o conteúdo entre parênteses, colchetes, aspas ou chaves.
- Remover espaços duplicados e espaços em branco extras.
- Não remover pontos ou vírgulas de números.

Responda APENAS com um objeto JSON válido, sem markdown, sem texto antes ou depois. Formato exato:
{"expanded_name":"string"}

Exemplos:
Entrada: Paracetamol 500mg 10cmp
Saída: {"expanded_name":"Paracetamol 500mg 10 comprimidos"}

Entrada: Ibuprofeno 400mg 20caps
Saída: {"expanded_name":"Ibuprofeno 400mg 20 cápsulas"}

Entrada: "- Plataformas de perfuracao ou de exploracao, (flutuantes ou submersiveis)"
Saída: {"expanded_name":"Plataformas de perfuração ou de exploração flutuantes ou submersíveis"}

Nome do produto:
PROMPT;

        return $instructions . $productName;
    }

    /**
     * @param  array<string, mixed>  $raw
     *
     * @throws InvalidExpansionResponseException
     */
    private function extractModelText(array $raw): string
    {
        if (isset($raw['response']) && is_string($raw['response'])) {
            return trim($raw['response']);
        }

        if (isset($raw['message']['content']) && is_string($raw['message']['content'])) {
            return trim($raw['message']['content']);
        }

        throw new InvalidExpansionResponseException('Unexpected shape from Ollama response.');
    }
}
