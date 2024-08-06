<?php
namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class Matricula extends Model
   {
       protected $fillable = ['aluno_id', 'turma_id'];

       public function aluno()
       {
           return $this->belongsTo(Aluno::class);
       }

       public function turma()
       {
           return $this->belongsTo(Turma::class);
       }
   }