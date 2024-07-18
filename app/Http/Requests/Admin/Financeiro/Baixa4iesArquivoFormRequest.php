<?php

namespace App\Http\Requests\Admin\Financeiro;

use Illuminate\Foundation\Http\FormRequest;

class Baixa4iesArquivoFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */    
    public function messages()
    {
        return [
            'file.required' => 'Um arquivo deverá ser escolhido!',
        ];
    }
}
