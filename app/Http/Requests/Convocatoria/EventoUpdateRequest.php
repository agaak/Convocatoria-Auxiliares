<?php

namespace App\Http\Requests\Convocatoria;
use App\Convocatoria;

use Illuminate\Foundation\Http\FormRequest;

class EventoUpdateRequest extends FormRequest
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
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = $convActual->value('fecha_inicio').' 00:00:00';
        $fechaFinConv = $convActual->value('fecha_final').' 23:59:59';
        return [
            'id-datos-edit' => 'required',
            'titulo-evento-edit' => 'required',
            'lugar-evento-edit' => 'required',
            'fecha-ini-evento-edit' => 'required|date|after_or_equal:'.$fechaIniConv,
            'fecha-fin-evento-edit' => 'required|date|after:fecha-ini-evento-edit|before_or_equal:'.$fechaFinConv,
        ];
    }
}
