<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Float_;

class Sales extends Model
{
    use HasFactory;
    protected $casts = [
        'precio'=>'float',
       
    ];
    protected $fillable = [
        'precio',
        'premio',
        'comision',
        'caracteristicas',
        'vendedor_id',
        'cliente_id',
        'node_id',
        'state',
        'id_sale_provider'
        
    ];
}
