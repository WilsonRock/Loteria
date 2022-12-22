<?php
namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
class ExcelController extends Controller
{
    /**
     * Muestra la lista de ventas registrados.
     *
     * @return Response
     */
    public function SalesExport()
    {       
       
        return Excel::download(new SalesExport, 'Sales.xlsx');

    }
    public function salesExcelExport(Request $request) {
        try {
            $f1 = $f2 = date('Y-m-d H:i:s');
            if(! is_null($request->initial_date) && ! empty($request->initial_date) && ! is_null($request->final_date) || ! empty($request->final_date) ){
                $f1 = $request->initial_date;
                $f2 = $request->final_date;
            }
          
         $size = $request->size ?? 10000;
         $params = DB::table('sales')
         ->select('sales.*', 'wallets.*','users.nombres as nombre_cliente', 'users.apellidos as apellidos_cliente', 'vendedor.nombres as nombre_Vendedor', 'vendedor.apellidos as apellidos_Vendedor')
          ->whereBetween('sales.updated_at', [$f1, $f2])
          ->join('wallets', 'wallets.venta_id', '=', 'sales.id')
          ->join('users', 'users.id', 'sales.cliente_id')
          ->join('users as vendedor', 'vendedor.id', "=", 'sales.vendedor_id')
          ->where('wallets.tipo', $request->Type)
          ->paginate($size);
            return (new SalesExport($params))->download('sales.xlsx', \Maatwebsite\Excel\Excel::XLSX);
         } catch (\Exception $e) {
            //\Log::error($e);
            return $this->errorResponse(null, '¡Ups, algo va mal! Puede volver a intentarlo  o contactar con el administrador',500);
        }
    }

    public function salesCsvExport(Request $request) {
        try {
            $f1 = $f2 = date('Y-m-d H:i:s');
            if(! is_null($request->initial_date) && ! empty($request->initial_date) && ! is_null($request->final_date) || ! empty($request->final_date) ){
                $f1 = $request->initial_date;
                $f2 = $request->final_date;
            }

         $size = $request->size ?? 10000;
         $params = DB::table('sales')
         ->select('sales.*', 'wallets.*','users.nombres as nombre_cliente', 'users.apellidos as apellidos_cliente', 'vendedor.nombres as nombre_Vendedor', 'vendedor.apellidos as apellidos_Vendedor')
          ->whereBetween('sales.updated_at', [$f1, $f2])
          ->join('wallets', 'wallets.venta_id', '=', 'sales.id')
          ->join('users', 'users.id', 'sales.cliente_id')
          ->join('users as vendedor', 'vendedor.id', "=", 'sales.vendedor_id')
          ->where('wallets.tipo', $request->Type)
          ->paginate($size);
       //   dd($params);
          return (new SalesExport($params))->download('sales.csv', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            dd($e);
            //\Log::error($e);
            return $this->errorResponse(null, '¡Ups, algo va mal! Puede volver a intentarlo  o contactar con el administrador',500);
        }
    }
}