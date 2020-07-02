<?php

namespace App\Http\Requests\AdmConvocatoria;

use Illuminate\Foundation\Http\FormRequest;

class AdmAvisoUpdateRequest extends FormRequest
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
        $convActual = request()->session()->get('convocatoria');
        return [
            'avisoTituloEdit'=> 'required|unique:aviso,titulo,0,id,id_convocatoria,'.$convActual
        ];
    }
    
    public function messages()
    {
        return [
            'avisoTituloEdit.unique' => 'El titulo ya fue registrado',
        ];
    }
}
