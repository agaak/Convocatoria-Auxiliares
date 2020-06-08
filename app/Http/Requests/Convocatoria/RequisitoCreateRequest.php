<?php

namespace App\Http\Requests\Convocatoria;

use Illuminate\Foundation\Http\FormRequest;

class RequisitoCreateRequest extends FormRequest
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
            'descripcion'=> 'required|unique:requisito,descripcion,0,id,id_convocatoria,'.$convActual
            //
        ];
    }
}
