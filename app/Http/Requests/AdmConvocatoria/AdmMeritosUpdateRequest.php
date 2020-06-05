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
        return [
            'adm-meritos-ci-edit' => 'required|min:4|max:10|unique:evaluador_conocimientos,ci',
            'adm-meritos-nombre-edit' => 'required|regex:/^[a-zA-Z\s]*$/',
            'adm-meritos-apellidos-edit' => 'required|regex:/^[\pL\s\-]+$/u',
            // 'adm-meritos-correo-edit' => 'required|email|unique:evaluador_conocimientos,correo',
            'adm-meritos-correo-edit' => 'required|email',
            // 'adm-meritos-correo-alter' => 'required|email|unique:evaluador_conocimientos,correo'
        ];
    }

    public function messages()
    {
        return [
            'adm-meritos-ci-edit.min' => 'El campo CI contiene como minimo 4 carácteres.',
            'adm-meritos-ci-edit.max' => 'El campo CI contiene como maximo 10 carácteres.',
            'adm-meritos-ci-edit.unique' => 'El numero de carnet de identidad ingresado ya existe.',
            'adm-meritos-nombre-edit.regex' => 'El campo Nombre solo permite letras y espacios en blanco.',
            'adm-meritos-apellidos-edit.regex' => 'El campo Apellidos solo permite letras y espacios en blanco.',
            // 'adm-meritos-correo-edit.unique' => 'El correo ingresado ya existe.',
            'adm-meritos-correo-edit.email' => 'El campo correo debe ser de tipo email.',
            // 'adm-meritos-correo-alter.email' => 'El campo correo debe ser de tipo email.'
        ];
    }
}
