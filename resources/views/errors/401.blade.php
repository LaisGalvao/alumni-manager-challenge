
<!-- resources/views/errors/401.blade.php -->
@extends('layouts.app')

@section('title', 'Não Autorizado')

@section('content')
<div class="container text-center">
    <h1>401</h1>
    <h2>Não Autorizado</h2>
    <p>Você não tem permissão para acessar esta página.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
</div>
@endsection
