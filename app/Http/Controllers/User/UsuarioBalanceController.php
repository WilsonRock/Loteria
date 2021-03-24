<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\Plaza;
use App\Models\PlazaUser;
use App\Models\User;
use App\Supports\MessagesResponses;
use App\Utils\Balance as UtilsBalance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UsuarioBalanceController extends ApiController
{
    public function store(Request $request, Plaza $plaza, User $usuario) {
        try {
            DB::beginTransaction();
            $validate = $this->validate($request, [
                'valor' => 'required|numeric',
                'descripcion' => 'string'
            ]);
            if(!PlazaUser::where('plaza_id', $plaza->id)->where('user_id', $usuario->id)->exists()) {
                return $this->errorResponse('El usuario/plaza no existe.', Response::HTTP_BAD_REQUEST);
            }
    
            $saldoActual = $usuario->saldoActual()->first();
    
            $balance = UtilsBalance::guardarRecargaSaldo($saldoActual, $usuario, $validate);
            $saldoActual->saldo += $validate['valor'];
            $saldoActual->save();
            $saldoActual->fresh();
    
            UtilsBalance::actualizarRecargaSaldo($balance, $saldoActual);
            DB::commit();
            return $this->showMessage(MessagesResponses::ASSIGNACION_SALDO_EXITOSO, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }
    }
}
