<?php

namespace App\Http\Controllers;

use App\Models\Nodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $node = Nodes::find(Auth::user()->node_id);
            if(!is_null($node)){
                $entities = DB::table('entities')
                /* ->join('node_has_nodes', 'node_has_nodes.hijo_id', '=', 'entities.node_id') */
                ->join('nodes', 'nodes.id', '=', 'entities.node_id')
                /* ->where('node_has_nodes.padre_id', '=', $node->id) */
                ->get();

                $games = DB::table('games')
                ->join('node_has_nodes', 'node_has_nodes.hijo_id', '=', 'games.node_id')
                ->join('nodes', 'nodes.id', '=', 'games.node_id')
                ->where('node_has_nodes.padre_id', '=', $node->id)
                ->get();

                /* $games = DB::table('nodes')
                ->join('node_has_nodes', 'node_has_nodes.hijo_id', '=', 'nodes.id')
                ->join('games', 'games.node_id', '=', 'nodes.id')
                ->get(); */

                return response()->json([
                    'node' => $node,
                    'entidades' => $entities,
                    'juegos' => $games
                ], 200);
            } else {
                return response()->json(['error' => 'Commerce not found'], 404);
            }
            /* return response()->json($node_id, 200); */
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
        try {
            $type_node = Nodes::create($request->all());
            return response()->json(['message' => 'Tipo de nodo creado con éxito', 'data' => $type_node], 201);
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
     * @param  \App\Models\Nodes  $nodes
     * @return \Illuminate\Http\Response
     */
    public function show(Nodes $nodes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nodes  $nodes
     * @return \Illuminate\Http\Response
     */
    public function edit(Nodes $nodes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nodes  $nodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nodes $nodes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nodes  $nodes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nodes $nodes)
    {
        //
    }
}
