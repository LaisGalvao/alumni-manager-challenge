<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginação de 5 itens por página
        $turmas = Turma::orderBy('nome')->paginate(5);
        return view('turmas.index', compact('turmas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('turmas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'descricao' => 'nullable|string|max:1000',
            'tipo' => 'required|string|min:3|max:255',
        ]);

        // Criação de uma nova Turma
        Turma::create($request->all());

        return redirect()->route('turmas.index')
                         ->with('success', 'Turma criada com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'tipo' => 'required|string|max:255',
        ]);

        // Atualização da Turma
        $turma->update($request->all());

        return redirect()->route('turmas.index')
                         ->with('success', 'Turma atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        // Exclusão da Turma
        $turma->delete();

        return redirect()->route('turmas.index')
                         ->with('success', 'Turma excluída com sucesso.');
    }
}
