<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Role;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;


// Route::get('/', ['as' => 'home', 'uses' => 'NavbarController@home']);

Route::get('/', function(){
	return redirect()->route('convocatoria.index');
});

Route::get('/resultados', ['as' => 'results', 'uses' => 'NavbarController@results']);

Route::get('/tramites-documentos', ['as' => 'proceduresDocs', 'uses' => 'NavbarController@proceduresDocs']);

Route::get('/convocatoria/requerimientos', ['as' => 'requests', 'uses' => 'Convocatoria\RequerimientoController@requests']);
Route::post('/convocatoria/requerimientos', ['as' => 'create', 'uses' => 'Convocatoria\RequerimientoController@create']);
Route::put('/convocatoria/requerimientos', ['as' => 'update', 'uses' => 'Convocatoria\RequerimientoController@update']);
Route::delete('/convocatoria/requerimientos/{id}', ['as' => 'delete', 'uses' => 'Convocatoria\RequerimientoController@delete']);


Route::get('/convocatoria/requisitos', ['as' => 'requirement', 'uses' => 'Convocatoria\RequisitoController@requirements']);
Route::post('/convocatoria/requisitos', ['as' => 'requirementValid', 'uses' => 'Convocatoria\RequisitoController@requirementsValid']);
Route::put('/convocatoria/requisitos', ['as' => 'requirementUpdate', 'uses' => 'Convocatoria\RequisitoController@requirementUpdate']);
Route::delete('/convocatoria/requisitos/{id}', ['as' => 'requirementDelete', 'uses' => 'Convocatoria\RequisitoController@requirementDelete']);

Route::post('/convocatoria/requisitos/nota', ['as' => 'requisitoNota', 'uses' => 'Convocatoria\NotaRequisitoController@store']);

Route::get('/convocatoria/documentos', ['as' => 'documentos', 'uses' => 'Convocatoria\DocumentoController@documentos']);
Route::post('/convocatoria/documentos', ['as' => 'documentoValid', 'uses' => 'Convocatoria\DocumentoController@documentoValid']);
Route::put('/convocatoria/documentos', ['as' => 'documentoUpdate', 'uses' => 'Convocatoria\DocumentoController@documentoUpdate']);
Route::delete('/convocatoria/documentos/{id}', ['as' => 'documentoDelete', 'uses' => 'Convocatoria\DocumentoController@documentoDelete']);

Route::post('/convocatoria/documentos/nota', ['as' => 'docNota', 'uses' => 'Convocatoria\NotaDocController@store']);

Route::get('/convocatoria/fechas-importantes', ['as' => 'importantDates', 'uses' => 'Convocatoria\EventoController@importantDates']);
Route::post('/convocatoria/fechas-importantes', ['as' => 'importantDateSave', 'uses' => 'Convocatoria\EventoController@importantDateSave']);
Route::put('/convocatoria/fechas-importantes', ['as' => 'importantDatesUpdate', 'uses' => 'Convocatoria\EventoController@importantDatesUpdate']);
Route::delete('/convocatoria/fechas-importantes/{id}', ['as' => 'importantDatesDelete', 'uses' => 'Convocatoria\EventoController@importantDatesDelete']);

