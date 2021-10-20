<?php

namespace Tests\Feature\Plaza;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlazaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_listar_plazas()
    {
        $plazas = Plaza::factory()->times(3)->create();

        Sanctum::actingAs(User::factory()->create()->assignRole('Super Admin'));
        $this->getJson(route('plazas.index'))
            ->assertStatus(200)
            ->assertSee($plazas[0]['id']);
    }

    /** @test */
    public function puede_obtener_una_plaza()
    {
        $plaza = Plaza::factory()->create();
        Sanctum::actingAs(User::factory()->create()->assignRole('Super Admin'));
        $this->getJson(route('plazas.show', $plaza))
            ->assertStatus(200)
            ->assertSee($plaza['id']);
    }

    /** @test */
    public function invitado_no_puede_obtener_una_plaza()
    {
        $plaza = Plaza::factory()->create();
        $this->getJson(route('plazas.show', $plaza))
            ->assertStatus(401);
    }

    /** @test */
    public function invitado_no_puede_listar_plazas()
    {
        Plaza::factory()->create();
        $this->getJson(route('plazas.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function superadmin_puede_crear_una_plaza()
    {
        $user = User::factory()->create()->assignRole('Super Admin');
        $plaza = Plaza::factory([
            'parent_id' => $user->plaza->id
        ])->raw();
        Sanctum::actingAs($user);

        $this->postJson(route('plazas.store'), $plaza)
            ->assertStatus(201)
            ->assertSee($plaza['nombre']);
    }

    /** @test */
    public function invitado_no_puede_crear_una_plaza()
    {
        $plaza = Plaza::factory()->raw();

        $this->postJson(route('plazas.store'), $plaza)
            ->assertStatus(401)
            ->assertDontSee($plaza['nombre']);
    }

    /**
     * TODO: crear tests para validar que se retorna un error con campos requeridos
     */


    /** @test */
    public function superadmin_puede_actualizar_una_plaza()
    {
        $plaza = Plaza::factory()->create();

        Sanctum::actingAs(User::factory()->create()->assignRole('Super Admin'));

        $valoresNuevosPlaza = Plaza::factory()->raw();

        $this->putJson(route('plazas.update', $plaza), $valoresNuevosPlaza)
            ->assertStatus(200)
            ->assertSee($valoresNuevosPlaza['nombre']);
    }

    /** @test */
    public function plaza_puede_crear_plaza_hija()
    {
        $plaza = Plaza::factory()->create();

        $administradorPlaza = User::factory([
            'plaza_id' => $plaza->id
        ])->create()->assignRole('Administrador Plaza');

        Estado::factory(['nombre' => 'inactivo'])->create();
        Sanctum::actingAs($administradorPlaza);

        $nuevaPlaza = Plaza::factory()->raw();
        $this->postJson(route('plazas.plaza.store', $plaza), $nuevaPlaza)
            ->assertStatus(201)
            ->assertSee($nuevaPlaza['nombre'])
            ->assertSee($plaza->id);
    }

    /** @test */
    public function plaza_no_puede_crear_plaza_hija_de_otra_plaza()
    {
        $plazas = Plaza::factory()->times(2)->create();

        $administradorPlaza = User::factory([
            'plaza_id' => $plazas[0]->id
        ])->create()->assignRole('Administrador Plaza');
        Sanctum::actingAs($administradorPlaza);

        $nuevaPlaza = Plaza::factory()->raw();
        $this->postJson(route('plazas.plaza.store', $plazas[1]), $nuevaPlaza)
            ->assertStatus(403);
    }

    /** @test */
    public function superadmin_puede_crear_plaza_hija_de_cualquier_plaza()
    {
        $plaza = Plaza::factory()->create();

        Sanctum::actingAs(User::factory()->create()->assignRole('Super Admin'));
        Estado::factory(['nombre' => 'inactivo'])->create();

        $nuevaPlaza = Plaza::factory()->raw();
        $this->postJson(route('plazas.plaza.store', $plaza), $nuevaPlaza)
            ->assertStatus(201)
            ->assertSee($nuevaPlaza['nombre'])
            ->assertSee($plaza->id);
    }
}
