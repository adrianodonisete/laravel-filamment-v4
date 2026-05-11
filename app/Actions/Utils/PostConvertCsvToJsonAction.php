<?php

declare(strict_types=1);

namespace App\Actions\Utils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostConvertCsvToJsonAction
{
    /**
     * @return string
     */
    public function handle(string $csvContent): string
    {
        $csvContent = str_replace(["\r\n", "\r"], PHP_EOL, $csvContent);

        $lines = explode(PHP_EOL, $csvContent);
        $lines = array_filter($lines, fn(string $line) => trim($line) !== '');
        $lines = array_values($lines);

        if ($lines === []) {
            throw new \Exception('Sem conteúdo para processar o CSV.');
        }

        $headers = str_getcsv(array_shift($lines), ';');
        $headers = array_map(fn(string $header) => Str::slug($header, '_', 'pt_BR'), $headers);

        $content = [];
        foreach ($lines as $line) {
            $values = str_getcsv($line, ';');
            $row = [];
            foreach ($headers as $index => $header) {
                if ($header === '') {
                    continue;
                }

                $value = $values[$index] ?? null;
                $row[$header] = $value !== null && $value !== '' ? trim($value) : null;
            }
            $content[] = $row;
        }

        $data = ['data' => $content];

        $filename = 'csv-to-json-' . now('America/Sao_Paulo')->format('Y-m-d-H-i-s') . '.json';
        $path = 'utils/' . $filename;

        Storage::disk('public')->put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $path;
    }
}
