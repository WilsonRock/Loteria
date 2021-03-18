<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfiguracionJuego extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $dates = ['delated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'valor_boleto',
        'cantidad_boletos',
        'cifras',
        'premio',
        'terminos',
        'tipo_juego_id',
        'municipio_id',
        'estado_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'valor_boleto' => 'double',
        'premio' => 'double',
        'tipo_juego_id' => 'integer',
        'municipio_id' => 'integer',
        'estado_id' => 'integer',
    ];


    public function plazas()
    {
        return $this->belongsToMany(\App\Models\Plaza::class);
    }

    public function tipoJuego()
    {
        return $this->belongsTo(\App\Models\TipoJuego::class);
    }

    public function municipio()
    {
        return $this->belongsTo(\App\Models\Municipio::class);
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class);
    }
}
