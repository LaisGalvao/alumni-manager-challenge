@extends('layouts.app')

@section('content')
<div class="container">
    <turmas-component></turmas-component>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
