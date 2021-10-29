<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'precio',
        'premio',
        'comision',
        'caracteristicas',
        'vendedor_id',
        'cliente_id',
        'node_id',
    ];
}
