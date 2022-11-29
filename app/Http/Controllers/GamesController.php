<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\NodeHasNodes;
use App\Models\Nodes;
use App\Models\Raffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\services\RequestService;
use App\Models\Entities;
use App\Models\Sales;
use App\Models\Wallets;
use Exception;


class GamesController extends Controller
{
    protected $request_service;

    public function __construct(
        RequestService $request_service
    )
    {
        $this->request_service = $request_service;
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $games = DB::table('games')
            ->where('active', true)
            ->get();
            return response()->json(['data' => $games], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function rules(Request $request)
    {
        try {
            response()->json(['data' => $this->request_service->rules($request)], 200);

             } catch (\Throwable $th) {
              echo($th);
              return response()->json(['error' => 'El provider no esta activo'], 400);
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
            'titulo' => 'required',
            'identificacion' => 'required',
            'contacto' => 'required',
            'cifras' => 'required',
            'oportunidades' => 'required',
            'premio' => 'required',
            'precio' => 'required',
            'comision' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date'
        ]);
        try {
            $node = Nodes::create(['type_node_id' => $request->type_node_id]);
            $game = Games::create([
                'titulo' => $request->titulo,
                'identificacion' => $request->identificacion,
                'contacto' => $request->contacto,
                'cifras' => $request->cifras,
                'oportunidades' => $request->oportunidades,
                'premio' => $request->premio,
                'precio' => $request->precio,
                'comision' => $request->comision,
                'provider' =>$request->provider,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_final' => $request->fecha_final,
                'node_id' => $node->id,
            ]);
            Raffles::create([
                'node_id' => $node->id
            ]);
            NodeHasNodes::create([
                'padre_id' => Auth::user()->node_id,
                'hijo_id' => $node->id
            ]);
            return response()->json(['message' => 'Juego creado con éxito','data' => $game], 201);
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
     * @param  \App\Models\Games  $games
     * @return \Illuminate\Http\Response
     */
    public function show(Games $games)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Games  $games
     * @return \Illuminate\Http\Response
     */
    public function edit(Games $games)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Games  $games
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Games $games)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Games  $games
     * @return \Illuminate\Http\Response
     */
    public function destroy(Games $games)
    {
        //
    }

    public function paymentProvider(Request $request)
    {
       
        try {
            return response()->json(['data' => $this->request_service->Payment($request)], 201);
          
        } catch (\Throwable $th) {
            return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
        }
 
    }

    public function payments(Request $request)
    {
     try {
        $entity = Entities::where('node_id', Auth::user()->node_id)->first();
        $game = Games::where('node_id', $request->juego_node_id)->first();


            $req = [
                'numero' =>  $request->bet_number,
                'fecha' => date('Y-m-d H:i:s'),
                'estado' =>"vendido"
            ];


            if ($entity->balance >= $request->valor) {
              //  $commission = ($request->valor * $game->comision) / 100;
                $sale = Sales::create([
                   'precio' => "0",
                    'premio' => "0",
                    'comision' => "0",
                    'caracteristicas' => json_encode("Pago de premio"),
                    'vendedor_id' => Auth::user()->id,
                    'cliente_id' => "f3b5dd14-7d6f-41a7-b9f8-76a6994d6a8b",
                    'node_id' => 1,
                   // 'state'=>$request-> true,
                ]);

                $initial_balance = (float)$entity->balance;
                $final_balance = $entity->balance - $request->valor;
              //  $entity->update(['balance' => $final_balance + $commission]);

                $wallet = Wallets::create([
                    'tipo' => 'premio',
                    'saldo_inicial' => $initial_balance,
                    'saldo_final' => $final_balance,
                    'node_id' => 18,
                    'usuario_id' => Auth::user()->id, ///traer id del cliente
                    'venta_id' => $sale->id
                ]);
                $this->paymentProvider($request);

                return response()->json(['message' => 'Pago realizado exitosamente', 'data' => [$sale]], 201);
                

            }
        }
    
        
      catch (\Throwable $th) {
        //throw $th;
        echo ($th);
        return response()->json(['message' => 'Error'], 500);
     }               

 }
}
