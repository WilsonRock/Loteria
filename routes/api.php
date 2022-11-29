<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('login', 'Auth\LoginController@login');
Route::post('qr', 'QrController@index');
Route::get('qrg','QrController@getSalesQr');
Route::get('video', 'VideoController@index');
Route::post('video', 'VideoController@create');

Route::group(['prefix' => 'v1'], function () {
  Route::group(['middleware' => ['auth:api']], function () {
    Route::post('usuario', 'User\UserController@create');
    Route::get('clientes', 'User\UserController@clientes');
    Route::get('usuarios', 'User\UserController@index');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('tipo-nodo', 'TypeNodesController@create');
    Route::get('tipo-nodo', 'TypeNodesController@index');
    Route::post('entidad', 'EntitiesController@create');
    Route::get('searchEntities','EntitiesController@searchEntities');
    Route::post('juego', 'GamesController@create');
    Route::get('juego', 'GamesController@index');
    Route::get('rules', 'GamesController@rules');    
    Route::post('CrearRechage','SalesController@getPrueba');
    Route::get('nodo', 'NodesController@index');
    Route::post('venta', 'SalesController@create');
    Route::post('setWinners', 'SalesController@setWinners');
    Route::get('getWinners', 'SalesController@getWinners');
    Route::get('ventas', 'SalesController@index');
    Route::post('combinaciones', 'CombinationsController@create');
    Route::get('obtener-combinaciones', 'CombinationsController@index');
    Route::get('searchU', 'User\UserController@searchU');
    Route::post('sorteo', 'RafflesController@create');
    Route::post('reservar', 'RafflesController@reservar');
    Route::post('eliminar-reservados', 'CombinationsController@delete_reservados');
    Route::get('/export/sales', [App\Http\Controllers\ExcelController::class, 'SalesExport']);
    Route::get('/export/sales/xlsx', [App\Http\Controllers\ExcelController::class, 'salesExcelExport']);
    Route::get('/export/sales/csv', [App\Http\Controllers\ExcelController::class, 'salesCsvExport']);
    Route::get('/conciliation/{commerce}', 'TurnoverController@conciliation')->name('.conciliation'); //aqui
    Route::get('/conciliation/{commerce}/children', 'TurnoverController@conciliation')->name('.conciliation.children');//aqui
    Route::get('video', 'VideoController@index');
    Route::post('video', 'VideoController@create');
    Route::delete('videos/{id}', 'VideosController@destroy');
    Route::put('videos/{id}', 'VideosController@update');
    Route::post('payment', 'GamesController@payments');
  });
});
