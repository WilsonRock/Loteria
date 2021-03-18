<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionJuegoPlaza extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'configuracion_juego_plaza';

    protected $fillable = [
        'fecha_inicial',
        'fecha_final'
    ];
}
