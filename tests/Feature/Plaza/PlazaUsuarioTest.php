<?php

namespace Tests\Feature\Plaza;

use App\Models\Estado;
use App\Models\Plaza;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlazaUsuarioTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function puede_super_admin_crear_un_vendedor_perteneciente_a_una_plaza()
    {
        $superadmin = User::factory()->create()->assignRole('Super Admin');
        $plaza = Plaza::factory()->create();

        Estado::factory(['nombre' => 'inactivo'])->create();
        Sanctum::actingAs($superadmin);

        $nuevoUsuario = User::factory([
            'plaza_id' => $plaza->id
        ])->raw();
        $this->postJson(route('plazas.users.store', $plaza), $nuevoUsuario)
            ->assertStatus(201)
            ->assertSee($nuevoUsuario['nombres']);

        $this->assertDatabaseHas('users', ['documento' => $nuevoUsuario['documento']]);

        $usuario = User::where('documento', $nuevoUsuario['documento'])->first();
        $this->assertDatabaseHas('saldo_actuals', ['model_id' => $usuario->id]);
    }

    /** @test */
    public function puede_super_admin_crear_un_administrador_de_una_plaza()
    {
        $superadmin = User::factory()->create()->assignRole('Super Admin');
        $plaza = Plaza::factory()->create();

        Estado::factory(['nombre' => 'activo'])->create();
        Sanctum::actingAs($superadmin);

        $nuevoAdmin = User::factory([
            'plaza_id' => $plaza->id
        ])->raw();

        $this->postJson(route('plaza.users.admin.store', $plaza), $nuevoAdmin)
            ->assertStatus(201)
            ->assertSee($nuevoAdmin['nombres'])
            ->assertSee('Administrador Plaza');

        $this->assertDatabaseHas('users', ['documento' => $nuevoAdmin['documento']]);

        $admin = User::where('documento', $nuevoAdmin['documento'])->first();
        $this->assertDatabaseHas('saldo_actuals', ['model_id' => $plaza->id]);
    }

    /** @test */
    public function administrador_no_puede_crear_un_administrador_de_una_plaza()
    {
        $plaza = Plaza::factory()->create();

        Estado::factory(['nombre' => 'activo'])->create();
        Sanctum::actingAs(User::factory()->create()->assignRole('Administrador Plaza'));

        $nuevoAdmin = User::factory()->raw();

        $this->postJson(route('plaza.users.admin.store', $plaza), $nuevoAdmin)
            ->assertStatus(403);
    }

    /** @test */
    public function puede_administrador_crear_un_vendedor_para_su_plaza()
    {
        $plaza = Plaza::factory()->create();

        $usuario = User::factory([
            'plaza_id' => $plaza->id
        ])->create()->givePermissionTo('plaza.crear.usuario');
        Estado::factory(['nombre' => 'inactivo'])->create();
        Sanctum::actingAs($usuario);
        $nuevoUsuario = User::factory()->raw();
        $this->postJson(route('plazas.users.store', $plaza), $nuevoUsuario)
            ->assertStatus(201)
            ->assertSee($nuevoUsuario['nombres']);

        $this->assertDatabaseHas('users', ['documento' => $nuevoUsuario['documento']]);

        $usuario = User::where('documento', $nuevoUsuario['documento'])->first();
        $this->assertDatabaseHas('saldo_actuals', ['model_id' => $usuario->id]);
    }

    /** @test */
    public function no_puede_plaza_crear_un_vendedor_para_otra_plaza()
    {
        $plazas = Plaza::factory()->times(2)->create();

        $usuario = User::factory([
            'plaza_id' => $plazas[0]->id
        ])->create()->givePermissionTo('plaza.crear.usuario');
        Estado::factory(['nombre' => 'activo'])->create();
        Sanctum::actingAs($usuario);

        $nuevoUsuario = User::factory()->raw();
        $this->postJson(route('plazas.users.store', $plazas[1]), $nuevoUsuario)
            ->assertStatus(403);
    }

    /** @test */
    public function no_puede_invitado_crear_un_vendedor_para_plaza()
    {
        $plaza = Plaza::factory()->create();

        $nuevoUsuario = User::factory()->raw();
        $this->postJson(route('plazas.users.store', $plaza), $nuevoUsuario)
            ->assertStatus(401);
    }
}
