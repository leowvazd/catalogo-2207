<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //validar usuário
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //regras para os campos do formulário
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                //'unique:users,email'
                Rule::unique('users','email')->ignore($this->user, 'id')
            ],
            'password' => [
                'required',
                'min:6',
                'max:20'
            ]
        ];
    }
}
