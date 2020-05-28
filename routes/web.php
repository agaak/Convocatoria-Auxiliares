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

use phpDocumentor\Reflection\DocBlock\Tags\Uses;


Route::get('/', ['as' => 'home', 'uses' => 'NavbarPages@home']);

Route::get('/convocatoria', ['as' => 'convocatory', 'uses' => 'NavbarPages@convocatory']);

Route::get('/resultados', ['as' => 'results', 'uses' => 'NavbarPages@results']);

Route::get('/tramites-documentos', ['as' => 'proceduresDocs', 'uses' => 'NavbarPages@proceduresDocs']);

Route::get('/convocatoria/titulo-descripcion', ['as' => 'titleDescription', 'uses' => 'Convocatoria@titleDescription']);
Route::put('/convocatoria/titulo-descripcion', ['as' => 'titleDescriptionValid', 'uses' => 'Convocatoria@titleDescriptionValid']);
Route::get('/convocatoria/titulo-descripcionGet', ['as' => 'titleDescriptionGet', 'uses' => 'Convocatoria@titleDescriptionGet']);

Route::get('/convocatoria/requerimientos', ['as' => 'requests', 'uses' => 'Convocatoria\RequerimientoController@requests']);
Route::post('/convocatoria/requerimientos', ['as' => 'create', 'uses' => 'Convocatoria\RequerimientoController@create']);
Route::put('/convocatoria/requerimientos', ['as' => 'update', 'uses' => 'Convocatoria\RequerimientoController@update']);
Route::delete('/convocatoria/requerimientos/{id}', ['as' => 'delete', 'uses' => 'Convocatoria\RequerimientoController@delete']);

Route::get('/convocatoria/requisitos', ['as' => 'requirement', 'uses' => 'Convocatoria\RequisitoController@requirements']);
Route::post('/convocatoria/requisitos', ['as' => 'requirementValid', 'uses' => 'Convocatoria\RequisitoController@requirementsValid']);
Route::put('/convocatoria/requisitos', ['as' => 'requirementUpdate', 'uses' => 'Convocatoria\RequisitoController@requirementUpdate']);
Route::delete('/convocatoria/requisitos/{id}', ['as' => 'requirementDelete', 'uses' => 'Convocatoria\RequisitoController@requirementDelete']);

Route::get('/convocatoria/documentos', ['as' => 'documentos', 'uses' => 'Convocatoria\DocumentoController@documentos']);
Route::post('/convocatoria/documentos', ['as' => 'documentoValid', 'uses' => 'Convocatoria\DocumentoController@documentoValid']);
Route::put('/convocatoria/documentos', ['as' => 'documentoUpdate', 'uses' => 'Convocatoria\DocumentoController@documentoUpdate']);
Route::delete('/convocatoria/documentos/{id}', ['as' => 'documentoDelete', 'uses' => 'Convocatoria\DocumentoController@documentoDelete']);

Route::get('/convocatoria/fechas-importantes', ['as' => 'importantDates', 'uses' => 'Convocatoria\EventoController@importantDates']);
Route::post('/convocatoria/fechas-importantes', ['as' => 'importantDatesValid', 'uses' => 'Convocatoria\EventoController@importantDatesValid']);
Route::put('/convocatoria/fechas-importantes', ['as' => 'importantDateSave', 'uses' => 'Convocatoria\EventoController@importantDateSave']);
Route::delete('/convocatoria/fechas-importantes/{id}', ['as' => 'importantDatesDelete', 'uses' => 'Convocatoria\EventoController@importantDatesDelete']);

Route::get('/convocatoria/calificacion-meritos', ['as' => 'meritRating', 'uses' => 'Convocatoria\MeritoController@meritRating']);
Route::post('/convocatoria/calificacion-meritos', ['as' => 'meritRatingValid', 'uses' => 'Convocatoria\MeritoController@meritRatingValid']);
Route::put('/convocatoria/calificacion-meritos', ['as' => 'meritRatingUpdate', 'uses' => 'Convocatoria\MeritoController@meritRatingUpdate']);
Route::delete('/convocatoria/calificacion-meritos/{id}', ['as' => 'meritRatingDelete', 'uses' => 'Convocatoria\MeritoController@meritRatingDelete']);

Route::get('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRating', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRating']);
Route::post('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingTematicValid', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicValid']);
Route::put('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingTematicUpdate', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicUpdate']);
Route::delete('/convocatoria/calificacion-conocimientos/{id}', ['as' => 'knowledgeRatingTematicDelete', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingTematicDelete']);
Route::put('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingAuxUpdate', 'uses' => 'Convocatoria\ConocimientoController@knowledgeRatingAuxUpdate']);

