<?php

namespace App\Auth\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password_confirmation.same' => 'Las contraseñas no coinciden',
            'password_confirmation.required' => 'La confirmación de contraseña es requerida',
            'password_confirmation.string' => 'La confirmación de contraseña debe ser una cadena de caracteres',
            'password_confirmation.min' => 'La confirmación de contraseña debe tener al menos 8 caracteres',
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre debe tener máximo 255 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.string' => 'El correo electrónico debe ser una cadena de caracteres',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
            'email.max' => 'El correo electrónico debe tener máximo 255 caracteres',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ];
    }
} 