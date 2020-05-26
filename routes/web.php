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

Route::get('/convocatoria/titulo-descripcion', ['as' => 'titleDescription', 'uses' => 'Pages\Convocatory@titleDescription']);
Route::put('/convocatoria/titulo-descripcion', ['as' => 'titleDescriptionValid', 'uses' => 'Pages\Convocatory@titleDescriptionValid']);
Route::get('/convocatoria/titulo-descripcionGet', ['as' => 'titleDescriptionGet', 'uses' => 'Pages\Convocatory@titleDescriptionGet']);

Route::get('/convocatoria/requerimientos', ['as' => 'requests', 'uses' => 'Pages\Convocatory@requests']);
Route::post('/convocatoria/requerimientos', ['as' => 'requestValid', 'uses' => 'Pages\Convocatory@requestValid']);
Route::put('/convocatoria/requerimientos', ['as' => 'requestUpdate', 'uses' => 'Pages\Convocatory@requestUpdate']);
Route::delete('/convocatoria/requerimientos/{id}', ['as' => 'requestDelete', 'uses' => 'Pages\Convocatory@requestDelete']);

Route::get('/convocatoria/requisitos', ['as' => 'requirement', 'uses' => 'Pages\Convocatory@requirements']);
Route::post('/convocatoria/requisitos', ['as' => 'requirementValid', 'uses' => 'Pages\Convocatory@requirementsValid']);
Route::put('/convocatoria/requisitos', ['as' => 'requirementUpdate', 'uses' => 'Pages\Convocatory@requirementUpdate']);
Route::delete('/convocatoria/requisitos/{id}', ['as' => 'requirementDelete', 'uses' => 'Pages\Convocatory@requirementDelete']);

Route::get('/convocatoria/fechas-importantes', ['as' => 'importantDates', 'uses' => 'Pages\Convocatory@importantDates']);
Route::post('/convocatoria/fechas-importantes', ['as' => 'importantDatesValid', 'uses' => 'Pages\Convocatory@importantDatesValid']);
Route::put('/convocatoria/fechas-importantes', ['as' => 'importantDateSave', 'uses' => 'Pages\Convocatory@importantDateSave']);
Route::delete('/convocatoria/fechas-importantes/{id}', ['as' => 'importantDatesDelete', 'uses' => 'Pages\Convocatory@importantDatesDelete']);

Route::get('/convocatoria/calificacion-meritos', ['as' => 'meritRating', 'uses' => 'Pages\Convocatory@meritRating']);
Route::post('/convocatoria/calificacion-meritos', ['as' => 'meritRatingValid', 'uses' => 'Pages\Convocatory@meritRatingValid']);
Route::put('/convocatoria/calificacion-meritos', ['as' => 'meritRatingUpdate', 'uses' => 'Pages\Convocatory@meritRatingUpdate']);
Route::delete('/convocatoria/calificacion-meritos/{id}', ['as' => 'meritRatingDelete', 'uses' => 'Pages\Convocatory@meritRatingDelete']);

Route::get('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRating', 'uses' => 'Pages\Convocatory@knowledgeRating']);
Route::post('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingTematicValid', 'uses' => 'Pages\Convocatory@knowledgeRatingTematicValid']);
Route::put('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingTematicUpdate', 'uses' => 'Pages\Convocatory@knowledgeRatingTematicUpdate']);
Route::delete('/convocatoria/calificacion-conocimientos/{id}', ['as' => 'knowledgeRatingTematicDelete', 'uses' => 'Pages\Convocatory@knowledgeRatingTematicDelete']);
Route::put('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRatingAuxUpdate', 'uses' => 'Pages\Convocatory@knowledgeRatingAuxUpdate']);

