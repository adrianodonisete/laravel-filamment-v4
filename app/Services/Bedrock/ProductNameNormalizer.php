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
        'compr'         => 'comprimidos',
        'comp'          => 'comprimidos',
        'cmp'           => 'comprimidos',
        'comps'         => 'comprimidos',
        'comprimido'    => 'comprimidos',
        'capsulas'      => 'cápsulas',
        'capsula'       => 'cápsulas',
        'caps'          => 'cápsulas',
        'cap'           => 'cápsulas',
        'capsula'       => 'cápsulas',
        'drg'           => 'drágeas',
        'drag'          => 'drágeas',
        'tab'           => 'tabletes',
        'tabs'          => 'tabletes',
        'tablete'      => 'tabletes',
        'susp'          => 'suspensão',
        'sus'           => 'suspensão',
        'sol'           => 'solução',
        'soln'          => 'solução',
        'pomadas'       => 'pomada',
        'pom'           => 'pomada',
        'crem'          => 'creme',
        'col'           => 'colírio',
        'amp'           => 'ampola',
        'amps'          => 'ampolas',
        'sach'          => 'sachê',
        'sachs'         => 'sachês',
        'env'           => 'envelope',
        'envs'          => 'envelopes',
        'bisnaga'       => 'bisnagas',

        // Embalagens gerais
        'fco'  => 'frascos',
        'fr'   => 'frascos',
        'frs'  => 'frascos',
        'frasco' => 'frascos',
        'cx'   => 'caixas',
        'cxa'  => 'caixas',
        'lata' => 'latas',
        'pct'  => 'pacotes',
        'pcts' => 'pacotes',
        'pkg'  => 'pacotes',
        'bg'   => 'bolsas',
        'bgs'  => 'bolsas',
        'gf'   => 'garrafa',
        'gar'  => 'garrafa',
        'lt'   => 'lata',
        'lts'  => 'latas',
        'tp'   => 'tubo',
        'tbs'  => 'tubos',
        'bidon'   => 'bidão',
        'garraf'  => 'garrafa',
        'garrafs' => 'garrafas',

        // Unidades de medida e posologia
        'mcg'  => 'mcg',
        'ui'   => 'UI',
        'un'   => 'unidade',
        'uns'  => 'unidades',
        'unid' => 'unidade',
        'unids' => 'unidades',

        // Vias e formas de uso
        'inj'  => 'injetável',
        'oral' => 'oral',
        'topi' => 'tópico',
        'oftal' => 'oftálmico',
        'nas'  => 'nasal',
    ];

    public function normalize(string $name): string
    {
        $result = $name;

        foreach (self::DICTIONARY as $abbreviation => $expansion) {
            $pattern = '/\b' . preg_quote($abbreviation, '/') . '\b/iu';
            $result = preg_replace($pattern, $expansion, $result) ?? $result;
        }

        return (string) preg_replace('/\s{2,}/', ' ', trim($result));
    }
}
