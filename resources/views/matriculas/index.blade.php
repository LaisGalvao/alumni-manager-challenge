@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerenciar Matrículas</h1>

    <!-- Componente de Formulário de Matrícula -->
    <matricula-form></matricula-form>

    <h2>Turmas</h2>
    <ul>
        @foreach ($turmas as $turma)
            <li><a href="{{ route('matriculas.show', $turma->id) }}">{{ $turma->nome }}</a></li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
