<?php

namespace App\Services\Bedrock;

final class ProductNameNormalizer
{
    /**
     * Abreviações triviais PT-BR ordenadas da mais específica para a mais genérica
     * para evitar substituições parciais incorretas.
     *
     * @var array<string, string>
     */
    private const DICTIONARY = [
        // Formas farmacêuticas — embalagem/unidade
        'compr' => 'comprimidos',
        'comp' => 'comprimidos',
        'cmp' => 'comprimidos',
        'comps' => 'comprimidos',
        'comprimido' => 'comprimidos',
        'capsulas' => 'cápsulas',
        'capsula' => 'cápsulas',
        'cápsula' => 'cápsulas',
        'caps' => 'cápsulas',
        'cap' => 'cápsulas',
        'drg' => 'drágeas',
        'drag' => 'drágeas',
        'tab' => 'tabletes',
        'tabs' => 'tabletes',
        'tablete' => 'tabletes',
        'susp' => 'suspensão',
        'sus' => 'suspensão',
        'suspensao' => 'suspensão',
        'sol' => 'solução',
        'soln' => 'solução',
        'pomadas' => 'pomada',
        'pom' => 'pomada',
        'crem' => 'creme',
        'col' => 'colírio',
        'amp' => 'ampolas',
        'amps' => 'ampolas',
        'ampola' => 'ampolas',
        'sach' => 'sachês',
        'sachs' => 'sachês',
        'sache' => 'sachês',
        'sachê' => 'sachês',
        'env' => 'envelopes',
        'envs' => 'envelopes',
        'envelope' => 'envelopes',
        'bisnaga' => 'bisnagas',

        // Embalagens gerais
        'fco' => 'frascos',
        'fr' => 'frascos',
        'frs' => 'frascos',
        'frasco' => 'frascos',
        'cx' => 'caixas',
        'cxa' => 'caixas',
        'lata' => 'latas',
        'pct' => 'pacotes',
        'pcts' => 'pacotes',
        'pkg' => 'pacotes',
        'bg' => 'bolsas',
        'bgs' => 'bolsas',
        'gf' => 'garrafa',
        'gar' => 'garrafa',
        'lt' => 'lata',
        'lts' => 'latas',
        'tp' => 'tubo',
        'tbs' => 'tubos',
        'bidon' => 'bidão',
        'garraf' => 'garrafa',
        'garrafs' => 'garrafas',

        // Unidades de medida e posologia
        'mcg' => 'mcg',
        'ui' => 'UI',
        'un' => 'unidade',
        'uns' => 'unidades',
        'unid' => 'unidade',
        'unids' => 'unidades',

        // Vias e formas de uso
        'inj' => 'injetável',
        'oral' => 'oral',
        'topi' => 'tópico',
        'oftal' => 'oftálmico',
        'nas' => 'nasal',
    ];

    public static function normalize(string $result): string
    {
        foreach (self::DICTIONARY as $abbreviation => $expansion) {
            $pattern = '/\b' . preg_quote($abbreviation, '/') . '\b/iu';
            $result = preg_replace($pattern, $expansion, $result) ?? $result;
        }

        $result = str_replace(["\r\n", "\r", "\n", "\t", PHP_EOL], ' ', $result);

        return (string) preg_replace('/\s{2,}/', ' ', trim($result));
    }

