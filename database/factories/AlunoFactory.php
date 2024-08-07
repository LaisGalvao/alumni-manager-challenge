<?php

namespace Database\Factories;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlunoFactory extends Factory
{
    protected $model = Aluno::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'data_nascimento' => $this->faker->date,
            'usuario' => $this->faker->unique()->userName,
        ];
    }
}
