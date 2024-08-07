<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a página inicial é acessível apenas para usuários autenticados.
     *
     * @return void
     */
    public function test_index_requires_authentication()
    {
        // Tenta acessar a rota sem estar autenticado
        $response = $this->get('/home');

        // Espera um código de status 401 se não estiver autenticado
        $response->assertStatus(401);
    }
}
