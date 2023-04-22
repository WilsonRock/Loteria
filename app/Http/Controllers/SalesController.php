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
use App\services\RequestService;
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
           
            return response()->json(['data' => $this->request_service->SalesQuery($request)], 201);
   
        } catch (\Throwable $th) {
            return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
        }
 
    }
    public function RafflesQuery(Request $request)
    {
      try {
       
            return response()->json([$this->request_service->RafflesQuery($request)], 201);
   
        } catch (\Throwable $th) {
            return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
        }
 
    }
    public function getPrueba(Request $request)
    {
        try {

            $response = $this->request_service->getPrueba($request);

            $RafflesQuery = $this->request_service->RafflesQuery($request);
            return response()->json(['data' => $response, 'Raffle' => $RafflesQuery], 200);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $message = $response->getBody();
                $statusCode = $response->getStatusCode();
            } else {
                $message = $e->getMessage();
                $statusCode = 500;
            }
    
            return response()->json(['error' => $message], $statusCode);
        } catch (\Exception $e) {
            return response()->json(['error' => 'El provider no esta activo'], 400);
        }
    }
    

    public function setWinners(Request $request)
    { 
        try {
            $resp = $this->request_service->generateWinner($request);
            return response()->json(['message' => 'Ganadores', 'data' => [$resp]], 201); 
           } catch (\Throwable $th) {
            echo($th);
            return response()->json(['error' => 'El provider no esta activo'], 400);
           }
    }
    public function getWinners(Request $request)
    { 
        try {
           //$a= $this->request_service->getWinners($request);
          //  response()->json(['data' => $this->request_service->getWinners($request)], 200);
            //dd($a);
            $resp = $this->request_service->getWinners($request);
            return response()->json(['message' => 'Ganadores', 'data' => [$resp]], 201);   
        
        } catch (\Throwable $th) {
            echo($th);
            return response()->json(['error' => 'El provider no esta activo'], 400);
           }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sum( $request)
    {
     $f1 = $f2 = date('Y-m-d H:i:s');   
     if(! is_null($request->initial_date) && ! empty($request->initial_date) && ! is_null($request->final_date) || ! empty($request->final_date) ){
            $f1 = $request->initial_date;
            $f2 = $request->final_date;
      }
     // $ventas =  Sales::select(\DB::raw("SUM(cast(sales.precio)) AS Total " ))->get();
     $ventas=    Sales::select(DB::raw('sum(cast(precio as double precision))'))->get();
     $premios=    Sales::select(DB::raw('sum(cast(premio as double precision))'))->get();


    // $premios =  Sales::select(\DB::raw("SUM(cast(sales.precio AS integer)) AS Total"))->get();
     foreach($ventas as $el => $data) {
        $req[$el] = [
           $total = $data->total,
        ];      
     }
     foreach($premios as $el => $data) {
        $req[$el] = [
           $total = $data->total,
        ];      
     }
      
    return json_decode($ventas, true);
    }
    public function index(Request $request)
    {
        try {
          // date('Y-m-d H:i:s'),
           $totalVenta=$this->sum($request);
           $f1 = $f2 = date('Y-m-d H:i:s');
            if(! is_null($request->initial_date) && ! empty($request->initial_date) && ! is_null($request->final_date) || ! empty($request->final_date) ){
                $f1 = $request->initial_date;
                $f2 = $request->final_date;
            }
            $size = $request->size ?? 10;
            $sales = DB::table('sales')
               ->select('sales.*', 'wallets.*','users.nombres as nombre_cliente', 'users.apellidos as apellidos_cliente', 'vendedor.nombres as nombre_Vendedor', 'vendedor.apellidos as apellidos_Vendedor')
                ->whereBetween('sales.updated_at', [$f1, $f2])
                ->join('wallets', 'wallets.venta_id', '=', 'sales.id')
                ->join('users', 'users.id', 'sales.cliente_id')
                ->join('users as vendedor', 'vendedor.id', "=", 'sales.vendedor_id')
                ->where('wallets.tipo', $request->Type)
              //  ->where('wallets.tipo', 'premio')
                ->paginate($size);
            return response()->json(['data' => $sales,'Total_ventas'=>$totalVenta], 200);
        } catch (Exception $e) {
           // dd($e);
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
                if($request->codigoprovider!=='1'){
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
                if ($game->active === true && date('Y-m-d') <= $game->fecha_final) {
                  
                    $raffle = Raffles::where('node_id', $request->juego_node_id)->first();
                    if (isset($raffle->reservados_vendidos)&& $request->codigoprovider!=='1') {
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
                        if($request->codigoprovider=='1'){
                            $resp = $this->SalesQuery($request);
                            $resp2 = $this->RafflesQuery($request);
                            $vendidos = json_decode($resp->content(),true);
                            $dataArray = json_decode($vendidos['data'], true);
                        }
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
                            'state'=>'vendido',
                            'id_sale_provider'=>$dataArray['id'],
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
