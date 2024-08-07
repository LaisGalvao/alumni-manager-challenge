<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Matricula;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criar usuários, alunos, turmas e matrículas
        User::factory(10)->create();
        Aluno::factory(10)->create();
        Turma::factory(10)->create();
        Matricula::factory(10)->create();
    }
}
