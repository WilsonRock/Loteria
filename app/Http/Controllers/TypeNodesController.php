<?php

namespace App\Http\Controllers;

use App\Models\TypeNodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TypeNodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(DB::table('type_nodes')
                ->where('type_nodes.active', true)
                ->get());
        } catch (\Exception $e) {
            Log::error($e);
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
            $type_node = TypeNodes::create($request->all());
            return response($type_node, 200);
        } catch (\Exception $e) {
            Log::error($e);
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
     * @param  \App\Models\TypeNodes  $typeNodes
     * @return \Illuminate\Http\Response
     */
    public function show(TypeNodes $typeNodes)
    {
        /* try {
            return response()->json(DB::table('type_nodes')
                ->where('type_nodes.active', true)
                ->get());
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e], 500);
        } */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeNodes  $typeNodes
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeNodes $typeNodes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeNodes  $typeNodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeNodes $typeNodes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeNodes  $typeNodes
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeNodes $typeNodes)
    {
        //
    }
}
