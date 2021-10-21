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
    Route::post('type-node', 'TypeNodesController@create');
    Route::get('type-node', 'TypeNodesController@index');
    Route::post('node', 'NodesController@create');
    Route::get('node', 'NodesController@index');
  });
});
