<?php

namespace App\Http\Controllers\Plaza;

use App\Models\User;
use App\Models\Plaza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Models\Estado;
use App\Models\SaldoActual;
use Illuminate\Support\Facades\Auth;

class PlazaUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Plaza $plaza)
    {
        $rules = [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'documento' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'required|string',
            'plaza_id' => 'required|exists:plazas,id'
        ];
        if(!Auth::user()->hasRole('Super Admin')) {
            if($plaza->id !== Auth::user()->plaza->id) {
                return $this->errorResponse('No cuenta con permisos para crear un usuario para otra plaza', 403);
            }
        }

        //Organizamos datos para crear el usuario
        $validate = $this->validate($request, $rules);
        $validate['password'] = Hash::make('password');
        $validate['estado_id'] = Estado::where('nombre', Estado::INACTIVO)->first()->id;

        //creamos el usuario
        $usuario = User::create($validate);

        //asignamos el rol correspondiente
        $usuario->assignRole('Vendedor');

        $saldoActual = new SaldoActual();
        $saldoActual->saldo = 0;
        $saldoActual->deuda = 0;

        //asignamos saldo al usuario
        $usuario->saldoActual()->save($saldoActual);
        //SaldoActual::create(SaldoActual::obtenerSaldoPorDefecto($usuario->id));

        return $this->showOne($usuario, 201);
    }

    /**
     * Store a newly created resource in storage.
     * Creamos un usuario con rol administrador
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeAdmin(Request $request, Plaza $plaza)
    {
        $rules = [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'documento' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'required|string',
            'plaza_id' => 'required|exists:plazas,id'
        ];
        
        $validate = $this->validate($request, $rules);
        $validate['password'] = Hash::make('password');
        $validate['estado_id'] = Estado::where('nombre', Estado::ACTIVO)->first()->id;
        $usuario = User::create($validate);

        $usuario->assignRole('Administrador Plaza');

        $saldoActual = new SaldoActual();
        $saldoActual->saldo = 0;
        $saldoActual->deuda = 0;

        //asignamos saldo al usuario
        $usuario->plaza->saldoActual()->save($saldoActual);
        
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
