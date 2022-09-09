<?php
namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\Sales;
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
          $params = Sales::whereBetween('sales.updated_at', [$f1, $f2])->get();  
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

         $params = Sales::whereBetween('sales.updated_at', [$f1, $f2])->get();  
          return (new SalesExport($params))->download('sales.csv', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            //\Log::error($e);
            return $this->errorResponse(null, '¡Ups, algo va mal! Puede volver a intentarlo  o contactar con el administrador',500);
        }
    }
}