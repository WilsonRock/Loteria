<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use Exception;
use Illuminate\Http\Request;

class RafflesController extends Controller
{
    function combination($size, $elements)
    {
        if ($size > 0) {
            $combinations = array();
            $res = $this->combination($size - 1, $elements);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $output = $this->combination(5, $numbers);
        var_dump($output);
        return response()->json($output, 200);
    }

    public function reservar(Request $request)
    {
        try {
            $sorteo = Raffles::where('node_id', $request->node_id)->first();

            $sorteo->update(['reservados' => '']);

            return response()->json([]);
        } catch(Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
