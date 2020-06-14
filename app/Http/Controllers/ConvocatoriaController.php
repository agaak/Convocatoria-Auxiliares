<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use App\Tipo_evaluador;
use App\EvaluadorAuxiliatura;
use App\EvaluadorTematica;
use App\Http\Requests\ConvocatoriaRequest;
use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\EvaluadorConocimientos;

class ConvocatoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador,evaluador'])->except('index');
    }
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
        return view('convocatoria', compact('tipos','anioActual','convos'));
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
        $datos = [];
        Convocatoria::where('id', $id)->update([
            'publicado' => false
        ]);
        $evaluadores = EvaluadorConocimientos::select('evaluador.*','convocatoria.titulo','evaluador_conovocatoria.id  as id_eva_con')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id)
            ->join('convocatoria','evaluador_conovocatoria.id_convocatoria','=','convocatoria.id')
            ->groupBy('evaluador.id','convocatoria.titulo','evaluador_conovocatoria.id')
            ->get();

        foreach($evaluadores as $eva){
            $ro = Tipo_evaluador::select('tipo_rol_evaluador.id','tipo_rol_evaluador.nombre')
                ->where('id_evaluador_convocatoria',$eva->id_eva_con)
                ->join('tipo_rol_evaluador','tipo_evaluador.id_rol_evaluador','=','tipo_rol_evaluador.id')
                ->get();

            $lista_aux = EvaluadorAuxiliatura::select('auxiliatura.nombre_aux as nombre') 
            ->join('evaluador_conovocatoria','evaluador_auxiliatura.id_evaluador_convocatoria','=','evaluador_conovocatoria.id') 
            ->where('evaluador_conovocatoria.id',$eva->id_eva_con)
            ->join('auxiliatura','evaluador_auxiliatura.id_auxiliatura','=','auxiliatura.id')->get();
            
            $lista_tem = EvaluadorTematica::select('tematica.nombre') 
            ->join('evaluador_conovocatoria','evaluador_tematica.id_evaluador_convocatoria','=','evaluador_conovocatoria.id')
            ->where('evaluador_conovocatoria.id',$eva->id_eva_con)
            ->join('tematica','evaluador_tematica.id_tematica','=','tematica.id')->get();
       
            $datos=[    
                "titulo" => $eva->titulo,
                "ci" =>  $eva->ci,
                "correo" =>  $eva->correo,
                "usuario" =>  $eva->nombre,
                "nombres" => $eva->nombre." ".$eva->apellido,
                "rol" => $ro,
                "tematicas" =>  $lista_tem,
                "auxiliaturas" =>  $lista_aux
            ];
         
            $correo = $eva->correo;
            $nombres = $eva->nombre." ".$eva->apellido;
            Mail::send("emails.test", $datos, function($mensaje) use($nombres,$correo){
                $mensaje -> to($correo, $nombres) -> subject("Asignacion como evaluador");   
            });
            break;
        }
        
        
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