    /**
     * Converte a string para lowercase e remove todos os caracteres especiais do português brasileiro.
     *
     * Exemplos:
     *  "Você" -> "voce"
     *  "Meu Coração está batendo!" -> "meu coracao esta batendo"
     */
    public static function toLowerNoAccents(string $value): string
    {
        // Substitui acentos
        $normalized = strtr(
            $value,
            [
                'á' => 'a',
                'à' => 'a',
                'ã' => 'a',
                'â' => 'a',
                'ä' => 'a',
                'Á' => 'a',
                'À' => 'a',
                'Ã' => 'a',
                'Â' => 'a',
                'Ä' => 'a',
                'é' => 'e',
                'è' => 'e',
                'ê' => 'e',
                'ë' => 'e',
                'É' => 'e',
                'È' => 'e',
                'Ê' => 'e',
                'Ë' => 'e',
                'í' => 'i',
                'ì' => 'i',
                'î' => 'i',
                'ï' => 'i',
                'Í' => 'i',
                'Ì' => 'i',
                'Î' => 'i',
                'Ï' => 'i',
                'ó' => 'o',
                'ò' => 'o',
                'õ' => 'o',
                'ô' => 'o',
                'ö' => 'o',
                'Ó' => 'o',
                'Ò' => 'o',
                'Õ' => 'o',
                'Ô' => 'o',
                'Ö' => 'o',
                'ú' => 'u',
                'ù' => 'u',
                'û' => 'u',
                'ü' => 'u',
                'Ú' => 'u',
                'Ù' => 'u',
                'Û' => 'u',
                'Ü' => 'u',
                'ç' => 'c',
                'Ç' => 'c',
            ]
        );

        // Converte para lowercase
        $normalized = mb_strtolower($normalized, 'UTF-8');

        // Remove qualquer caractere não alfanumérico ou espaço
        $normalized = preg_replace('/[^a-z0-9 ]+/u', '', $normalized) ?? $normalized;

        // Remove espaços múltiplos
        return preg_replace('/\s{2,}/', ' ', trim($normalized)) ?? $normalized;
    }

    public static function similarityScore(string $a, string $b): float
    {
        $aNorm = self::toLowerNoAccents($a);
        $bNorm = self::toLowerNoAccents($b);

        if ($aNorm === $bNorm) {
            return 10.0;
        }

        // If either string is empty after normalization, return 0.
        if ($aNorm === '' || $bNorm === '') {
            return 0.0;
        }

        // Calculate the length of the longest common subsequence (LCS)
        $lcs = self::longestCommonSubsequence($aNorm, $bNorm);
        $maxLen = max(mb_strlen($aNorm), mb_strlen($bNorm));
        $minLen = min(mb_strlen($aNorm), mb_strlen($bNorm));

        // If there are no common letters, similarity is 0
        if ($lcs === 0) {
            return 0.0;
        }

        // Similarity calculation:
        // base = (lcs / maxLen)
        // multiply by a weight if the size difference is significant
        $base = $lcs / $maxLen;

        // Reward if minLen/maxLen is high (closer in length), penalize if not
        $lengthRatio = $minLen / $maxLen;

        // Further adjust to return a value between 0 and 10, and reward high base
        $score = $base * $lengthRatio * 10.0;

        // For cases like "garrafa" vs. "garrafas" (one is almost the other)
        if (
            (str_starts_with($aNorm, $bNorm) && abs(mb_strlen($aNorm) - mb_strlen($bNorm)) === 1) ||
            (str_starts_with($bNorm, $aNorm) && abs(mb_strlen($aNorm) - mb_strlen($bNorm)) === 1)
        ) {
            $score = max($score, 9.1);
        }

        // Cap at 10, round to two decimals for clarity
        return round(min(10.0, $score), 2);
    }

    private static function longestCommonSubsequence(string $a, string $b): int
    {
        $m = mb_strlen($a);
        $n = mb_strlen($b);

        // Create DP table
        $dp = array_fill(0, $m + 1, array_fill(0, $n + 1, 0));

        for ($i = 1; $i <= $m; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                if (mb_substr($a, $i - 1, 1) === mb_substr($b, $j - 1, 1)) {
                    $dp[$i][$j] = $dp[$i - 1][$j - 1] + 1;
                } else {
                    $dp[$i][$j] = max($dp[$i - 1][$j], $dp[$i][$j - 1]);
                }
            }
        }

        return $dp[$m][$n];
    }
}
