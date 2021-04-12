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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::group(['middleware' => ['role_or_permission:Super Admin|plaza.crear.usuario']], function() {
        Route::resource('plazas', 'Plaza\PlazaController')->except(['create', 'edit']);
        Route::resource('plazas.users', 'Plaza\PlazaUserController')->except(['create', 'edit'])->middleware('verificar_superadmin');
    });

    Route::group(['middleware' => ['role:Super Admin']], function() {
        Route::post('plazas/{plaza}/users/admin', 'Plaza\PlazaUserController@StoreAdmin')->name('plaza.users.admin.store');
    });

    Route::group(['middleware' => ['role:Super Admin|Administrador Plaza']], function() {
        Route::post('plazas/{plaza}/users/{usuario}/balance/assign', 'User\UsuarioBalanceController@store')->name('plaza.users.balance.asignar');
        Route::post('plazas/{plaza}/plaza', 'Plaza\Sons\PlazaController@store')->name('plazas.plaza.store')->middleware('verificar_superadmin');
    });
});