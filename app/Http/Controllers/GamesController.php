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
use App\Models\User;
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

    public  function createPayment(Request $request){
        try {
            
            $sales = Sales::where('id', $request->id)->first();
          //  dd($request->id);
            if(isset($sales)){
                $game = Games::where('node_id', $sales->node_id)->first();
                $user = User::where('id', $sales->cliente_id)->first();
                $provider=$this->getSalesState($sales['id_sale_provider']);
                $vendidos =  $provider->original;
                foreach ($vendidos as $i => $element){
                    $decode = $element;
                  }
                  if ($decode['stateSale']['description']==="ganado") {
                    //aprobar el llamado en la app para pagar el premio
                    $payment=true;
                    return response()->json(['sales' => $sales, 'Games' => $game,'Users' => $user,'Provider' => $decode,'Payment' => $payment], 200);
                    # code...
                  } else {
                    $payment=false;
                    return response()->json(['message' => ' Estado Apostado','sales' => $sales, 'Games' => $game,'Users' => $user,'Provider' => $decode,'Payment' => $payment], 201);
                    # code...
                    //return response()->json(['sales' => $sales, 'Games' => $game,'Users' => $user,'Provider' => $decode], 200);
                  }
                  
    
            }
            if(!$sales){
                return response()->json(['message' => 'No se encuentra el id de la venta'], 500);
            }
            //return response()->json(['sales' => $sales, 'Games' => $game,'Users' => $user,'Provider' => $decode], 200);
    
            //return $sales;
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error'], 500);
        }
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
 //   dd($request);
        $entity = Entities::where('node_id', Auth::user()->node_id)->first();
        $game = Games::where('node_id', $request->juego_node_id)->first();
        $user = User::where('id', $request->cliente_id)->first();
        $Wallets = Wallets::where('usuario_id', $request->cliente_id)->first();//busqueda de la billetera del Usuario
        
            $req = [
                'numero' =>  $request->bet_number,
                'fecha' => date('Y-m-d H:i:s'),
                'estado' =>"pagado"
            ];
            $payment_provider = $this->paymentProvider($request);
           
            $vendidos = json_decode($payment_provider->content(),true);
            foreach ($vendidos as $i => $element){
               $decode = json_decode($element,true);
             }

   //    dd($Wallets['saldo_inicial']+ 10);
            if ($entity->balance >= $decode['prizeWon']) {
            //    dd($decode);
              //  $commission = ($request->valor * $game->comision) / 100;
             // dd($Wallets); 
              $sale = Sales::create([
                   'precio' => "0",
                    'premio' => $decode['prizeWon'],
                    'comision' => "0",
                    'caracteristicas' => json_encode($decode),
                    'vendedor_id' => Auth::user()->id,
                    'cliente_id' => $request->cliente_id,
                    'node_id' => $request->node_id,
                   // 'state'=>$decode['stateSale'],
                     'state'=>"pagado",
                ]);


          
             if($Wallets){// valido saldo anterior 
                $initial_balanceUser = (float)$Wallets->saldo_inicial;
                $final_balanceUser = $initial_balanceUser+  $decode['prizeWon']; 
             }else{// en caso de no tener saldo anterior
                $initial_balanceUser = 0;
                $final_balanceUser = $initial_balanceUser+  $decode['prizeWon']; 
             }     

              $wallet = Wallets::create([
                    'tipo' => 'premio',
                    'saldo_inicial' => $initial_balanceUser,
                    'saldo_final' => $final_balanceUser,
                    'node_id' => $request->node_id,
                    'usuario_id' => $request->cliente_id, ///trae id del cliente al que paga
                    'venta_id' => $sale->id
                ]); 

                $initial_balance = (float)$entity->balance;
                $final_balance = $entity->balance - $decode['prizeWon'];
                $entity->update(['balance' => $final_balance - $decode['prizeWon']]);
                $wallet = Wallets::create([
                    'tipo' => 'premio',
                    'saldo_inicial' => $initial_balance,
                    'saldo_final' => $final_balance,
                    'node_id' => $request->node_id,
                    'usuario_id' => Auth::user()->id, ///trae id del vendedor que paga
                    'venta_id' => $sale->id
                ]);

              /* $decor= json_decode($vendidos,true); */
                return response()->json(['message' => 'Pago realizado exitosamente', 'data' => [json_decode($sale['caracteristicas'],true)], 'dataprovider' => [$wallet]], 201);
                

            }
            return response()->json(['message' => 'No hay suficiente saldo en la entidad para pagar el premio'], 500);
        }
    
        
      catch (\Throwable $th) {
        //throw $th;
        echo ($th);
        return response()->json(['message' => 'Error'], 500);
     }               

 }

 public function getSalesState($request)
 {
     try {
   //    dd($request);
         return response()->json(['data' => $this->request_service->Qr($request)], 201);
       
     } catch (\Throwable $th) {
         return response()->json(['error' => 'La conexión con el proveedor no se pudo establecer'], 400);
     }

 }

}
