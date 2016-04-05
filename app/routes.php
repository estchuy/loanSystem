<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('layout.content');
});
//Clientes
Route::get('/clients', 'ClientsController@index');
Route::get('/calculoCuotas', 'ClientsController@calculoCuotas');
Route::get('/clients/new', 'ClientsController@create');
Route::get('clients/{id}/edit', 'ClientsController@edit');
Route::post('/client/save', 'ClientsController@store');
//Prestamos
Route::get('/loan/{id}/new', 'LoansController@create');
Route::post('/loan/save', 'LoansController@store');
Route::get('/loan/apply', 'LoansController@applyPayment');
Route::get('/loan/historico', 'LoansController@history');
//Reportes
Route::get('/reporte/consolidado', 'LoansController@consolidado');
Route::get('/reporte/detallado', 'LoansController@detallado');
Route::get('/reporte/periodo', 'LoansController@periodo');
Route::post('/reporte/download', 'LoansController@download');