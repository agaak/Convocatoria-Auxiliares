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
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = $convActual->value('fecha_inicio').' 00:00:00';
        $fechaFinConv = $convActual->value('fecha_final').' 23:59:59';
        return [
            'titulo-evento' => 'required|unique:evento,titulo_evento',
            'lugar-evento' => 'required|unique:evento,lugar_evento',
            'fecha-ini-evento' => 'required|date|date_format:"Y-m-d\TH:i"|after_or_equal:'.$fechaIniConv,
            'fecha-fin-evento' => 'required|date|date_format:"Y-m-d\TH:i"|after:fecha-ini-evento|before_or_equal:'.$fechaFinConv,
        ];
    }
}
