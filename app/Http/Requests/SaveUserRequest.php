<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        $Id = $this->route('id');

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $Id,
            'numero_celular' => 'nullable|digits:10',
            'cedula' => 'required|string|max:11|unique:users,cedula,' . $Id,
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'codigo_ciudad' => 'required|numeric',
        ];

        // Si es una actualización, no requerimos la contraseña
        if ($this->isMethod('put')) {
            unset($rules['password']);
        }

        // Agrega reglas específicas para la creación
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }
}
