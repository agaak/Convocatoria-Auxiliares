<?php

namespace App\Http\Requests\AdmConvocatoria;

use Illuminate\Foundation\Http\FormRequest;

class AdmMeritosRequest extends FormRequest
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
            'adm-meritos-ci' => 'required|min:4|max:10|unique:evaluador_conocimientos,ci',
            'adm-meritos-nombre' => 'required|regex:/^[a-zA-Z\s]*$/',
            'adm-meritos-apellidos' => 'required|regex:/^[\pL\s\-]+$/u',
            'adm-meritos-correo' => 'required|email|unique:evaluador_conocimientos,correo',
            // 'adm-meritos-correo-alter' => 'required|email|unique:evaluador_conocimientos,correo'
        ];
    }

    public function messages()
    {
        return [
            'adm-meritos-ci.min' => 'El campo CI contiene como minimo 4 carácteres.',
            'adm-meritos-ci.max' => 'El campo CI contiene como maximo 10 carácteres.',
            'adm-meritos-ci.unique' => 'El numero de carnet de identidad ingresado ya existe.',
            'adm-meritos-nombre.regex' => 'El campo Nombre solo permite letras y espacios en blanco.',
            'adm-meritos-apellidos.regex' => 'El campo Apellidos solo permite letras y espacios en blanco.',
            'adm-meritos-correo.unique' => 'El correo ingresado ya existe.',
            'adm-meritos-correo.email' => 'El campo correo debe ser de tipo email.',
            // 'adm-meritos-correo-alter.email' => 'El campo correo debe ser de tipo email.'
        ];
    }
}