Route::get('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRating', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRating']);
Route::post('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingTematicValid', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicValid']);
Route::put('/convocatoria/calificacion-conocimientos/{id}', ['as' => 'knowledgeRatingTematicUpdate', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicUpdate']);
Route::delete('/convocatoria/calificacion-conocimientos/{id}', ['as' => 'knowledgeRatingTematicDelete', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicDelete']);
Route::post('/convocatoria/calificacion-conocimientos/aux', ['as' => 'knowledgeRatingAuxUpdate', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingAuxUpdate']);
Route::post('/convocatoria/calificacion-conocimientos/finalizar', ['as' => 'knowledgeRatingFinish', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingFinish']);
Route::post('/convocatoria/calificacion-conocimientos/pdf', ['as' => 'knowledgeRatingPdf', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingPdf']);
// Controladores de la administracion de convocatoria
Route::get('convocatoria/adm-convocatoria', 'AdmConvocatoria\AdmConvocatoriaController@index')->name('admConvocatoria');
Route::get('convocatoria/adm-convocatoria/{id}', 'AdmConvocatoria\AdmConvocatoriaController@inicio')->name('adminConvocatoria');

Route::get('convocatoria/adm-postulantes', 'AdmConvocatoria\AdmPostulantesController@index')->name('admPostulantes');
Route::post('convocatoria/adm-postulantes','AdmConvocatoria\AdmPostulantesController@create')->name('admPostulanteCreate');

Route::get('convocatoria/adm-conocimientos', 'AdmConvocatoria\AdmConocimientosController@index')->name('admConocimientos');
Route::post('convocatoria/adm-conocimientos', 'AdmConvocatoria\AdmConocimientosController@store')->name('admConoStore');
Route::delete('convocatoria/adm-conocimientos{id}', 'AdmConvocatoria\AdmConocimientosController@destroy')->name('admConocimientosDelete');
Route::put('convocatoria/adm-conocimientos', 'AdmConvocatoria\AdmConocimientosController@updateEvaluador')->name('admConoUpdate');

Route::get('convocatoria/adm-meritos', 'AdmConvocatoria\AdmMeritosController@index')->name('admMeritos');
Route::post('convocatoria/adm-meritos','AdmConvocatoria\AdmMeritosController@create')->name('admMeritosCreate');
Route::put('convocatoria/adm-meritos', 'AdmConvocatoria\AdmMeritosController@update')->name('admMeritosUpdate');
Route::delete('convocatoria/adm-meritos/{id}', 'AdmConvocatoria\AdmMeritosController@delete')->name('admMeritosDelete');


Route::get('convocatoria/adm-resultados', 'AdmConvocatoria\AdmResultadosController@index')->name('admResultados');



Route::get('convocatoria/download/{id}', 'ConvocatoriaController@download')->name('convocatoria.download');


Route::post('convocatoria/pre-postulacion', 'PrePostulanteController@exportPDF')->name('exportPDF');

Route::get('evaluador', 'Evaluador\EvaluadorController@index')->name('evaluador.index');
Route::get('evaluador/calificar', 'Evaluador\CalificarController@index')->name('calificar.index');

Route::get('evaluador/calificar/merito', 'Evaluador\CalificarMeritoController@index')->name('calificarMerito.index');

Route::get('evaluador/calificar/conocimiento/{id}/{tem}', 'Evaluador\CalificarConocController@index')->name('calificarConoc.index');
Route::post('evaluador/calificar/conocimiento', 'Evaluador\CalificarConocController@store')->name('calificarConoc.store');
Route::get('evaluador/calificar/conocimiento/oral', 'Evaluador\CalificarConocController@oral')->name('calificarConoc.oral');
Route::get('evaluador/calificar/conocimiento/escrito', 'Evaluador\CalificarConocController@escrito')->name('calificarConoc.escrito');

Route::get('evaluador/calificar/{id}', function($id) {
	session()->put('convocatoria', $id);
	return redirect()->route('calificar.index');
})->name('helper.redirect');

Route::get('convocatoria/ver/{id}', function($id) {
	session()->put('convocatoria', $id);
	session()->put('ver', true);
	return redirect()->route('requests');
})->name('helper.redirect.ver');

Route::get('evaluador/merito/{idEst}', 'Evaluador\CalificacionMController@calificarMeritos')->name('evaluarM.calificarMeritos');
Route::post('evaluador/merito/calificar-merito', 'Evaluador\CalificacionMController@calificarMeritoEspecifico')->name('evaluarM.calificarMeritoEspecifico');
Route::post('evaluador/merito/calificar-merito-final', 'Evaluador\CalificacionMController@calificarMeritoFinal')->name('evaluarM.calificarMeritoFinal');

//Lista estado de postulantes
Route::get('convocatoria/adm-postulantes/habilitados','PDFpostulantesController@listHabilitados');

// Estos siempres al final son un caso especial
Route::resource('convocatoria/calificacion-meritos', 'Convocatoria\MeritoController');
Route::resource('convocatoria', 'ConvocatoriaController');

Auth::routes();
