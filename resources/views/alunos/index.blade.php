@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Alunos</h1>

    <!-- Componente de Busca -->
    <aluno-search></aluno-search>

    <!-- Componente de Formulário de Aluno -->
    <aluno-form></aluno-form>

    <!-- Listagem de Alunos -->
    <ul>
        @foreach ($alunos as $aluno)
            <li>{{ $aluno->nome }} - {{ $aluno->data_nascimento }} - {{ $aluno->usuario }}</li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
