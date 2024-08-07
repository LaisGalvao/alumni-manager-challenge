<template>
    <div>
        <!-- Formulário de Matrícula -->
        <matricula-form @matricula-updated="updateAlunos"></matricula-form>

        <!-- Lista de Alunos Matriculados -->
        <matricula-list :turma-id="selectedTurmaId" ref="turmaAlunos"></matricula-list>
    </div>
</template>

<script>
import MatriculaForm from './MatriculaForm.vue';
import MatriculaList from './MatriculaList.vue';

export default {
    components: {
        MatriculaForm,
        MatriculaList
    },
    data() {
        return {
            selectedTurmaId: null
        };
    },
    methods: {
        updateAlunos(turmaId) {
            this.selectedTurmaId = turmaId;
            this.$refs.turmaAlunos.fetchAlunos(); // Atualiza a lista de alunos após a matrícula
        }
    }
};
</script>

<style scoped>
/* Adicione estilos se necessário */
</style>
