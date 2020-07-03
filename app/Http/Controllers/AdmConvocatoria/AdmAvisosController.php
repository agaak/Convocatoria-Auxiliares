<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Http\Requests\AdmConvocatoria\AdmAvisoRequest;
use App\Http\Requests\AdmConvocatoria\AdmAvisoUpdateRequest;
use App\Models\Aviso;

class AdmAvisosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:secretaria']);
    }
    
    public function index()
    {
        $convActual = session()->get('convocatoria');
        $listAvisos = Aviso::where('id_convocatoria','=',$convActual)->get();
        return view('admConvocatoria.admAvisos',compact('listAvisos'));
    }
    
    public function create(AdmAvisoRequest $request )
    {   
        // dd($request->all());
        $aviso = new Aviso();
        $convActual = $request->session()->get('convocatoria');
        $aviso->id_convocatoria = $convActual;
        $aviso->titulo = $request->input('avisoTitulo');
        $aviso->descripcion = $request->input('avisoDescripcion');
        $aviso->save();
        return back();
    }
    
    public function update(Request $request){
        $convActual = request()->session()->get('convocatoria');
        $idAviso = $request->input('idAvisoEdit');
        Aviso::where('id', $idAviso)->update([
            'titulo' => $request->input('avisoTituloEdit'),
            'descripcion' => $request->input('avisoDescripcionEdit') ]);
        return back();
    }

    public function delete($id){
        Aviso::where('id', $id)->delete();
        return back();
    }


}
