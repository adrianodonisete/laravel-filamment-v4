<?php

namespace App\Http\Requests\Store;

use App\Enums\Store\BookStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::enum(BookStatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser uma string.',
            'name.max' => 'O campo Nome não pode ter mais de 255 caracteres.',
            'author.required' => 'O campo Autor é obrigatório.',
            'author.string' => 'O campo Autor deve ser uma string.',
            'author.max' => 'O campo Autor não pode ter mais de 255 caracteres.',
            'pages.required' => 'O campo Páginas é obrigatório.',
            'pages.integer' => 'O campo Páginas deve ser um número inteiro.',
            'pages.min' => 'O campo Páginas deve ser pelo menos 1.',
            'price.required' => 'O campo Preço é obrigatório.',
            'price.decimal' => 'O campo Preço deve ser um número decimal.',
            'price.min' => 'O campo Preço deve ser pelo menos 0.',
            'description.required' => 'O campo Descrição é obrigatório.',
            'description.string' => 'O campo Descrição deve ser uma string.',
            'status.required' => 'O campo Status é obrigatório.',
            'status.enum' => 'O campo Status deve ser um valor válido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
