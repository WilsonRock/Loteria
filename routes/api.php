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

Route::group(['prefix' => 'v1'], function () {
  Route::group(['middleware' => ['auth:api']], function () {
    Route::post('usuario', 'User\UserController@create');
    Route::get('clientes', 'User\UserController@clientes');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('tipo-nodo', 'TypeNodesController@create');
    Route::get('tipo-nodo', 'TypeNodesController@index');
    Route::post('entidad', 'EntitiesController@create');
    Route::post('juego', 'GamesController@create');
    Route::get('juego', 'GamesController@index');
    Route::get('nodo', 'NodesController@index');
    Route::post('venta', 'SalesController@create');
    Route::get('ventas', 'SalesController@index');
    Route::post('combinaciones', 'CombinationsController@create');
    Route::get('obtener-combinaciones', 'CombinationsController@index');
    Route::post('sorteo', 'RafflesController@create');
    Route::post('reservar', 'RafflesController@reservar');
  });
});
