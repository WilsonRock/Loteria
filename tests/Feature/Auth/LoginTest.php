<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function podemos_logearnos_con_credenciales_validas()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = $response->json('plain-text-token');

        $this->assertTrue(
            PersonalAccessToken::findToken(($token))->exists,
            'No existe el token retornado'
        );
    }

    /** @test */
    function no_podemos_logearnos_con_credenciales_invalidas()
    {
       $this->postJson(route('login'), [
            'email' => 'jhonatan@mail.com',
            'password' => 'wrong-password'
        ])->assertSee('These credentials do not match our records');
    }

    /** @test */
    function email_debe_ser_valido()
    {
        $this->postJson(route('login'), [
            'email' => 'no-valido',
            'password' => 'password'
        ])->assertSee(__('validation.email', ['attribute' => 'email']));
    }

    /** @test */
    function email_es_obligatorio()
    {
        $this->postJson(route('login'), [
            'email' => '',
            'password' => 'password'
        ])->assertSee(__('validation.required', ['attribute' => 'email']));
    }

    /** @test */
    function password_es_obligatorio()
    {
        $this->postJson(route('login'), [
            'email' => 'jhonatan@mail.com',
            'password' => ''
        ])->assertSee(__('validation.required', ['attribute' => 'password']));
    }
}
