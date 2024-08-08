<!-- resources/views/errors/500.blade.php -->
@extends('layouts.app')

@section('title', 'Erro Interno do Servidor')

@section('content')
<div class="container text-center">
    <h1>500</h1>
    <h2>Erro Interno do Servidor</h2>
    <p>Algo deu errado em nosso servidor. Estamos trabalhando para corrigir o problema.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
</div>
@endsection
