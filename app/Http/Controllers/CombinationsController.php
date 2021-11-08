<?php

namespace App\Http\Controllers;

use App\Models\Combinations;
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
            $combinations = DB::table('combinations')
            ->where('cifras', $request->cifras)
            ->get();

            $rand = array();
            $x = 0;
            while ($x < (10 * $request->oportunidades)) {
                $num_aleatorio = rand($combinations->first()->id, $combinations->last()->id);
                if (!in_array($num_aleatorio, $rand)) {
                  array_push($rand, $num_aleatorio);
                  $x++;
                }
            }

            $combination = array();
            foreach ($rand as $random) {
                array_push($combination, ...$combinations->where('id', $random));
            }

            return response()->json(['data' => $combination]);
        } catch(\Exception $e) {
            return response()->json(['error' => $e], 500);
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
            Log::info($combinations);
            
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
        return response()->json(['data' => $combinations]);
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
