
<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app')

@section('title', 'Página Não Encontrada')

@section('content')
<div class="container text-center">
    <h1>404</h1>
    <h2>Página Não Encontrada</h2>
    <p>A página que você está procurando não existe.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
</div>
@endsection
