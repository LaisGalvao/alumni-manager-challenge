@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestão de Turmas</h1>

    <!-- Componente de Formulário de Turma -->
    <turma-form @turma-saved="fetchTurmas" ref="turmaForm"></turma-form>

    <!-- Componente de Lista de Turmas -->
    <turma-list @edit-turma="editTurma"></turma-list>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
<script>
new Vue({
    el: '#app',
    methods: {
        fetchTurmas() {
            this.$refs.turmaList.fetchTurmas();
        },
        editTurma(turma) {
            this.$refs.turmaForm.turma = turma;
        }
    }
});
</script>
@endsection
