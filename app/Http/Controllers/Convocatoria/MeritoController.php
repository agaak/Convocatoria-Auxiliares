<?php

namespace App\Http\Controllers\Convocatoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeritoEditRequest;
use App\Http\Requests\MeritoRequest;
use App\Merito;
use Illuminate\Http\Request;

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

        return view('convocatory.meritos', compact('listaOrdenada'));
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
        if (request()->has('merit-submerit')) {
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
}

// public function meritRatingDelete($id){
//         DB::table('merito')->where('id_merito', $id)->delete();
//         return redirect()->route('meritRating');
//     }

//     public function meritRatingUpdate(Request $request){
//         if ($request->has('merito-o-submerito')) {
//             DB::table('merito')->where('id_merito', $request->input('id-submerito'))->update([
//                 'id_sub_merito' => $request->input('merito-o-submerito'),
//                 'descripcion' => $request->input('descripcion-sub-merito'),
//                 'porcentaje' => $request->input('porcentaje-sub-merito')
//             ]);
//         } else {
//             DB::table('merito')->where('id_merito', $request->input('id-merito'))->update([
//                 'descripcion' => $request->input('descripcion-merito'),
//                 'porcentaje' => $request->input('porcentaje-merito')
//             ]);
//         }

//         return redirect()->route('meritRating');
//     }

//     public function meritRating(){
//         $meritList = DB::table('merito')->orderBy('id', 'ASC')->get();

//         $llenarLista = [];
//         $listaInicial = [];
//         foreach ($meritList as $value) {
//             $listaInicial = [];
//             array_push($listaInicial, $value->id_sub_merito);
//             array_push($listaInicial, $value->descripcion);
//             array_push($listaInicial, $value->porcentaje);
//             array_push($listaInicial, $value->id_merito);
//             $llenarLista[$value->id_merito] = $listaInicial;
//         }

//         function buscarPerteneciente($original, $identificador, $arreglo, $caracteres, $cadena) {
//             $contador = 1;
//             $cadenaTempral = "";
//             foreach ($original as $key => $value) {
//                 if ($value[0] !== null) {
//                     if($value[0] === $identificador) {
//                         $cadenaTemporal = $cadena.$contador;
//                         $value[1] = chr($caracteres).$cadenaTemporal.') '.$value[1];
//                         array_push($arreglo, $value);
//                         $arreglo = buscarPerteneciente($original ,$key, $arreglo, $caracteres, $cadenaTemporal.'.');
//                         $contador++;
//                     }
//                 }
//             }
//             return $arreglo;
//         }

//         $listaOrdenada = [];
//         $caracteres = 321;
//         foreach ($llenarLista as $key => $value) {
//             if ($value[0] === null) {
//                 $value[1] = chr($caracteres).') '.$value[1];
//                 array_push($listaOrdenada, $value);
//                 $listaOrdenada = buscarPerteneciente($llenarLista, $key, $listaOrdenada, $caracteres, '.');
//                 $caracteres++;
//             }
//         }

//         return view('convocatory.meritos', compact('listaOrdenada'));
//     }

//     public function meritRatingValid(Request $request){
//         if ($request->has('merito-o-submerito')) {
//             DB::table('merito')->insert([
//                 'id_convocatoria' => $request->session()->get('convocatoria'),
//                 'id_sub_merito' => $request->input('merito-o-submerito'),
//                 'descripcion_merito' => $request->input('descripcion-sub-merito'),
//                 'porcentaje' => $request->input('porcentaje-sub-merito')
//             ]);
//         } else {
//             DB::table('merito')->insert([
//                 'id_convocatoria' => $request->session()->get('convocatoria'),
//                 'descripcion_merito' => $request->input('descripcion-merito'),
//                 'porcentaje' => $request->input('porcentaje-merito')
//             ]);
//         }
//         return redirect()->route('meritRating');
//     }