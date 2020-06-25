<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Convocatoria;

class EvaluadorConocimientos extends Model
{
    //
    protected $table='evaluador';

    protected $fillable=['ci', 'nombre', 'apellido', 'correo'];

    public function convocatorias() {
        return $this->belongsToMany(Convocatoria::class, 'evaluador_conovocatoria', 'id_evaluador', 'id_convocatoria');
    }

}
