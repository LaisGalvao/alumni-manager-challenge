<?php

namespace Database\Factories;

use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatriculaFactory extends Factory
{
    protected $model = Matricula::class;

    public function definition()
    {
        return [
            'aluno_id' => Aluno::factory(),
            'turma_id' => Turma::factory(),
        ];
    }
}
