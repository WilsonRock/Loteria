<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    use HasFactory;

    protected $fillable = [
        'zona_horaria',
        'moneda',
        'nombre_contacto',
        'telefono_contacto',
        'email',
        'pais',
        'zona',
        'nit',
        'permisos',
        'balance',
        'active',
        'node_id'
    ];
}
