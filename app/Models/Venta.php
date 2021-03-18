<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_venta',
        'boletos',
        'precio',
        'cliente_id',
        'configuracion_juego_plaza_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'fecha_venta' => 'timestamp',
        'boletos' => 'array',
        'precio' => 'double',
        'cliente_id' => 'string',
        'configuracion_juego_plaza_id' => 'string'
    ];


    public function idCliente()
    {
        return $this->belongsTo(\App\Models\IdCliente::class);
    }
}
