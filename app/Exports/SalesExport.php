<?php
namespace App\Exports;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SalesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sales::all();
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