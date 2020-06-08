<?php

namespace App\Http\Controllers\Convocatoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeritoEditRequest;
use App\Http\Requests\MeritoRequest;
use App\Merito;
use App\Calificacion_final;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $meritList = Merito::where('id_convocatoria', request()->session()->get('convocatoria'))->orderBy('id', 'ASC')->get();

        $llenarLista = [];
        $listaInicial = [];
        foreach ($meritList as $value) {
            $listaInicial = [];
            array_push($listaInicial, $value->id_submerito);
            array_push($listaInicial, $value->descripcion_merito);
            array_push($listaInicial, $value->porcentaje);
            array_push($listaInicial, $value->id);
            $llenarLista[$value->id] = $listaInicial;
        }

        function buscarPerteneciente($original, $identificador, $arreglo, $caracteres, $cadena) {
            $contador = 1;
            $cadenaTempral = "";
            foreach ($original as $key => $value) {
                if ($value[0] !== null) {
                    if($value[0] === $identificador) {
                        $cadenaTemporal = $cadena.$contador;
                        $value[1] = chr($caracteres).$cadenaTemporal.') '.$value[1];
                        array_push($arreglo, $value);
                        $arreglo = buscarPerteneciente($original ,$key, $arreglo, $caracteres, $cadenaTemporal.'.');
                        $contador++;
                    }
                }
            }
            return $arreglo;
        }

        $listaOrdenada = [];
        $caracteres = 321;
        foreach ($llenarLista as $key => $value) {
            if ($value[0] === null) {
                $value[1] = chr($caracteres).') '.$value[1];
                array_push($listaOrdenada, $value);
                $listaOrdenada = buscarPerteneciente($llenarLista, $key, $listaOrdenada, $caracteres, '.');
                $caracteres++;
            }
        }

        
        $porcentajesConvocatoria = Calificacion_final::where('id_convocatoria',session()->get('convocatoria'))->first();
        return view('convocatory.meritos', compact('listaOrdenada','porcentajesConvocatoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeritoRequest $request)
    {
        $merit = new Merito();
        $convActual = $request->session()->get('convocatoria');
        if (request()->has('merit-submerit')) {
            $merit->id_convocatoria = $convActual;
            $merit->id_submerito = $request->input('merit-submerit');
            $merit->descripcion_merito = $request->input('submerit-descripcion');
            $merit->porcentaje = $request->input('submerit-porcentaje');
        } else {
            $merit->id_convocatoria = $convActual;
            $merit->descripcion_merito = $request->input('merit-descripcion');
            $merit->porcentaje = $request->input('merit-porcentaje');
        }
        $merit->save();
        return redirect()->route('calificacion-meritos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeritoEditRequest $request)
    {   
        if(request()->has('porcent-merit')){
            $id_conv = session()->get('convocatoria');
            if(Calificacion_final::where('id_convocatoria', '=', $id_conv)->exists()){
                DB::table('calificacion_final')->where('id_convocatoria', $id_conv)->update([
                    'porcentaje_merito' => $request->input('porcent-merit'),
                    'porcentaje_conocimiento' => 100 - $request->input('porcent-merit'),
                ]);
            }else{
                $calificacion = new Calificacion_final();
                $calificacion->id_convocatoria = $id_conv;
                $calificacion->porcentaje_merito = $request->input('porcent-merit');
                $calificacion->porcentaje_conocimiento = 100 - $request->input('porcent-merit');
                $calificacion->save();
            }
        }else if (request()->has('merit-submerit')) {
            Merito::where('id', $request->input('submerit-id'))->update([
                'id_submerito' => $request->input('merit-submerit'),
                'descripcion_merito' => $request->input('submerit-descripcion-edit'),
                'porcentaje' => $request->input('submerit-porcentaje-edit')
            ]);
        } else {
            Merito::where('id', $request->input('merit-id'))->update([
                'descripcion_merito' => $request->input('merit-descripcion-edit'),
                'porcentaje' => $request->input('merit-porcentaje-edit')
            ]);
        }

        return redirect()->route('calificacion-meritos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Merito::where('id', $id)->delete();
        return redirect()->route('calificacion-meritos.index');
    }

    public function updatePoints($id)
    {
        Merito::where('id', $id)->delete();
        return redirect()->route('calificacion-meritos.index');
    }
}