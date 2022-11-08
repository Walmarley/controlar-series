<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerieFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'min:3']
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'nome.required' => 'O Campo nome é obrigatorio',
    //         'nome.min' => 'O Campo nome precisa de ao menos :min caracteres'
    //     ];
    // }
}
