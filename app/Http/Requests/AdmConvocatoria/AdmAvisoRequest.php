<?php

namespace App\Http\Requests\AdmConvocatoria;

use Illuminate\Foundation\Http\FormRequest;

class AdmAvisoRequest extends FormRequest
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
            'avisoTitulo'=> 'required|unique:aviso,titulo_aviso,0,id,id_convocatoria,'.$convActual
        ];
    }
    
    public function messages()
    {
        return [
            'avisoTitulo.unique' => 'El titulo ya fue registrado',
        ];
    }
}
