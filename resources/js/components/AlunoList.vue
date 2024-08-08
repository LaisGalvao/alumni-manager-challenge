<template>
    <div>
        <!-- Campo de Pesquisa -->
        <div class="search-container">
            <input
                v-model="searchQuery"
                type="text"
                class="form-control"
                placeholder="Buscar por nome..."
            />
        </div>
        
        <!-- Tabela -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="aluno in filteredAlunos" :key="aluno.id">
                    <td>{{ aluno.nome }}</td>
                    <td>{{ aluno.data_nascimento }}</td>
                    <td>{{ aluno.usuario }}</td>
                    <td>
                        <button @click="editAluno(aluno)" class="btn btn-primary">Editar</button>
                        <button @click="deleteAluno(aluno.id)" class="btn btn-danger">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Paginação -->
        <nav>
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">Anterior</a>
                </li>
                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">Próxima</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: {
        alunos: Array,
        pagination: Object
    },
    data() {
        return {
            searchQuery: ''  // Campo de pesquisa
        };
    },
    computed: {
        filteredAlunos() {
            // Filtra alunos com base na pesquisa
            return this.alunos.filter(aluno => 
                aluno.nome.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    methods: {
        editAluno(aluno) {
            this.$emit('edit-aluno', aluno);
        },
        deleteAluno(id) {
            if (confirm('Tem certeza que deseja excluir este aluno?')) {
                axios.delete(`/alunos/${id}`)
                    .then(response => {
                        alert(response.data.message);
                        this.$emit('aluno-deleted');
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao excluir o aluno.');
                    });
            }
        },
        changePage(page) {
            if (page !== this.pagination.current_page) {
                this.$emit('change-page', page);
            }
        }
    }
};
</script>

<style scoped>
.table-container {
    overflow-x: auto; /* Permite rolar horizontalmente em telas menores */
    margin-bottom: 1rem;
}

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