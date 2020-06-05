<?php

namespace App\Http\Requests\AdmConvocatoria;

use Illuminate\Foundation\Http\FormRequest;

class AdmConocimientosRequest extends FormRequest
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
            'adm-cono-tipo' => 'required',
            'adm-cono-ci' => 'min:4|unique:evaluador,ci',
            'adm-cono-nombre' => 'regex:/^[a-zA-Z\s]*$/',
            'adm-cono-apellidos' => 'regex:/^[\pL\s\-]+$/u',
            'adm-cono-correo' => 'email|unique:evaluador,correo'
        ];
    }

    public function messages()
    {
        return [
            'adm-cono-tipo.required' => 'Este Campo es requerido.', 
            'adm-cono-ci.min' => 'El campo CI contiene como minimo 4 carácteres.',
            'adm-cono-ci.unique' => 'El dato ingresado ya existe.',
            'adm-cono-nombre.regex' => 'El campo Nombre solo permite letras y espacios en blanco.',
            'adm-cono-apellidos.regex' => 'El campo Apellidos solo permite letras y espacios en blanco.',
            'adm-cono-correo.unique' => 'El dato ingresado ya existe.',
            'adm-cono-correo.email' => 'El campo correo debe ser de tipo email.'
        ];
    }
}
