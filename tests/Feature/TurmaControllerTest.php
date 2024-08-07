<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Turma;

class TurmaControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_requires_authentication()
    {
        // Simula uma requisição GET sem autenticação
        $response = $this->get('/turmas');

        // Espera uma redireção para a página de login
        $response->assertStatus(401); // Redirecionamento
        $response->assertSee(''); // Verifica a URL de redirecionamento
    }

    /** @test */
    public function index_accessible_for_authenticated_users()
    {
        // Cria um usuário administrador
        $admin = User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Autentica o usuário
        $this->actingAs($admin);

        // Cria algumas turmas
        $turma1 = Turma::create(['nome' => 'Turma 1', 'descricao' => 'Descrição 1', 'tipo' => 'Tipo 1']);
        $turma2 = Turma::create(['nome' => 'Turma 2', 'descricao' => 'Descrição 2', 'tipo' => 'Tipo 2']);

        // Simula uma requisição GET para o endpoint de turmas
        $response = $this->get('/turmas');

        // Verifica o status da resposta
        $response->assertStatus(200);

    }

    /** @test */
    public function store_creates_turma()
    {
        // Cria um usuário administrador
        $admin = User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Autentica o usuário
        $this->actingAs($admin);

        // Simula uma requisição POST para criar uma nova turma
        $response = $this->post('/turmas', [
            'nome' => 'Nova Turma',
            'descricao' => 'Descrição da nova turma',
            'tipo' => 'Tipo da nova turma',
        ]);

        // Verifica se a turma foi criada e se houve redirecionamento
        $response->assertRedirect('/turmas');
        $response->assertSessionHas('success', 'Turma criada com sucesso.');
        $this->assertDatabaseHas('turmas', ['nome' => 'Nova Turma']);
    }

    /** @test */
    public function update_modifies_turma()
    {
        // Cria um usuário administrador
        $admin = User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Autentica o usuário
        $this->actingAs($admin);

        // Cria uma turma
        $turma = Turma::create(['nome' => 'Turma Antiga', 'descricao' => 'Descrição antiga', 'tipo' => 'Tipo antigo']);

        // Simula uma requisição PUT para atualizar a turma
        $response = $this->put("/turmas/{$turma->id}", [
            'nome' => 'Turma Atualizada',
            'descricao' => 'Descrição atualizada',
            'tipo' => 'Tipo atualizado',
        ]);

        // Verifica se a turma foi atualizada
        $response->assertJson(['message' => 'Turma atualizada com sucesso!']);
        $this->assertDatabaseHas('turmas', ['nome' => 'Turma Atualizada']);
    }

    /** @test */
    public function destroy_deletes_turma()
    {
        // Cria um usuário administrador
        $admin = User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Autentica o usuário
        $this->actingAs($admin);

        // Cria uma turma
        $turma = Turma::create(['nome' => 'Turma para deletar', 'descricao' => 'Descrição para deletar', 'tipo' => 'Tipo para deletar']);

        // Simula uma requisição DELETE para remover a turma
        $response = $this->delete("/turmas/{$turma->id}");

        // Verifica se a turma foi excluída
        $response->assertJson(['message' => 'Turma excluída com sucesso!']);
        $this->assertDatabaseMissing('turmas', ['nome' => 'Turma para deletar']);
    }
}
