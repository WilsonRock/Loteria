<?php

namespace App\Services;


use App\Models\Entities;
use App\Filters\Filters;
use App\Models\Balance;
use App\Models\BalanceType;
use App\Models\Commerce;
use App\Supports\MessagesResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales;
use App\Services\json;
use PhpParser\JsonDecoder;

class BalanceService
{


    protected $balanceRepository;
    protected $consignmentBalance;
    protected $commerceRepository;
    protected $currentBalanceRepository;

    protected $model;
    private $query;

    public function __construct(Entities $balance)
    {
        $this->model = $balance;
        $this->test = [];
    }
    public function find($id)
    {
        if (null == $balance = $this->model->find($id)) {
            abort(Response::HTTP_NOT_FOUND, str_replace(":", "Sales", MessagesResponses::MODEL_NOT_FOUND));
        }

        return $balance;
    }



    public function getTotalsConciliationReport($filters, Entities $commerce)
    {   
        $collection = collect($this->getTotals($filters, $commerce));
        return $collection->map(function ($element) {

            $data = [
               'name' => "admin",
               'id' => Auth::user()->node_id,
                'parent_id' => Auth::user()->node_id,
                'has_children' => false,
                'balances' => [
                    'sale' => $element["ventas"], 
                    'commission' => $element["Comision"],
                    'assignment' => 0,
                    'retraction' => 0,
                    'assignment-admin' => 0,
                    'reverse-sale' => 0,
                    'reverse-commission' => 0,
/*                     'conciliation-commission' => 0,
                    'correction-by-conciliation' => 0,
                    'move' => 0,
                    'reverse-retraction' => 0,
                    'reverse-assign' => 0 */
                ]
            ];

            foreach ($element as $key => $balance) {
/*                 if (
                    $balance->balance_type === BalanceType::COMMISSION
                    || $balance->balance_type === BalanceType::CONCILIATION_COMMISSION
                    || $balance->balance_type === BalanceType::REVERSE_COMMISSION
                ) {
                    $data['balances'][$balance->balance_type] = $balance->commission;
                    continue;
                } */

              //  $data['balances'][$balance->balance_type] = $balance->amount;
            }
            return $data;
        });
    }



    public function getTotals(Request $filters, Entities $commerce)
  
    { 
      $id= Auth::user()->node_id;
      $totalVenta=$this->sum($filters);

      $entities = DB::table('entities')
                ->join('node_has_nodes', 'node_has_nodes.hijo_id', '=', 'entities.node_id')
                
                ->join('nodes', 'nodes.id', '=', 'entities.node_id')
                /* ->where('node_has_nodes.padre_id', '=', $node->id) */
                ->get();
                
                return  [$totalVenta];


           

     
            /* ->groupBy('commerce_id'); */
            //dd( $totalVenta);
    }

   


    public function sum( $request)
    {
     $id= Auth::user()->node_id;
     $f1 = $f2 = date('Y-m-d H:i:s');   
     if(! is_null($request->initial_date) && ! empty($request->initial_date) && ! is_null($request->final_date) || ! empty($request->final_date) ){
            $f1 = $request->initial_date;
            $f2 = $request->final_date;
      }
     $ventas =  Sales::select(\DB::raw("SUM(cast(sales.precio AS integer)) AS Total " ))->where('node_id', $id) ->whereDate('sales.updated_at', '>=', $f1)->whereDate('sales.updated_at', '<=', $f2)->get();
     $premios =  Sales::select(\DB::raw("SUM(cast(sales.comision AS integer)) AS premios"))->where('node_id', $id)->whereDate('sales.updated_at', '>=', $f1)->whereDate('sales.updated_at', '<=', $f2)->get();
                 

 
    
    
     // $jackpost;
  //  ->where('sales.updated_at', [$f1, $f2])
     //dd($ventas);
    // dd($premios);
     
     foreach($ventas as $el => $data1) {
        foreach($premios as $el => $data2) {
            $req[$el] = [
             //  $total = $data->premios,
               $data = [
                'Comision' => $data2['premios'],
                'ventas' =>  $data1->total,
                'jackpost'=>  1,
                'premios'=>  0,
              ]
            ];      
         }      
     }
     

     
  //dd($data);

   return $data;
    }
}
