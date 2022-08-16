<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use App\Models\Games;
use App\Models\Nodes;
use App\Models\Raffles;
use App\Models\Sales;
use App\Models\Wallets;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\RequestService;
class SalesController extends Controller
{
 
    protected $request_service;

    public function __construct(
        RequestService $request_service
    )
    {
        $this->request_service = $request_service;
    }

    public function SalesQuery(Request $request)
    {
        try {
            $validate = $request->validate([
                'product_id' => '',
                'query_type' => ''
            ]);
           $sale = $this->request_service->SalesQuery($request);
            return response()->json(['message' => 'Venta realizada exitosamente', 'data' => [$sale]], 201);
   
        } catch (\Throwable $th) {
            return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
        }
 
    }
    public function getPrueba(Request $request)
    { 
       try {
        response()->json(['data' => $this->request_service->getPrueba($request)], 200);
       } catch (\Throwable $th) {
        return response()->json(['error' => 'El provider no esta activo'], 400);
       }
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $size = $request->size ?? 10;
            $sales = DB::table('sales')
                ->select('sales.*', 'wallets.*', 'users.nombres as nombre_cliente', 'users.apellidos as apellidos_cliente')
                ->join('wallets', 'wallets.venta_id', '=', 'sales.id')
                /* ->where('sales.vendedor_id', Auth::user()->id) */
                ->join('users', 'users.id', 'sales.cliente_id')
                ->where('wallets.tipo', 'venta')
                ->paginate($size);
            return response()->json(['data' => $sales], 200);
        } catch (Exception $e) {
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
                $entity = Entities::where('node_id', Auth::user()->node_id)->first();
                $game = Games::where('node_id', $request->juego_node_id)->first();
                if($request->codigoprovider!=='2'){
                    $req = $request->vendidos;
                    foreach($req as $el => $data) {
                        $req[$el] = [
                            'numero' => $data,
                            'fecha' => date('Y-m-d H:i:s'),
                            'estado' =>"vendido"
                        ];
                }
                    /* $req[$el]['fecha'] = date('Y-m-d H:i:s');
                    $req[$el]['estado'] = "vendido"; */
                }
                else{
                    $req = [
                        'numero' =>  $request->bet_number,
                        'fecha' => date('Y-m-d H:i:s'),
                        'estado' =>"vendido"
                    ];
                }
                if ($game->active == true && date('Y-m-d') <= $game->fecha_final) {
                   //echo($request);
                    $raffle = Raffles::where('node_id', $request->juego_node_id)->first();
                    if (isset($raffle->reservados_vendidos)&& $request->codigoprovider!=='2') {
                        $vendidos = json_decode($raffle->reservados_vendidos);
                        foreach ($req as $el) {
                            foreach ($vendidos as $element) {
                                /* return response()->json(['element' => $element, 'comb' => $el]); */
                                if ($element->numero == $el['numero'] && $element->estado == 'vendido') {
                                    return response()->json(['error' => 'El boleto se encuentra vendido'], 400);
                                }
                            }
                        }
    
                        array_Push($vendidos, ...$req);
                        $raffle->update([
                            'reservados_vendidos' => json_encode($vendidos)
                        ]);
                    } else {
                        $raffle->update([
                            'reservados_vendidos' => json_encode($req)
                        ]);
                    }
    
                    if ($entity->balance >= $request->valor) {
                        $commission = ($request->valor * $game->comision) / 100;
                        $sale = Sales::create([
                            'precio' => $request->valor,
                            'premio' => $game->premio,
                            'comision' => $commission,
                            'caracteristicas' => json_encode($req),
                            'vendedor_id' => Auth::user()->id,
                            'cliente_id' => $request->cliente_id,
                            'node_id' => $request->juego_node_id,
                        ]);
    
                        $initial_balance = (float)$entity->balance;
                        $final_balance = $entity->balance - $request->valor;
                        $entity->update(['balance' => $final_balance + $commission]);
    
                        $wallet = Wallets::create([
                            'tipo' => 'venta',
                            'saldo_inicial' => $initial_balance,
                            'saldo_final' => $final_balance,
                            'node_id' => $game->node_id,
                            'usuario_id' => Auth::user()->id,
                            'venta_id' => $sale->id
                        ]);
    
                        Wallets::create([
                            'tipo' => 'comision',
                            'saldo_inicial' => $initial_balance - $request->valor,
                            'saldo_final' => $final_balance + $commission,
                            'node_id' => $game->node_id,
                            'usuario_id' => Auth::user()->id,
                            'venta_id' => $sale->id,
                            'parent_id' => $wallet->id
                        ]);
                       $resp = $this->SalesQuery($request);
                        return response()->json(['message' => 'Venta realizada exitosamente', 'data' => [$sale]], 201);
                        
                    } else {
                        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta'], 400);
                    }
                } else {
                    return response()->json(['error' => 'El juego no se encuentra disponible'], 400);
            }
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
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
