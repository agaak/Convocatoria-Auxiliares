<?php

namespace App\Http\Requests\Convocatoria;
use App\Models\Convocatoria;
use App\Models\EventoImportante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

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
        $idConv = request()->session()->get('convocatoria');
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = $convActual->value('fecha_inicio').' 00:00:00';
        $fechaFinConv = $convActual->value('fecha_final').' 23:59:59';

        $idEvento = request()->input('id-datos-edit');

        return [
            'titulo-evento-edit' => 'required|unique:evento,titulo_evento,'.$idEvento.',id,id_convocatoria,'.$idConv,
            'id-datos-edit' => 'required',
            'lugar-evento-edit' => 'required',
            'fecha-ini-evento-edit' => 'required|date|after_or_equal:'.$fechaIniConv,
            'fecha-fin-evento-edit' => 'required|date|after_or_equal:fecha-ini-evento-edit|before_or_equal:'.$fechaFinConv,
        ];
    }

    public function messages()
    {
        $convActual = Convocatoria::where('id', request()->session()->get('convocatoria'));
        $fechaIniConv = date_create($convActual->value('fecha_inicio').' 00:00:00');
        $fechaFinConv = date_create($convActual->value('fecha_final').' 23:59:59');
        return [
            'titulo-evento-edit.required' => 'El titulo es obligatorio.',
            'titulo-evento-edit.unique' => 'El titulo ingresado ya existe.',
            'fecha-ini-evento-edit.after_or_equal' => 'La Fecha Inicio debe ser una fecha posterior o igual a '.date_format($fechaIniConv, 'd/m/Y H:i:s').'.',
            'fecha-fin-evento-edit.before_or_equal' => 'La Fecha Final debe ser una fecha anterior o igual a '.date_format($fechaFinConv, 'd/m/Y H:i:s').'.',
            'fecha-fin-evento-edit.after_or_equal' => 'La Fecha Final debe ser una fecha posterior o igual a la fecha inicial.'
        ];
    }
}
