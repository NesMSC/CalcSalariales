<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('layouts.principal');
});

Route::get('/empleados', 'empleadoController@index');
Route::post('/empleados/agregarNuevo', 'empleadoController@store');
Route::post('/empleados/salarioTabla', 'empleadoController@salarioTabla');
Route::get('/empleados/beneficios', 'empleadoController@beneficios');
Route::get('/empleados/primaProfesional', 'empleadoController@primaProfesional');
Route::get('/empleados/primaAntiguedad', 'empleadoController@primaAntiguedad');
Route::get('/empleados/descuentos', 'empleadoController@descuentos');
Route::get('/empleados/editarEmpleado/{id}', 'empleadoController@edit');
Route::put('/empleados/actualizarEmpleado', 'empleadoController@update');

Route::get('/docentes', 'docenteController@index');
Route::post('/docentes/agregarNuevo', 'docenteController@store');
Route::get('/docentes/mostrarDocente/{id}', 'docenteController@show');
Route::put('/docentes/actualizarDocente', 'docenteController@update');
Route::get('/docentes/aggAdmin', 'docenteController@buscarPadmin');
Route::post('/docentes/registrarAdmin', 'docenteController@registrarAdmin');
Route::put('/docentes/actualizarDocenteAdmin', 'docenteController@actualizarDocenteAdmin');
Route::get('/docentes/retirarDocenteAdmin/{id}', 'docenteController@retirarDocenteAdmin');







