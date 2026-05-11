<?php

declare(strict_types=1);

namespace App\Actions\Utils;

class PostConvertCsvToJsonAction
{
    /**
     * @return array<string, mixed>
     */
    public function execute(string $csvContent): array
    {
        $csvContent = str_replace(["\r\n", "\r"], "\n", $csvContent);

        $lines = explode("\n", $csvContent);
        $lines = array_filter($lines, fn (string $line) => trim($line) !== '');
        $lines = array_values($lines);

        if ($lines === []) {
            return ['data' => []];
        }

        $headers = str_getcsv(array_shift($lines));

        $data = [];
        foreach ($lines as $line) {
            $values = str_getcsv($line);
            $row = [];
            foreach ($headers as $index => $header) {
                $header = trim($header);
                if ($header === '') {
                    continue;
                }

                $value = $values[$index] ?? null;
                $row[$header] = $value !== null && $value !== '' ? $value : null;
            }
            $data[] = $row;
        }

        return ['data' => $data];
    }
}
