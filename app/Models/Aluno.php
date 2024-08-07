<?php
namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Factories\HasFactory;

   class Aluno extends Model
   {
       
       protected $fillable = ['nome', 'data_nascimento', 'usuario'];

       public function turmas()
       {
           return $this->belongsToMany(Turma::class, 'matriculas');
       }
   }