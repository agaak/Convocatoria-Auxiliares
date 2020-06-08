<?php

namespace App\Http\Requests;

use App\Merito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidacionPersonal;

class MeritoRequest extends FormRequest
{
    function __construct(ValidacionPersonal $validacion)
    {
        $validacion->extend(
            'maximo',
            function($attribute, $value, $parameters){
                if (intval($value) <= intval($parameters[0]))
                    return true;
                return false;
            }
        );
    }
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
        if (request()->has('merit-submerit')) {
            $merito = Merito::where('id_convocatoria', $convActual)->where('id', request()->input('merit-submerit'))->value('porcentaje');
            $subMeritos = Merito::where('id_convocatoria', $convActual)->where('id_submerito', request()->input('merit-submerit'))->sum('porcentaje');
            $total = $merito - $subMeritos;
            return [
                'submerit-descripcion' => 'required|unique:merito,descripcion_merito,0,id,id_convocatoria,'.$convActual,
                'submerit-porcentaje' => 'required|maximo:'.$total,
            ];
        } else {
            $total = Merito::where('id_convocatoria', $convActual)->where('id_submerito', null)->sum('porcentaje');
            $total = 100 - $total;

            return [
                'merit-descripcion' => 'required|unique:merito,descripcion_merito,0,id,id_convocatoria,'.$convActual,
                'merit-porcentaje' => 'required|maximo:'.$total
            ];
        }
    }

    public function messages()
    {
        if (request()->has('merit-submerit')) {
            return [
                'submerit-descripcion.unique' => 'El campo Descripción debe ser único.',
                'submerit-porcentaje.maximo' => 'El Porcentaje ingresado mas la suma de los otros sub meritos excede el limite.'
            ];
        } else {
            return [
                'merit-descripcion.unique' => 'El campo Descripción debe ser único.',
                'merit-porcentaje.maximo' => 'El Porcentaje ingresado mas la suma de los otros supera los 100.'
            ];
        }
    }
}
