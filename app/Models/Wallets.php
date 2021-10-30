<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'saldo_inicial',
        'saldo_final',
        'node_id',
        'usuario_id',
        'venta_id',
        'parent_id',
    ];
}
