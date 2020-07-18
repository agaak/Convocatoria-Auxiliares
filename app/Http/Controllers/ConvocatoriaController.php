<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\Requerimiento;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRol;
use App\Http\Requests\ConvocatoriaRequest;
use App\Http\Controllers\Utils\ConvocatoriaComp as Convos;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\ConvocatoriaComp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


class ConvocatoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador'])->except('index','download');
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
        
        $convos =  (new Convos)->getConvocatorias();

        session()->forget('convocatoria');
        session()->forget('ver');
        $auxs = Requerimiento::select('auxiliatura.*','requerimiento.id_convocatoria as id_conv')
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')
            ->groupBy('requerimiento.id_convocatoria','auxiliatura.id')->get();
            
        return view('convocatoria', compact('tipos','anioActual','convos', 'auxs'));
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
        $conv->finalizado = false;
        $conv->creado = false;
        $conv->save();

        session()->put('convocatoria', $conv->id) ;
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluadorUtils =  new EvaluadorComp();
        $convUtils = new ConvocatoriaComp();
        $id_uniadad = Convocatoria::where('id',session()->get('convocatoria'))->value('id_unidad_academica');
        $evaluadores = $evaluadorUtils->getEvaluadoresConvo($id);
        foreach($evaluadores as $eva){
            $roles = $evaluadorUtils->getRolesEvaluador($eva->id_eva_con);
            $lista_aux = $evaluadorUtils->getAuxsEvaluador($eva->id_eva_con);
            $lista_tem = $evaluadorUtils->getTemsEvaluador($eva->id_eva_con);
            $correo = $eva->correo;
            $nombres = $eva->nombre." ".$eva->apellido;

            $contrasenia = $convUtils->uniqidReal();
            $datos=[    
                "titulo" => $eva->titulo,
                "ci" =>  $eva->ci,
                "contrasenia" =>  $contrasenia,
                "usuario" =>  $eva->ci,
                "nombres" => $nombres,
                "rol" => $roles,
                "tematicas" =>  $lista_tem,
                "auxiliaturas" =>  $lista_aux
            ];
            if(!User::where('userToken',$eva->ci)->exists()){
                $user = new User();
                $user->name = $nombres;
                $user->password = bcrypt($contrasenia);
                $user->email = $correo;
                $user->userToken = $eva->ci;
                $user->unidad_academica_id = $id_uniadad;
                $user->save();
                $userRol = new UserRol();
                $userRol->user_id = $user->id;
                $userRol->role_id = Role::where('name','evaluador')->value('id');
                $userRol->save();
            }else{
                User::where('userToken',$eva->ci)->update([
                    'password' => bcrypt($contrasenia),
                ]);  
            }
            
            Mail::send("emails.test", $datos, function($mensaje) use($nombres,$correo){
                $mensaje -> to($correo, $nombres) -> subject("Asignacion como evaluador");   
            });
        }
        Convocatoria::where('id', $id)->update([
            'publicado' => true,
            'pre_posts_habilitado' => true
        ]);
        return back();
    }

    public function download($id)
    {
        $file = Convocatoria::where('id', $id)->value('ruta_pdf');
        return Storage::download($file, substr($file, 7 + strlen($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session()->put('convocatoria', $id);
        session()->put('ver', false);
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
