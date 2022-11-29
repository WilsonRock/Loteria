<?php

namespace App\Http\Controllers;

use App\Models\Nodes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\services\RequestService;
use App\Models\Wallets;
use App\Models\Games;
use App\Models\NodeHasNodes;

use App\Models\Raffles;


use App\Models\Entities;
use App\Models\Sales;

use Exception;

use Illuminate\Http\Request;

class Payment extends Controller
{
    //
    protected $request_service;

    public function __construct(
        RequestService $request_service
    )
    {
        $this->request_service = $request_service;
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



