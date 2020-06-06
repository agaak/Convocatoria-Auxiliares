<?php

namespace App\Http\Requests;

use App\Merito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidacionPersonal;

class MeritoEditRequest extends FormRequest
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
        if(request()->has('porcent-merit')){
            return ['porcent-merit' => 'required|maximo:99|min:1'];
        }else if (request()->has('merit-submerit')) {
            $merito = Merito::where('id_convocatoria', $convActual)->where('id', request()->input('merit-submerit'))->value('porcentaje');
            $subMeritos = Merito::where('id_convocatoria', $convActual)
                ->where('id_submerito', request()->input('merit-submerit'))
                ->where('id', '<>', request()->input('submerit-id'))->sum('porcentaje');
            $total = $merito - $subMeritos;
            return [
                'submerit-porcentaje-edit' => 'required|maximo:'.$total,
            ];
        } else {
            $total = Merito::where('id_convocatoria', $convActual)->where('id_submerito', null)
                ->where('id', '<>', request()->input('merit-id'))->sum('porcentaje');
            $total = 100 - $total;
    
            return [
                'merit-porcentaje-edit' => 'required|maximo:'.$total
            ];
        }
        
    }

    public function messages()
    {
        if(request()->has('porcent-merit')){
            return ['porcent-merit.required' => 'El porcentaje es requerido',
                    'porcent-merit.min' => 'El porcentaje debe ser mayor a 0',
                    'porcent-merit.max' => 'El porcentaje debe ser menor a 100',                    
                    ];
        }else if (request()->has('merit-submerit')) {
            return [
                'submerit-porcentaje-edit.maximo' => 'El Porcentaje ingresado mas la suma de los otros sub meritos excede el limite.'
            ];
        } else {
            return [
                'merit-porcentaje-edit.maximo' => 'El Porcentaje ingresado mas la suma de los otros supera los 100.'
            ];
        }
        
    }
}
