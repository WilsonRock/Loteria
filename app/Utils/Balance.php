<?php

namespace App\Utils;

use App\Models\Balance as ModelsBalance;
use App\Models\SaldoActual;
use App\Models\TipoBalance;
use App\Models\User;

class Balance
{

    public static function guardarRecargaSaldo(SaldoActual $saldoActual, User $usuario, $parametros) {
        return ModelsBalance::create([
            'saldo_actual' => $saldoActual->saldo,
            'saldo_final' => $saldoActual->saldo,
            'descripcion' => $parametros['descripcion'] ?? '',
            'precio' => $parametros['valor'],
            'tipo_balance_id' => TipoBalance::obtenerTipoRecargaSaldo()->id,
            'user_id' => $usuario->id
        ]);
    }

    public static function actualizarRecargaSaldo(ModelsBalance $balance, SaldoActual $saldoActual) {
        $balance->saldo_final = $saldoActual->saldo;
        $balance->save();
    }
}
