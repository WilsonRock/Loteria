<?php
namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
class ExcelController extends Controller
{
    /**
     * Muestra la lista de usuarios registrados.
     *
     * @return Response
     */
    public function SalesExport()
    {       
    
        return Excel::download(new SalesExport, 'Sales.xlsx');
    
    }
}