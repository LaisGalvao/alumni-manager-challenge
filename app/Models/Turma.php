<?php
namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class Turma extends Model
   {
       protected $fillable = ['nome', 'descricao', 'tipo'];

       public function alunos()
       {
           return $this->belongsToMany(Aluno::class, 'matriculas');
       }
   }