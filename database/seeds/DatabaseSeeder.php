<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Matricula;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criando administradores
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Criando usuários comuns
        User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        // Criando alunos
        $alunos = [
            ['nome' => 'Aluno 1', 'data_nascimento' => '2000-01-01', 'usuario' => 'aluno1'],
            ['nome' => 'Aluno 2', 'data_nascimento' => '2001-02-02', 'usuario' => 'aluno2'],
            // Adicione mais alunos conforme necessário
        ];

        foreach ($alunos as $aluno) {
            Aluno::create($aluno);
        }

        // Criando turmas
        $turmas = [
            ['nome' => 'Turma A', 'descricao' => 'Descrição da Turma A', 'tipo' => 'Tipo A'],
            ['nome' => 'Turma B', 'descricao' => 'Descrição da Turma B', 'tipo' => 'Tipo B'],
            // Adicione mais turmas conforme necessário
        ];

        foreach ($turmas as $turma) {
            Turma::create($turma);
        }

        // Criando matrículas
        Matricula::create(['aluno_id' => 1, 'turma_id' => 1]);
        Matricula::create(['aluno_id' => 2, 'turma_id' => 2]);
        // Adicione mais matrículas conforme necessário
    }
}
