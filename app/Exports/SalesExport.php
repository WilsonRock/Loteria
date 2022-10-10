<?php

namespace App\Exports;

use App\Product;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SalesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $params;

    public function __construct($params = null)
    {
        $this->params = $params;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->params ?: Sales::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'precio',
            'premio',
            'comision',
            'caracteristicas',
            'vendedor_id',
            'cliente_id',
            'node_id',
        ];
    }
}