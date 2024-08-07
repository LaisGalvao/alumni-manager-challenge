<?php
namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Factories\HasFactory;

   class Turma extends Model
   {
       use HasFactory;
       protected $fillable = ['nome', 'descricao', 'tipo'];

       public function alunos()
       {
           return $this->belongsToMany(Aluno::class, 'matriculas');
       }
   }