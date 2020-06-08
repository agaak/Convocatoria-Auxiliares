<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvocatoriaRequest extends FormRequest
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
        $time = strtotime("-1 year", time());
        $fecha = date("Y-m-d", $time);
        return [
            'conv-titulo' => 'required',
            'conv-fecha-ini' => 'required|before_or_equal:conv-fecha-fin|after_or_equal:'.$fecha,
            'conv-fecha-fin' => 'required',
            'conv-tipo' => 'required',
            'conv-gestion' => 'required',
            'conv-gestion' => 'required',
            'conv-descripcion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'conv-fecha-ini.required' => 'El campo Fecha Inicio es obligatorio.',
            'conv-fecha-fin.required' => 'El campo Fecha Final es obligatorio.',
            'conv-fecha-ini.before_or_equal' => 'La Fecha Inicio debe ser una fecha anterior o igual a la Fecha Final.',
            'conv-fecha-ini.after_or_equal' => 'La Fecha Inicio debe ser una fecha posterior o igual a :date.'
        ];
    }
}
