<?php

namespace App\Services\Bedrock;

use App\Services\Bedrock\Exceptions\BedrockUnavailableException;
use App\Services\Ollama\ProductNameExpansionResponseParser;
use JsonException;
use Throwable;

final class BedrockBatchExpansionService
{
    public function __construct(
        private ProductNameNormalizer $normalizer,
        private ExpansionCacheService $cache,
        private BedrockGenerateClient $client,
        private ProductNameExpansionResponseParser $parser,
    ) {}

    /**
     * @param  string[]  $productNames
     * @return array<int, array<string, mixed>>
     */
    public function expandBatch(array $productNames): array
    {
        /** @var array<string, mixed> $providerConfig */
        $providerConfig = config('prism.providers.bedrock', []);
        $model = (string) $providerConfig['model'];
        $temperature = (float) ($providerConfig['expansion_temperature'] ?? 0.2);
        $chunkSize = (int) ($providerConfig['batch_size'] ?? 20);

        $results = [];

        foreach ($productNames as $originalName) {
            $normalized = $this->normalizer->normalize($originalName);
            $cached = $this->cache->get($normalized);

            if ($cached !== null) {
                $results[] = array_merge([
                    'original'   => $originalName,
                    'normalized' => $normalized,
                    'cached'     => true,
                ], $cached);
            } else {
                $results[] = [
                    'original'   => $originalName,
                    'normalized' => $normalized,
                    'cached'     => false,
                    '_pending'   => true,
                ];
            }
        }

        $pendingIndexes = array_keys(array_filter($results, fn ($r) => isset($r['_pending'])));

        foreach (array_chunk($pendingIndexes, $chunkSize) as $chunkIndexes) {
            $chunkNames = array_map(fn (int $i) => $results[$i]['normalized'], $chunkIndexes);
            $maxTokens = count($chunkNames) * 80;

            try {
                $raw = $this->client->generate(
                    $this->buildBatchPrompt($chunkNames),
                    $model,
                    ['temperature' => $temperature],
                    $maxTokens,
                );
            } catch (Throwable $e) {
                foreach ($chunkIndexes as $i) {
                    unset($results[$i]['_pending']);
                    $results[$i] = array_merge($results[$i], $this->emptyResult());
                }
                throw new BedrockUnavailableException($e->getMessage(), 0, $e);
            }

            $parsed = $this->parseBatchResponse($raw['response'] ?? '');

            foreach ($chunkIndexes as $position => $resultIndex) {
                unset($results[$resultIndex]['_pending']);

                $item = $parsed[$position] ?? null;

                if ($item !== null && is_array($item)) {
                    $expandedResult = [
                        'success'      => true,
                        'expanded_name' => trim((string) ($item['expanded_name'] ?? '')),
                        'marca'        => $item['marca'] ?? null,
                        'embalagem'    => $item['embalagem'] ?? null,
                        'medida'       => $item['medida'] ?? null,
                    ];
                } else {
                    $expandedResult = $this->emptyResult();
                }

                $results[$resultIndex] = array_merge($results[$resultIndex], $expandedResult);

                $this->cache->put(
                    $results[$resultIndex]['normalized'],
                    $expandedResult,
                );
            }
        }

        return array_values($results);
    }

    /**
     * @param  string[]  $names
     */
    private function buildBatchPrompt(array $names): string
    {
        $instructions = <<<'PROMPT'
Você expande abreviações em nomes de produtos (farmacêuticos, bebidas, alimentos, utensílios, etc.) para português claro (Brasil).
Não remover conteúdo da descrição, apenas tentar expandir as abreviações.
Obter a marca, embalagem e medida do produto.
Se não conseguir obter a marca, embalagem ou medida, retornar null nos campos de marca, embalagem e medida.

Regras:
- Não altere dosagens (mg, ml, %, etc.) nem quantidades numéricas.
- Não invente substâncias ou dados que não estejam no nome.
- Se uma abreviação for ambígua, use a forma mais comum em rótulos no Brasil ou mantenha o trecho original.
- Remover espaços duplicados e espaços em branco extras.
- Não remover pontos ou vírgulas de números.

Responda APENAS com um array JSON válido, sem markdown, sem texto antes ou depois.
Um objeto por produto, na mesma ordem da lista, no formato:
[{"expanded_name":"string","marca":"string|null","embalagem":"string|null","medida":"string|null"},...]

Exemplos de um único item:
Entrada: [Ibuprofeno 400mg 20caps EMS]
Saída: [{"expanded_name":"Ibuprofeno 400mg 20 cápsulas","marca":"EMS","embalagem":"cápsulas","medida":"400mg"}]

Lista de produtos:
PROMPT;

        $list = '';
        foreach ($names as $i => $name) {
            $list .= ($i + 1) . '. ' . $name . "\n";
        }

        return $instructions . "\n" . $list;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function parseBatchResponse(string $text): array
    {
        $trimmed = trim($text);

        if (preg_match('/^```(?:json)?\s*\R?(.*?)\R?```\s*$/s', $trimmed, $matches)) {
            $trimmed = trim($matches[1]);
        }

        $start = strpos($trimmed, '[');
        $end = strrpos($trimmed, ']');
        if ($start !== false && $end !== false && $end > $start) {
            $trimmed = substr($trimmed, $start, $end - $start + 1);
        }

        try {
            /** @var mixed $decoded */
            $decoded = json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return [];
        }

        if (! is_array($decoded)) {
            return [];
        }

        return array_values($decoded);
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyResult(): array
    {
        return [
            'success'       => false,
            'expanded_name' => '',
            'marca'         => null,
            'embalagem'     => null,
            'medida'        => null,
        ];
    }
}
