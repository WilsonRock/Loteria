<?php

namespace App\Http\Controllers;

use App\Models\Nodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\services\RequestService;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $request_service;

    public function __construct(
        RequestService $request_service
    )
    {
        $this->request_service = $request_service;
    }
    public function getSalesQr(Request $request)
    {
        try {
            $validate = $request->validate([
                'product_id' => '',
                'query_type' => ''
            ]);
           
            return response()->json(['data' => $this->request_service->Qr($request)], 201);
          
        } catch (\Throwable $th) {
            return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
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
