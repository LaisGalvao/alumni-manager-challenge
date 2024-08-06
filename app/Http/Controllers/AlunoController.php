<?php
namespace App\Http\Controllers;

   use App\Models\Aluno;
   use Illuminate\Http\Request;

   class AlunoController extends Controller
   {
       public function index()
       {
           $alunos = Aluno::orderBy('nome')->get(); // Ordena alfabeticamente por nome
           return view('alunos.index', compact('alunos'));
       }

       public function create()
       {
           return view('alunos.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'nome' => 'required|string|min:3|max:255',
               'data_nascimento' => 'required|date',
               'usuario' => 'required|string|min:3|max:255',
           ]);

           Aluno::create($request->all());

           return redirect()->route('alunos.index')
                            ->with('success', 'Aluno cadastrado com sucesso.');
       }

       public function edit(Aluno $aluno)
       {
           return view('alunos.edit', compact('aluno'));
       }

       public function update(Request $request, Aluno $aluno)
       {
           $request->validate([
               'nome' => 'required|string|max:255',
               'data_nascimento' => 'required|date',
               'usuario' => 'required|string|max:255',
           ]);

           $aluno->update($request->all());

           return redirect()->route('alunos.index')
                            ->with('success', 'Aluno atualizado com sucesso.');
       }

       public function destroy(Aluno $aluno)
       {
           $aluno->delete();

           return redirect()->route('alunos.index')
                            ->with('success', 'Aluno excluído com sucesso.');
       }

       public function search(Request $request)
       {
           $search = $request->get('search');
           $alunos = Aluno::where('nome', 'like', '%'.$search.'%')->get();

           return view('alunos.index', compact('alunos'));
       }
   }