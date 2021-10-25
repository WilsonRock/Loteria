<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'identificacion',
        'contacto',
        'cifras',
        'oportunidades',
        'premio',
        'precio',
        'comision',
        'fecha_inicio',
        'fecha_final',
        'active',
        'node_id'
    ];
}
