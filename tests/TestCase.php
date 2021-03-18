<?php

namespace Tests;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Role::create(['name' => 'Super Admin']);
        $administradorPlazaRole = Role::create(['name' => 'Administrador Plaza']);

        Role::create(['name' => 'Vendedor']);
        //$vendedorPlazaRole = Role::create
        $crearUsuarioPermiso = Permission::create(['name' => 'plaza.crear.usuario']);

        $administradorPlazaRole->givePermissionTo($crearUsuarioPermiso);
    }
}
