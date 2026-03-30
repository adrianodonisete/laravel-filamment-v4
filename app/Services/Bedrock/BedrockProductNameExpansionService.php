<?php

namespace App\Services\Bedrock;

use App\Services\Bedrock\Exceptions\BedrockUnavailableException;
use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use App\Services\Ollama\ProductNameExpansionResponseParser;
use Throwable;

final class BedrockProductNameExpansionService
{
    public function __construct(
        private BedrockGenerateClient $client,
        private ProductNameExpansionResponseParser $parser,
    ) {}

    /**
     * @return array{expanded_name: string, raw: array<string, mixed>, model: string}
     */
    public function expand(string $productName): array
    {
        /** @var array<string, mixed> $providerConfig */
        $providerConfig = config('prism.providers.bedrock', []);

        $model = (string) $providerConfig['model'];
        $temperature = (float) $providerConfig['expansion_temperature'];
        $prompt = $this->buildPrompt($productName);

        try {
            $raw = $this->client->generate($prompt, $model, ['temperature' => $temperature]);
        } catch (Throwable $e) {
            throw new BedrockUnavailableException($e->getMessage(), 0, $e);
        }

        $text = $this->extractModelText($raw);
        $parsed = $this->parser->parse($text);

        return [
            'success' => $parsed['success'] ?? false,
            'expanded_name' => $parsed['expanded_name'] ?? '',
            'marca' => $parsed['marca'] ?? null,
            'embalagem' => $parsed['embalagem'] ?? null,
            'medida' => $parsed['medida'] ?? null,
            'model' => $model,
            'raw' => $raw,
        ];
    }

    private function buildPrompt(string $productName): string
    {
        $instructions = <<<'PROMPT'
Você expande abreviações em nomes de produtos (farmacêuticos e embalagem) para português claro (Brasil).
Nâo remover conteúdo da descrição, apenas tentar expandir as abreviações.
Obter a marca, embalagem e medida do produto.
Se não conseguir obter a marca, embalagem ou medida, retornar "null" nos campos de marca, embalagem e medida, conforme exemplos abaixo.

Regras:
- Não altere dosagens (mg, ml, %, etc.) nem quantidades numéricas.
- Não invente substâncias ou dados que não estejam no nome.
- Se uma abreviação for ambígua, use a forma mais comum em rótulos no Brasil ou mantenha o trecho original.
- Se o nome do produto for uma abreviação, use a forma mais comum em rótulos no Brasil ou mantenha o trecho original.
- Remover espaços duplicados e espaços em branco extras.
- Não remover pontos ou vírgulas de números.

Responda APENAS com um objeto JSON válido, sem markdown, sem texto antes ou depois. Formato exato:
{"expanded_name":"string", "marca": "string" | null, "embalagem": "string" | null, "medida": "string" | null}

Exemplos:
Entrada: Paracetamol 500mg 10cmp
Saída: {"expanded_name":"Paracetamol 500mg 10 comprimidos", "marca": null, "embalagem": "comprimidos", "medida": "500mg"}

Entrada: Ibuprofeno 400mg 20caps EMS
Saída: {"expanded_name":"Ibuprofeno 400mg 20 cápsulas", "marca": "EMS", "embalagem": "cápsulas", "medida": "400mg"}

Entrada: Vinho Chileno Tinto Concha y Toro, Cabernet Sauvignon 750ml (Garrafa)
Saída: {"expanded_name":"Vinho Chileno Tinto Concha y Toro, Cabernet Sauvignon 750ml (Garrafa)", "marca": "Concha y Toro", "embalagem": "garrafa", "medida": "750ml"}

Entrada: "- Plataformas de perfuracao ou de exploracao, (flutuantes ou submersiveis)"
Saída: {"expanded_name":"Plataformas de perfuração ou de exploração flutuantes ou submersíveis", "marca": null, "embalagem": null, "medida": null}

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

        throw new InvalidExpansionResponseException('Unexpected shape from Bedrock response.');
    }
}
