<template>
    <div class="table-container">
        <h1>Lista de Alunos</h1>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="aluno in alunos" :key="aluno.id">
                    <td>{{ aluno.nome }}</td>
                    <td>{{ aluno.data_nascimento }}</td>
                    <td>{{ aluno.usuario }}</td>
                    <td>
                        <button @click="editAluno(aluno)" class="btn btn-primary btn-sm">Editar</button>
                        <button @click="deleteAluno(aluno.id)" class="btn btn-danger btn-sm">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['alunos'],
    methods: {
        editAluno(aluno) {
            this.$emit('edit-aluno', aluno);
        },
        deleteAluno(id) {
            if (confirm('Tem certeza que deseja excluir este aluno?')) {
                axios.delete(`/alunos/${id}`)
                    .then(response => {
                        alert('Aluno excluído com sucesso!');
                        this.$emit('aluno-deleted', id);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao excluir o aluno.');
                    });
            }
        }
    }
};
</script>

<style scoped>
.table-container {
    background-color: #2c2f32;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: #e0e0e0;
}

.table-dark {
    width: 100%;
    margin-top: 20px;
    background-color: #2c2f32;
    color: #e0e0e0;
    border: 1px solid #444;
    border-collapse: separate;
    border-spacing: 0;
}

.table-dark th, .table-dark td {
    padding: 12px;
    border-top: 1px solid #444;
}

.table-dark th {
    background-color: #202427;
    color: #ed145b;
}

.table-dark tr:hover {
    background-color: #333;
}

.table-dark tbody tr:nth-child(even) {
    background-color: #2a2d30;
}

.table-dark tbody tr:nth-child(odd) {
    background-color: #2c2f32;
}

.btn {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #ed145b;
    border: none;
    color: #fff;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #d11a51;
}

.btn-danger {
    background-color: #ff5b77;
    border: none;
    color: #fff;
    cursor: pointer;
}

.btn-danger:hover {
    background-color: #d13a51;
}
</style>
