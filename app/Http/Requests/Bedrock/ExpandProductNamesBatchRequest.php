<?php

namespace App\Http\Requests\Bedrock;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExpandProductNamesBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'product_names'   => ['required', 'array', 'min:1', 'max:200'],
            'product_names.*' => ['required', 'string', 'max:512'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_names.required' => 'O campo lista de produtos é obrigatório.',
            'product_names.array'    => 'O campo lista de produtos deve ser um array.',
            'product_names.min'      => 'A lista deve conter pelo menos 1 produto.',
            'product_names.max'      => 'A lista não pode conter mais de 200 produtos.',
            'product_names.*.required' => 'Cada produto deve ser uma string não vazia.',
            'product_names.*.string'   => 'Cada produto deve ser uma string.',
            'product_names.*.max'      => 'Cada produto não pode ter mais de 512 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
