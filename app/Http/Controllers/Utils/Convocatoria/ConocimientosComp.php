<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Models\Requerimiento;
use App\Models\Porcentaje;
use App\Models\Tematica;
use App\Models\Area;

class ConocimientosComp
{   
    public function getRequerimientos($id_conv){
        $requests =Requerimiento::select('auxiliatura.nombre_aux','auxiliatura.cod_aux','auxiliatura.id')
            ->where('id_convocatoria',$id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')
            ->orderBy('auxiliatura.id','ASC')->get();    
        return $requests;
    }
    
    public function getPorcentajes($id_conv){
        $porcentajes = Porcentaje::select('id_requerimiento','porcentaje.porcentaje','id_area','porcentaje.id',
        'porcentaje.id_auxiliatura','id_tematica','tematica.nombre','area_calificacion.nombre as area')
        ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
        ->where('requerimiento.id_convocatoria',$id_conv)->orderBy('id_requerimiento','ASC')
        ->join('tematica','porcentaje.id_tematica','=','tematica.id')
        ->join('area_calificacion','porcentaje.id_area','=','area_calificacion.id')
        ->orderBy('tematica.nombre','ASC')->get();
        $porcentajes = collect($porcentajes)->groupBy('id_auxiliatura');
        return $porcentajes;
    }
    
    public function getTems($id_conv){
        $tems = Tematica::select('tematica.nombre','tematica.id','requerimiento.id_auxiliatura')
        ->join('porcentaje','tematica.id','=','porcentaje.id_tematica')
        ->join('requerimiento','porcentaje.id_requerimiento', '=', 'requerimiento.id')
        ->where('requerimiento.id_convocatoria',$id_conv)
        ->groupBy('tematica.nombre','tematica.id','requerimiento.id_auxiliatura')
        ->orderBy('nombre','ASC')->get();
        $tems = collect($tems)->groupBy('id_auxiliatura');
        foreach($tems as $tem){
            foreach($tem as $tem_aux){
                $tem_aux->areas = Porcentaje::select('porcentaje.id','porcentaje','id_area','nombre as area')
                    ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
                    ->where('requerimiento.id_convocatoria',$id_conv)
                    ->where('porcentaje.id_tematica', $tem_aux->id)->where('porcentaje.id_auxiliatura', $tem_aux->id_auxiliatura)
                    ->join('area_calificacion','porcentaje.id_area','=','area_calificacion.id')
                ->get();
            }
        }
        return $tems;
    }

    public function getTematicas($tipo, $tems, $list_aux){
        // $tems->collapse()->groupBy('id');
        $list_aux = collect($list_aux)->groupBy('id');
        foreach($list_aux as $aux){
            $tems_aux = [];
            if($tems->has($aux[0]['id'])){
                foreach($tems[$aux[0]['id']] as $tem){
                    array_push($tems_aux, $tem->id);   
                }
            }
            $aux[0]->tematics = Tematica::select('nombre','id')
                ->where('id_tipo_convocatoria',$tipo)->where('habilitado', true)
                ->whereNotIn('id',$tems_aux)
                ->orderBy('nombre','ASC')->get();
        }
        return $list_aux;
    }

    public function getAreas($tipo){
        $areas = Area::select('nombre','id')
            ->where('id_tipo_convocatoria',$tipo)
            ->orderBy('nombre','ASC')->get();
        return $areas;
    }
        
}
