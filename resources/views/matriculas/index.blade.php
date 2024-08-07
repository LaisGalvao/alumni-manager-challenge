@extends('layouts.app')

@section('content')
<div class="container">
    <matriculas-component></matriculas-component>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
