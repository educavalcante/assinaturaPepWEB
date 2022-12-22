<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArquivoRequest extends FormRequest
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

    public function messages()
    {
        return[
            'idDoc.required' => 'Informe o documento',
            'justificativa.required' => 'Preencha a justificativa',
            'justificativa.max' => 'justificativa deve ter no maximo 250 caracteres'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idDoc' => 'required',
            'justificativa' => 'required|max:250'
        ];
    }
}
