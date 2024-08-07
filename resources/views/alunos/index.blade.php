@extends('layouts.app')

@section('content')
<div id="container">
    <alunos-component></alunos-component>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
