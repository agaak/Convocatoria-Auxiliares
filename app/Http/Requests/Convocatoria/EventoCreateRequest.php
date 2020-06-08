<?php

namespace App\Http\Requests\Convocatoria;
use App\Convocatoria;

use Illuminate\Foundation\Http\FormRequest;

class EventoCreateRequest extends FormRequest
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
        $idConv = request()->session()->get('convocatoria');
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = $convActual->value('fecha_inicio').' 00:00:00';
        $fechaFinConv = $convActual->value('fecha_final').' 23:59:59';
        return [
            'titulo-evento' => 'required|unique:evento,titulo_evento,0,id,id_convocatoria,'.$idConv,
            'lugar-evento' => 'required',
            'fecha-ini-evento' => 'required|date|date_format:"Y-m-d\TH:i"|after_or_equal:'.$fechaIniConv,
            'fecha-fin-evento' => 'required|date|date_format:"Y-m-d\TH:i"|after_or_equal:fecha-ini-evento|before_or_equal:'.$fechaFinConv,
        ];
    }

    public function messages()
    {
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = $convActual->value('fecha_inicio').' 00:00:00';
        $fechaFinConv = $convActual->value('fecha_final').' 23:59:59';
        return [
            'fecha-ini-evento-evento.required' => 'El campo Fecha Inicio es obligatorio.',
            'fecha-fin-evento-evento.required' => 'El campo Fecha Final es obligatorio.',
            'fecha-ini-evento-evento.after_or_equal' => 'La Fecha Inicio debe ser una fecha posterior o igual a '.$fechaIniConv.'.',
            'fecha-fin-evento-evento.before_or_equal' => 'La Fecha Final debe ser una fecha anterior o igual a '.$fechaFinConv.'.',
            'fecha-fin-evento-evento.after_or_equal' => 'La Fecha Final debe ser una fecha posterior o igual a la fecha inicial.'
        ];
    }
}
