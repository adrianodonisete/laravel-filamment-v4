<?php

namespace App\Services\Ollama;

use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use JsonException;

final class ProductNameExpansionResponseParser
{
    public function parse(string $text): array
    {
        $trimmed = trim($text);

        if (preg_match('/^```(?:json)?\s*\R?(.*?)\R?```\s*$/s', $trimmed, $matches)) {
            $trimmed = trim($matches[1]);
        }

        $start = strpos($trimmed, '{');
        $end = strrpos($trimmed, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $trimmed = substr($trimmed, $start, $end - $start + 1);
        }

        try {

            try {
                /** @var mixed $decoded */
                $decoded = json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                throw new InvalidExpansionResponseException('Model output is not valid JSON.');
            }

            if (! is_array($decoded)) {
                throw new InvalidExpansionResponseException('Missing or invalid expanded_name in model JSON.');
            }

            // $expanded = trim($decoded['expanded_name'] ?? '');
            // if ($expanded === '') {
            //     throw new InvalidExpansionResponseException('expanded_name must not be empty.');
            // }

            return [
                'success' => true,
                'expanded_name' => trim($decoded['expanded_name'] ?? ''),
                'marca' => trim($decoded['marca'] ?? ''),
                'embalagem' => trim($decoded['embalagem'] ?? ''),
                'medida' => trim($decoded['medida'] ?? ''),
            ];
        } catch (\Exception) {
            return [
                'success' => false,
                'expanded_name' => '',
                'marca' => '',
                'embalagem' => '',
                'medida' => '',
            ];
        }
    }
}
