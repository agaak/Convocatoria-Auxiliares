<?php

namespace App\Http\Requests\AdmConvocatoria;

use Illuminate\Foundation\Http\FormRequest;

class AdmMeritosUpdateRequest extends FormRequest
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
        $idEva = request()->input('id-evaluador');

        return [
            'adm-cono-nombre-edit' => 'regex:/^[a-zA-Z\s]*$/',
            'adm-cono-apellidos-edit' => 'regex:/^[\pL\s\-]+$/u',
            'adm-cono-correo-edit' => 'email|unique:evaluador,correo,'.$idEva,
            'adm-cono-correo2-edit' => 'nullable|email'
        ];
    }

    public function messages()
    {
        return [
            'adm-cono-nombre-edit.regex' => 'El campo Nombre solo permite letras y espacios en blanco.',
            'adm-cono-apellidos-edit.regex' => 'El campo Apellidos solo permite letras y espacios en blanco.',
            'adm-cono-correo-edit.unique' => 'El correo ingresado ya existe.', 
            'adm-cono-correo-edit.email' => 'El campo correo debe ser de tipo email.',
            'adm-cono-correo2-edit.email' => 'El campo correo debe ser de tipo email.'
        ];
    }
}
