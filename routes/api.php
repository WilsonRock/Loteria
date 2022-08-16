<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EntitiesController;
use App\Models\Entities;

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
    Route::post('CrearRechage','SalesController@getPrueba');
    Route::get('nodo', 'NodesController@index');
    Route::post('venta', 'SalesController@create');
    Route::get('ventas', 'SalesController@index');
    Route::post('combinaciones', 'CombinationsController@create');
    Route::get('obtener-combinaciones', 'CombinationsController@index');
    Route::get('searchU', 'User\UserController@searchU');
    Route::post('sorteo', 'RafflesController@create');
    Route::post('reservar', 'RafflesController@reservar');
    Route::post('eliminar-reservados', 'CombinationsController@delete_reservados');
  });
});
