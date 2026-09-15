<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:300',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Selecione uma imagem.',
            'image.image' => 'O arquivo enviado não é uma imagem válida.',
            'image.mimes' => 'A imagem deve ser JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'A imagem não pode exceder 300 KB.',
        ];
    }
}
