<?php

namespace App\Http\Requests\Glpi;

use Illuminate\Foundation\Http\FormRequest;

class CreateControleGlpiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_ticket' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'date_creation' => ['nullable', 'date'],
            'date_mod' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
            'proj' => ['nullable', 'string', 'max:255'],
            'jira' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'integer'],
            'priority_order' => ['nullable', 'integer'],
            'priority_number' => ['nullable', 'numeric', 'decimal:0,6'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_ticket.required' => 'O campo Ticket é obrigatório.',
            'name.required' => 'O campo Nome é obrigatório.',
            'status.required' => 'O campo Status é obrigatório.',
        ];
    }
}
