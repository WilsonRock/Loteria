<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Raffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RafflesController extends Controller
{
    public function reservar(Request $request)
    {
        /* $reserva = $request->reservados;
        foreach($reserva as $i => $data) {
            $reserva[$i] = ['numero' => $data];
        }
        return response()->json($reserva); */
        try {
            $raffle = Raffles::where('node_id', $request->node_id)->first();
            $req = $request->reservados;
            foreach($req as $el => $data) {
                $req[$el] = [
                    'numero' => $data,
                    'fecha' => date('Y-m-d H:i:s'),
                    'estado' =>"reservado"
                ];
                /* $req[$el]['fecha'] = date('Y-m-d H:i:s');
                $req[$el]['estado'] = "reservado"; */
            }

            if (isset($raffle->reservados_vendidos)) {
                $reservar = json_decode($raffle->reservados_vendidos);
                foreach($req as $el => $data) {
                    foreach($reservar as $element) {
                        if($element->numero == $req[$el]['numero']) {
                            return response()->json(['error' => 'El boleto se encuentra reservado o vendido'], 400);
                        }
                    }
                }
                array_Push($reservar, ...$req);
                //array_Push($reservar, ...$request->reservados);
                $raffle->update([
                    'reservados_vendidos' => json_encode($reservar)
                ]);
            } else {
                $raffle->update([
                    'reservados_vendidos' => json_encode($req)
                ]);
            }
            
            return response()->json(['message' => 'Boleto reservado con éxito', 'data' => $req], 200);
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
