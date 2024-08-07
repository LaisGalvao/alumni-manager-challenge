<template>
    <div>
        <h2>Alunos Matriculados na Turma</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Turma</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="aluno in alunos" :key="aluno.id">
                    <td>{{ aluno.aluno_id }}</td>
                    <td>{{ aluno.turma_id }}</td>
                    <td>
                        <button @click="removeMatricula(aluno.id)" class="btn btn-danger">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        turmaId: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            alunos: []
        };
    },
    methods: {
        fetchAlunos() {
            axios.get(`/matriculas`)
                .then(response => {
                    this.alunos = response.data;
                    console.log(this.alunos);
                    
                })
                .catch(error => {
                    console.error(error);
                });
        },
        removeMatricula(alunoId) {
            if (confirm('Tem certeza que deseja remover este aluno da turma?')) {
                axios.delete(`/matriculas/${alunoId}`)
                    .then(response => {
                        alert('Matrícula removida com sucesso!');
                        this.fetchAlunos();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao remover o aluno.');
                    });
            }
        }
    },
    watch: {
        turmaId: 'fetchAlunos'
    },
    created() {
        this.fetchAlunos();
    }
};
</script>


<style scoped>
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #e0e0e0;
    background-color: #202427;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
.table th, .table td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #343a40;
}
.table thead th {
    background-color: #343a40;
    color: #e0e0e0;
    border-bottom: 2px solid #454d55;
}
.table tbody tr:nth-child(even) {
    background-color: #2a2d2f;
}
.table tbody tr:hover {
    background-color: #2c2f31;
}
.btn {
    color: #fff;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 4px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s, border-color 0.3s;
}
.btn-primary {
    background-color: #ed145b;
    border-color: #ed145b;
}
.btn-primary:hover {
    background-color: #d11a51;
    border-color: #d11a51;
}
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}
.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
.pagination {
    display: flex;
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}
.page-item {
    margin: 0 0.25rem;
}
.page-link {
    color: #ed145b;
    background-color: #202427;
    border: 1px solid #ed145b;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
}
.page-link:hover {
    color: #d11a51;
    background-color: #202427;
    border-color: #d11a51;
}
.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: not-allowed;
    background-color: #202427;
    border-color: #6c757d;
}
.search-container {
    margin-bottom: 1rem;
}
.form-control {
    width: 100%;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 4px;
    border: 1px solid #343a40;
    background-color: #2a2d2f;
    color: #e0e0e0;
}
.form-control::placeholder {
    color: #6c757d;
}
</style>
