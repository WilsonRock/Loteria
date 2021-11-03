<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use App\Models\NodeHasNodes;
use App\Models\Nodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $entities = DB::table('entities')
            ->where('entities.active', true)
            ->get();

            return response()->json(['data' => $entities], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'type_node_id' => 'required',
            'zona_horaria' => 'required',
            'moneda' => 'required',
            'nombre_contacto' => 'required',
            'telefono_contacto' => 'required',
            'email' => 'required|email',
            'pais' => 'required',
            'zona' => 'required',
            'nit' => 'required',
            'balance' => 'required',
        ]);
        try {
            $node = Nodes::create(['type_node_id' => $request->type_node_id]);
            $entity = Entities::create([
                'node_id' => $node->id,
                'zona_horaria' => $request->zona_horaria,
                'moneda' => $request->moneda,
                'nombre_contacto' => $request->nombre_contacto,
                'telefono_contacto' => $request->telefono_contacto,
                'email' => $request->email,
                'pais' => $request->pais,
                'zona' => $request->zona,
                'nit' => $request->nit,
                'balance' => $request->balance,
                'permisos' => json_encode($request->permisos)
            ]);
            $has_node = NodeHasNodes::create([
                'padre_id' => Auth::user()->node_id,
                'hijo_id' => $node->id
            ]);
            return response()->json(['message' => 'Entidad creada con éxito', 'data' => $entity], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities  $entities
     * @return \Illuminate\Http\Response
     */
    public function show(Entities $entities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entities  $entities
     * @return \Illuminate\Http\Response
     */
    public function edit(Entities $entities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entities  $entities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entities $entities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entities  $entities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entities $entities)
    {
        //
    }
}
