@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Alunos Matriculados na Turma: {{ $turma->nome }}</h1>

    <ul>
        @foreach ($matriculas as $matricula)
            <li>{{ $matricula->aluno->nome }}</li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
