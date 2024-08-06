<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade'); // Chave estrangeira para alunos
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade'); // Chave estrangeira para turmas
            $table->timestamps(); // Campos created_at e updated_at

            $table->unique(['aluno_id', 'turma_id']); // Garante que um aluno não possa ser matriculado duas vezes na mesma turma
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
