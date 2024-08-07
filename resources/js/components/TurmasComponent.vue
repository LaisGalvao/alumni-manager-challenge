<template>
    <div class="container">
        <!-- Formulário de Turma -->
        <turma-form 
            v-if="editingTurma" 
            :turma="editingTurma" 
            @turma-saved="fetchTurmas" 
            @cancel-edit="cancelEdit">
        </turma-form>
        <turma-form v-else @turma-saved="fetchTurmas"></turma-form>

        <!-- Lista de Turmas -->
        <turma-list 
            :turmas="turmas" 
            :pagination="pagination"
            @edit-turma="setEditingTurma" 
            @turma-deleted="fetchTurmas"
            @change-page="fetchTurmas">
        </turma-list>
    </div>
</template>

<script>
import TurmaForm from './TurmaForm.vue';
import TurmaList from './TurmaList.vue';

export default {
    components: {
        TurmaForm,
        TurmaList
    },
    data() {
        return {
            turmas: [],
            pagination: {
                current_page: 1,
                last_page: 1
            },
            editingTurma: null
        };
    },
    methods: {
        fetchTurmas(page = 1) {
            axios.get(`/turmas?page=${page}`)
                .then(response => {
                    this.turmas = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page
                    };
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao buscar as turmas.');
                });
        },
        setEditingTurma(turma) {
            this.editingTurma = turma;
        },
        cancelEdit() {
            this.editingTurma = null;
        }
    },
    created() {
        this.fetchTurmas();
    }
};
</script>

<style scoped>
.container {
    margin-top: 20px;
}
</style>
