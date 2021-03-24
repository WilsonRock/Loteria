<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBalance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    const RECARGA_SALDO = 'recarga-saldo';

    public static function obtenerTipoRecargaSaldo() {
        //dd(self);
        return self::where('nombre', self::RECARGA_SALDO)->first();
    }
}
