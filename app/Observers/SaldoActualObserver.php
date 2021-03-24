<?php

namespace App\Observers;

use App\Models\Balance;
use App\Models\SaldoActual;

class SaldoActualObserver
{
    /**
     * Handle the SaldoActual "created" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function created(SaldoActual $saldoActual)
    {
        //
    }

    /**
     * Handle the SaldoActual "updating" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function updating(SaldoActual $saldoActual)
    {
        Balance::create([
            'saldo_actual' => $saldoActual->saldo,
            'saldo_final' => $saldoActual->saldo,
            'descripcion' => 'Recarga de saldo',
            'precio' => $validate['valor'],
            'tipo_balance_id' => TipoBalance::obtenerTipoRecargaSaldo()->id,
            'user_id' => $usuario->id
        ]);
    }

    /**
     * Handle the SaldoActual "updated" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function updated(SaldoActual $saldoActual)
    {
        //
    }

    /**
     * Handle the SaldoActual "deleted" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function deleted(SaldoActual $saldoActual)
    {
        //
    }

    /**
     * Handle the SaldoActual "restored" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function restored(SaldoActual $saldoActual)
    {
        //
    }

    /**
     * Handle the SaldoActual "force deleted" event.
     *
     * @param  \App\Models\SaldoActual  $saldoActual
     * @return void
     */
    public function forceDeleted(SaldoActual $saldoActual)
    {
        //
    }
}
