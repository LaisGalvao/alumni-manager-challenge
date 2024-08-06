@extends('layouts.app')

@section('content')
<div class="container">
    <aluno-form @aluno-saved="fetchAlunos"></aluno-form>
    <aluno-table :alunos="alunos" @edit-aluno="editAluno" @aluno-deleted="fetchAlunos"></aluno-table>
</div>
@endsection

@section('scripts')
<script>
export default {
    data() {
        return {
            alunos: []
        };
    },
    methods: {
        fetchAlunos() {
            axios.get('/alunos')
                .then(response => {
                    this.alunos = response.data;
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao buscar os alunos.');
                });
        },
        editAluno(aluno) {
            // Lógica para editar o aluno
        }
    },
    created() {
        this.fetchAlunos();
    }
};
</script>
<script src="{{ mix('js/app.js') }}"></script>
@endsection
