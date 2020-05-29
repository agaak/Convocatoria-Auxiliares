<?php

namespace App\Http\Requests;

use App\Merito;
use Illuminate\Foundation\Http\FormRequest;

class MeritoRequest extends FormRequest
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
        if (request()->has('merit-submerit')) {
            $merito = Merito::where('id_convocatoria', $convActual)->where('id', request()->input('merit-submerit'))->value('porcentaje');
            $subMeritos = Merito::where('id_convocatoria', $convActual)->where('id_submerito', request()->input('merit-submerit'))->sum('porcentaje');
            $total = $merito - $subMeritos;
            return [
                'submerit-descripcion' => 'required|unique:merito,descripcion_merito',
                'submerit-porcentaje' => 'required|max:'.$total,
            ];
        } else {
            $total = Merito::where('id_convocatoria', $convActual)->where('id_submerito', null)->sum('porcentaje');
            $total = 100 - $total;

            return [
                'merit-descripcion' => 'required|unique:merito,descripcion_merito',
                'merit-porcentaje' => 'required|max:'.$total,
            ];
        }
    }

    public function messages()
    {
        if (request()->has('merit-submerit')) {
            return [
                'submerit-descripcion.unique' => 'El campo Descripción debe ser único.',
                'submerit-porcentaje.max' => 'El Porcentaje ingresado mas la suma de los otros sub meritos excede el limite.'
            ];
        } else {
            return [
                'merit-descripcion.unique' => 'El campo Descripción debe ser único.',
                'merit-porcentaje.max' => 'El Porcentaje ingresado mas la suma de los otros supera los 100.'
            ];
        }
    }
}
