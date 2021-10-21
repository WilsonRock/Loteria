<?php

namespace App\Http\Controllers;

use App\Models\Nodes;
use Illuminate\Http\Request;
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
            return response()->json(DB::table('nodes')
                ->where('nodes.active', true)
                ->get());
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
            return response($type_node, 200);
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
