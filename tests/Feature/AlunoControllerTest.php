<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Aluno;

class AlunoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_requires_authentication()
    {
        // Simula uma requisição GET sem autenticação
        $response = $this->get('/alunos');

        // Espera uma redireção para a página de login
        $response->assertStatus(401); 
        $response->assertSee('');
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

        // Cria alguns alunos
        $aluno1 = Aluno::create(['nome' => 'Aluno 1', 'data_nascimento' => '2000-01-01', 'usuario' => 'user1']);
        $aluno2 = Aluno::create(['nome' => 'Aluno 2', 'data_nascimento' => '2001-01-01', 'usuario' => 'user2']);

        // Simula uma requisição GET para o endpoint de alunos
        $response = $this->get('/alunos');

        // Verifica o status da resposta
        $response->assertStatus(200);
    }
}
