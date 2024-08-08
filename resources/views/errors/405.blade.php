
<!-- resources/views/errors/405.blade.php -->
@extends('layouts.app')

@section('title', 'Método Não Permitido')

@section('content')
<div class="container text-center">
    <h1>405</h1>
    <h2>Método Não Permitido</h2>
    <p>O método de solicitação não é permitido para a URL solicitada.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
</div>
@endsection
