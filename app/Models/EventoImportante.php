<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoImportante extends Model
{
    //
    protected $table='evento';
    protected $fillable=['id_convocatoria', 'titulo_evento', 'lugar_evento', 'fecha_inicio', 'fecha_final'];

}
