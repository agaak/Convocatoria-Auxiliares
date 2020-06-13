<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use App\Http\Requests\ConvocatoriaRequest;
use App\Requerimiento;
use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anioActual = date("Y");
        $tipos = Tipo::get();
        $convos = Convocatoria::where('id_unidad_academica',1)->get();
        session()->forget('convocatoria');
        $auxs = Requerimiento::select('auxiliatura.*','requerimiento.id_convocatoria as id_conv')
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')
            ->groupBy('requerimiento.id_convocatoria','auxiliatura.id')->get();
        return view('convocatoria', compact('tipos','anioActual','convos', 'auxs'));
        return $auxs;
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
    public function store(ConvocatoriaRequest $request)
    {
        $conv = new Convocatoria();
        $conv->id_unidad_academica = 1;
        $conv->id_tipo_convocatoria = $request->input('conv-tipo');
        $conv->titulo = $request->input('conv-titulo');
        $conv->descripcion_convocatoria = $request->input('conv-descripcion');
        $conv->fecha_inicio = date("Y-m-d", strtotime($request->input('conv-fecha-ini')));
        $conv->fecha_final = date("Y-m-d", strtotime($request->input('conv-fecha-fin')));
        $conv->gestion = $request->input('conv-gestion');
        $conv->publicado = false;
        $conv->creado = false;
        $conv->save();
        
        session()->put('convocatoria', $conv->id) ;
        return redirect()->route('requests');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Convocatoria::where('id', $id)->update([
            'publicado' => true
        ]);
        return back();
    }

    public function download($id)
    {
        $file = Convocatoria::where('id', $id)->value('ruta_pdf');
        return Storage::download($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session()->put('convocatoria', $id) ;
        return redirect()->route('requests');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Storage::delete(Convocatoria::find($id)->ruta_pdf);
        Convocatoria::find($id)->delete();
        return back();
    }
}
