<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saldo_actual',
        'saldo_final',
        'descripcion',
        'precio',
        'balance_id',
        'tipo_balance_id',
        'user_id',
        'cliente_id',
        'venta_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'saldo_actual' => 'double',
        'saldo_final' => 'double',
        'precio' => 'double',
        'balance_id' => 'string',
        'tipo_balance_id' => 'integer',
        'user_id' => 'string',
        'cliente_id' => 'string',
        'venta_id' => 'string',
    ];


    public function balance()
    {
        return $this->belongsTo(\App\Models\Balance::class);
    }

    public function tipoBalance()
    {
        return $this->belongsTo(\App\Models\TipoBalance::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class);
    }

    public function venta()
    {
        return $this->belongsTo(\App\Models\Venta::class);
    }
}
