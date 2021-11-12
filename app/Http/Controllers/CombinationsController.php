<?php

namespace App\Http\Controllers;

use App\Models\Combinations;
use App\Models\Games;
use App\Models\Raffles;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CombinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            
            $game = Games::where('node_id', $request->node_id)->first();
            $raffle = Raffles::where('node_id', $request->node_id)->first();
            $reservados = json_decode($raffle->reservados_vendidos);

            $combinations = DB::table('combinations')
            ->where('cifras', $game->cifras)
            ->get();

            $boleto = 10;
            
            if (isset($raffle->reservados_vendidos)){
                if((pow(10, $game->cifras) - sizeof($reservados)) < ($boleto * $game->oportunidades)) {
                    $boleto = (pow(10, $game->cifras) - sizeof($reservados)) / $game->oportunidades;
                }
                if(sizeof($reservados) == pow(10, $game->cifras) || ((pow(10, $game->cifras) - sizeof($reservados)) < $game->oportunidades)) {
                    return response()->json(['error' => 'No se encontraron números disponibles'], 400);
                }
            }
            
            $rand = array();
            $combination = array();
            $x = 0;
            while ($x < ($boleto * $game->oportunidades)) {
                $flag = false;
                $num_aleatorio = rand($combinations->first()->id, $combinations->last()->id);
                if (!in_array($num_aleatorio, $rand)) {
                    array_push($rand, $num_aleatorio);
                    if (isset($raffle->reservados_vendidos)) {
                        $comb = $combinations->where('id', $num_aleatorio)->first();
                        foreach($reservados as $element) {
                            /* return response()->json(['el'=>$element, 'com'=>$comb]); */
                            if($element->numero == $comb->combinaciones) {
                                $flag = true;
                            }
                        }
                        if($flag ==  false) {
                            array_push($combination, ...$combinations->where('id', $num_aleatorio));
                            $x++;
                        }
                    } else {
                        array_push($combination, ...$combinations->where('id', $num_aleatorio));
                        $x++;
                    }
                }
            }

            /* $combination = array();
            foreach ($rand as $random) {
                array_push($combination, ...$combinations->where('id', $random));
            } */

            return response()->json(['tamaño' => sizeof($combination), 'data' => $combination, 'oportunidades' => $game->oportunidades, 'valor_boleto' => $game->precio,], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }

    function generate_combination($size, $elements)
    {
        if ($size > 0) {
            $combinations = array();
            $res = $this->generate_combination($size - 1, $elements);
            foreach ($res as $ce) {
                foreach ($elements as $e) {
                    array_Push($combinations, $ce . $e);
                }
            }
            return $combinations;
        } else {
            return array('');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $elements = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $combinations = $this->generate_combination($request->cifras, $elements);
        foreach ($combinations as $combination) {
            Combinations::create([
                'combinaciones' => $combination,
                'cifras' => $request->cifras
            ]);
        }
        return response()->json(['data' => $combinations], 200);
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
     * @param  \App\Models\Combinations  $combinations
     * @return \Illuminate\Http\Response
     */
    public function show(Combinations $combinations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Combinations  $combinations
     * @return \Illuminate\Http\Response
     */
    public function edit(Combinations $combinations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Combinations  $combinations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Combinations $combinations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Combinations  $combinations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Combinations $combinations)
    {
        //
    }
}
