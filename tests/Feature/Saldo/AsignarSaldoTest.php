<?php

namespace Tests\Feature\Saldo;

use App\Models\Plaza;
use App\Models\SaldoActual;
use App\Models\TipoBalance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AsignarSaldoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_superadmin_asignar_saldo_a_usuario() {
        $plaza = Plaza::factory()->create();

        $usuario = User::factory()->create();

        Sanctum::actingAs($usuario->assignRole('Super Admin'));

        $plaza->users()->attach($usuario->id);

        //$usuario->assignRole('Administrador Plaza');
        //asignamos saldo al usuario
        $saldoActual = SaldoActual::create(SaldoActual::obtenerSaldoPorDefecto($usuario->id));

        TipoBalance::factory(['nombre' => 'recarga-saldo'])->create();

        $this->postJson(route('plaza.users.balance.asignar', [$plaza, $usuario]), [
            'valor' => 10000
        ])->assertStatus(200);

        $this->assertEquals(10000, $usuario->saldoActual()->first()->saldo, 'No se asigno correctamente la recarga al saldo del usuario');
        $this->assertDatabaseHas('balances', [
            'saldo_actual' => $saldoActual->saldo,
            'saldo_final' => 10000,
            'descripcion' => $parametros['descripcion'] ?? '',
            'precio' => 10000,
            'tipo_balance_id' => TipoBalance::obtenerTipoRecargaSaldo()->id,
            'user_id' => $usuario->id
        ]);
    }
}
