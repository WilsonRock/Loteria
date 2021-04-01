<?php

namespace App\Http\Controllers\Plaza;

use App\Models\Plaza;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use App\Supports\MessagesResponses;

class PlazaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plazas = Plaza::all();

        return $this->showAll($plazas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'municipio_id' => 'required|exists:municipios,id',
            'estado_id' => 'required|exists:estados,id',
            'parent_id' => 'required|exists:plazas,id'
        ];

        $campos = $this->validate($request,$reglas);
        $plaza = Plaza::create($campos);

        return $this->showOne($plaza, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Plaza $plaza)
    {
        return $this->showOne($plaza);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plaza $plaza)
    {
        $reglas = [
            'nombre' => 'string',
            'municipio_id' => 'exists:municipios,id',
            'estado_id' => 'exists:estados,id'
        ];

        $campos = $this->validate($request,$reglas);

        if ($request->has('nombre')) {
            $plaza->nombre = $campos['nombre'];
        }

        if ($request->has('municipio_id')) {
            $plaza->municipio_id = $campos['municipio_id'];
        }

        if ($request->has('estado_id')) {
            $plaza->estado_id = $campos['estado_id'];
        }

        if (!$plaza->isDirty()) {
            return $this->errorResponse(MessagesResponses::NO_EXISTEN_VALORES_PARA_ACTUALIZAR, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $plaza->save();

        return $this->showOne($plaza, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plaza $plaza)
    {
        //
    }
}
