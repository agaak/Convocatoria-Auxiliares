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

Route::get('/', ['as' => 'home',function () {
    return view('home');
}]);

Route::get('/convocatoria', ['as' => 'convocatory',function () {
    return view('convocatory');
}]);

Route::get('/resultados', ['as' => 'results',function () {
    return view('results');
}]);

Route::get('/admision', ['as' => 'admission',function () {
    return view('admission');
}]);

Route::get('/convocatoria/titulo-descripcion', ['as' => 'titleDescription',function () {
    return view('convocatory.titleDescription');
}]);

Route::get('/convocatoria/requerimientos', ['as' => 'request',function () {
    return view('convocatory.request');
}]);

Route::get('/convocatoria/requisitos', ['as' => 'requirement',function () {
    return view('convocatory.requirements');
}]);

Route::get('/convocatoria/fechas-importantes', ['as' => 'importantDates',function () {
    return view('convocatory.importantDates');
}]);

Route::get('/convocatoria/calificacion-meritos', ['as' => 'meritRating',function () {
    return view('convocatory.meritRating');
}]);

Route::get('/convocatoria/calificacion-conocimientos', ['as' => 'knowledgeRating',function () {
    return view('convocatory.knowledgeRating');
}]);