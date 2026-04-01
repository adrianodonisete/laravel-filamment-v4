<?php

namespace App\Services\Bedrock;

use App\Models\SugestaoVinculacao\SugestVincCacheCall;

final class ProductNameCacheService
{
    private const KEY_PREFIX_OTIMIZACAO = 'bedrock_otimizacao:';

    private const KEY_PREFIX_SUGESTAO = 'bedrock_sugestao:';

    /**
     * @return array<string, mixed>|null
     */
    public function get(string $productName, string $option): ?array
    {
        $row = SugestVincCacheCall::getOne(self::key($productName, $option));
        if ($row === null) {
            return null;
        }

        /** @var string|null $conteudo */
        $conteudo = $row->conteudo ?? null;

        if ($conteudo) {
            /** @var array<string, mixed>|null $decoded */
            return json_decode($conteudo, true);
        } else {
            return null;
        }
    }

    /**
     * @param  array<string, mixed>|object  $result
     */
    public function put(string $productName, array|object $result, string $option): void
    {
        SugestVincCacheCall::saveByChave(self::key($productName, $option), $result);
    }

    public function forget(string $productName, string $option): void
    {
        SugestVincCacheCall::deleteByChave(self::key($productName, $option));
    }

    public static function key(string $productName, string $option): string
    {
        $prefix = match (true) {
            $option === 'expansion', $option === 'otimizacao' => self::KEY_PREFIX_OTIMIZACAO,
            $option === 'compare', $option === 'sugestao' => self::KEY_PREFIX_SUGESTAO,
            $option === '' => 'bedrock_default:',
            default => "bedrock_{$option}:",
        };

        return $prefix.md5(mb_strtolower(trim($productName)));
    }
}
