<?php
namespace App\Http\Controllers;

   use App\Models\Aluno;
   use Illuminate\Http\Request;

   class AlunoController extends Controller
   {
       public function index()
       {
           $alunos = Aluno::orderBy('nome')->paginate(5);
            if (request()->ajax()) {
                return response()->json($alunos);
            }

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

       public function update(Request $request, $id)
       {
            $request->validate([
                'nome' => 'required|string|min:3|max:255',
                'data_nascimento' => 'required|date',
                'usuario' => 'required|string|min:3|max:255',
            ]);
            $aluno = Aluno::findOrFail($id);
            $aluno->update($request->all());
            return response()->json(['message' => 'Aluno atualizado com sucesso!', 'aluno' => $aluno]);
       }

        public function destroy($id)
        {
            $aluno = Aluno::findOrFail($id);
            $aluno->delete();
            return response()->json(['message' => 'Aluno excluído com sucesso!']);
        }

       public function search(Request $request)
       {
           $search = $request->get('search');
           $alunos = Aluno::where('nome', 'like', '%'.$search.'%')->get();

           return view('alunos.index', compact('alunos'));
       }
   }