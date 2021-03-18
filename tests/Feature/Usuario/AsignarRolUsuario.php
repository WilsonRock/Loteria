<?php

namespace Tests\Feature\Usuario;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AsignarRolUsuario extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
