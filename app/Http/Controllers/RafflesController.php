<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RafflesController extends Controller
{
    public function reservar(Request $request)
    {
        try {
            $raffle = Raffles::where('node_id', $request->node_id)->first();

            if (isset($raffle->reservados_vendidos)) {
                $reservar = json_decode($raffle->reservados_vendidos);
                
                foreach($reservar as $element) {
                    foreach($request->reservados as $el) {
                        /* return response()->json(['element' => $element, 'comb' => $el]); */
                        if($element->numero == $el['numero']) {
                            return response()->json(['error' => 'El boleto se encuentra reservado o vendido'], 400);
                        }
                    }
                }

                array_Push($reservar, ...$request->reservados);
                $raffle->update([
                    'reservados_vendidos' => json_encode($reservar)
                ]);
            } else {
                $raffle->update([
                    'reservados_vendidos' => json_encode($request->reservados)
                ]);
            }
            
            return response()->json(['message' => 'Boleto reservado con éxito','data' => $raffle], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
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
     * @param  \App\Models\Raffles  $raffles
     * @return \Illuminate\Http\Response
     */
    public function show(Raffles $raffles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Raffles  $raffles
     * @return \Illuminate\Http\Response
     */
    public function edit(Raffles $raffles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Raffles  $raffles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raffles $raffles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raffles  $raffles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raffles $raffles)
    {
        //
    }
}
