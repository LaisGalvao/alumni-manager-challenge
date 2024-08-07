<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{

    /**
     * Exibir a lista de turmas para matrícula.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Busca todas as turmas
        $turmas = Matricula::all();

        // Retorna a view com os dados das turmas
        if (request()->ajax()) {
                return response()->json($turmas);
        }
        return view('matriculas.index', compact('turmas'));
    }

    /**
     * Exibir a lista de alunos matriculados em uma turma específica.
     *
     * @param  int  $turma_id
     * @return \Illuminate\Http\Response
     */
    public function show($turma_id)
    {
        // Busca a turma pelo ID
        $turma = Turma::findOrFail($turma_id);

        // Busca todas as matrículas associadas à turma
        $matriculas = Matricula::with('aluno')
                               ->where('turma_id', $turma_id)
                               ->get();

        // Retorna a view com os dados da turma e dos alunos matriculados
        return view('matriculas.show', compact('turma', 'matriculas'));
    }

    /**
     * Matricular um aluno em uma turma.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'turma_id' => 'required|exists:turmas,id',
        ]);

        // Verifica se o aluno já está matriculado na turma
        $existeMatricula = Matricula::where('aluno_id', $validatedData['aluno_id'])
                                    ->where('turma_id', $validatedData['turma_id'])
                                    ->exists();

        if ($existeMatricula) {
            return redirect()->back()->withErrors(['error' => 'O aluno já está matriculado nesta turma.']);
        }

        // Criação da nova matrícula
        Matricula::create($validatedData);

        // Redireciona com mensagem de sucesso
        return redirect()->route('matriculas.index')->with('success', 'Aluno matriculado com sucesso.');
    }

  public function check(Request $request)
  {
    $exists = Matricula::where('turma_id', $request->turma_id)
                        ->where('aluno_id', $request->aluno_id)
                        ->exists();
    
    return response()->json(['exists' => $exists]);
  }

  public function destroy($id)
  {
    $matricula = Matricula::find($id);

    if ($matricula) {
        $matricula->delete();
        return response()->json(['message' => 'Matrícula excluída com sucesso.']);
    } else {
        return response()->json(['message' => 'Matrícula não encontrada.'], 404);
    }
 }
}
