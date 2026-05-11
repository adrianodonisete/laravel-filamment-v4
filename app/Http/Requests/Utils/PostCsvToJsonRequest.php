<?php

declare(strict_types=1);

namespace App\Http\Requests\Utils;

use Illuminate\Foundation\Http\FormRequest;

class PostCsvToJsonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'csv' => ['nullable', 'file', 'mimes:csv', 'max:2048'],
            'csv_text' => ['nullable', 'string', 'max:2048'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $hasFile = $this->hasFile('csv');
            $hasText = $this->filled('csv_text');

            if (! $hasFile && ! $hasText) {
                $validator->errors()->add('csv', 'Você deve enviar um arquivo CSV ou colar o conteúdo CSV.');
                $validator->errors()->add('csv_text', 'Você deve enviar um arquivo CSV ou colar o conteúdo CSV.');
            }

            if ($hasFile && $hasText) {
                $validator->errors()->add('csv', 'Envie apenas um arquivo CSV ou cole o conteúdo, não ambos.');
                $validator->errors()->add('csv_text', 'Envie apenas um arquivo CSV ou cole o conteúdo, não ambos.');
            }
        });
    }
}
