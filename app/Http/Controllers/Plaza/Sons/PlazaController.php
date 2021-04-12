<?php

namespace App\Http\Controllers\Plaza\Sons;

use App\Models\Plaza;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PlazaController extends ApiController
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
        $reglas = [
            'nombre' => 'required|string',
            'municipio_id' => 'required|exists:municipios,id',
            'estado_id' => 'required|exists:estados,id'
        ];

        $campos = $this->validate($request,$reglas);
        $campos['parent_id'] = $plaza->id;
        $plazaNueva = Plaza::create($campos);

        return $this->showOne($plazaNueva, 201);
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
