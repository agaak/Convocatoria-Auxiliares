<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use App\Tipo;
use Illuminate\Http\Request;

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
        return view('convocatoria', compact('tipos','anioActual'));
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
    public function store(Request $request)
    {
        $fecha = date("m/d/Y");
        $this->validate($request, [
            'conv-titulo' => 'required',
            'conv-fecha-ini' => 'required|before_or_equal:conv-fecha-fin|after_or_equal:'.$fecha,
            'conv-fecha-fin' => 'required',
            'conv-tipo' => 'required',
            'conv-gestion' => 'required',
            'conv-descripcion' => 'required'
        ]);
        $convo = new Convocatoria();
        $convo->id_unidad_academica = 1;
        $convo->id_tipo_convocatoria = $request->input('conv-tipo');
        $convo->titulo = $request->input('conv-titulo');
        $convo->descripcion_convocatoria = $request->input('conv-descripcion');
        $convo->fecha_inicio = date("Y-m-d", strtotime($request->input('conv-fecha-ini')));
        $convo->fecha_final = date("Y-m-d", strtotime($request->input('conv-fecha-fin')));
        $convo->save();

        session()->put('convocatoria', $convo->id) ;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
