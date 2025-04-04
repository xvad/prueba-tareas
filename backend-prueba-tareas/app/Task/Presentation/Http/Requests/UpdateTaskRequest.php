<?php

namespace App\Task\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'state' => 'required|string|in:pendiente,en_progreso,completada'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es requerido',
            'title.string' => 'El título debe ser texto',
            'title.max' => 'El título no puede exceder los 255 caracteres',
            'description.required' => 'La descripción es requerida',
            'description.string' => 'La descripción debe ser texto',
            'state.required' => 'El estado es requerido',
            'state.string' => 'El estado debe ser texto',
            'state.in' => 'El estado debe ser: pendiente, en_progreso o completada'
        ];
    }
} 