<template>
    <div class="container">
        <aluno-form 
            v-if="editingAluno" 
            :aluno="editingAluno" 
            @aluno-saved="fetchAlunos" 
            @cancel-edit="cancelEdit">
        </aluno-form>
        <aluno-form v-else @aluno-saved="fetchAlunos"></aluno-form>
        <tabela-alunos 
            :alunos="alunos" 
            :pagination="pagination"
            @edit-aluno="setEditingAluno" 
            @aluno-deleted="fetchAlunos"
            @change-page="fetchAlunos">
        </tabela-alunos>
    </div>
</template>

<script>
import AlunoForm from './AlunoForm.vue';
import TabelaAlunos from './AlunoList.vue';

export default {
    components: {
        AlunoForm,
        TabelaAlunos
    },
    data() {
        return {
            alunos: [],
            pagination: {
                current_page: 1,
                last_page: 1,
            },
            editingAluno: null
        };
    },
    methods: {
        fetchAlunos(page = 1) {
            axios.get(`/alunos?page=${page}`)
                .then(response => {
                    this.alunos = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                    };
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao buscar os alunos.');
                });
        },
        setEditingAluno(aluno) {
            this.editingAluno = aluno;
        },
        cancelEdit() {
            this.editingAluno = null;
        },
        editAluno(aluno) {
            this.setEditingAluno(aluno);
        }
    },
    created() {
        this.fetchAlunos();
    }
};
</script>

<style scoped>
.container {
    margin-top: 20px;
}
</style>
