<template>
    <div>
        <label for="turma_id">Selecione a Turma:</label>
        <select v-model="selectedTurmaId" @change="fetchMatriculados" id="turma_id">
            <option v-for="turma in turmas" :value="turma.id" :key="turma.id">{{ turma.nome }}</option>
        </select>

        <div v-if="matriculados.length">
            <h3>Alunos Matriculados</h3>
            <ul>
                <li v-for="aluno in matriculados" :key="aluno.id">{{ aluno.nome }}</li>
            </ul>
        </div>
        <div v-else>
            <p>Nenhum aluno matriculado nesta turma.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            turmas: [],
            selectedTurmaId: null,
            matriculados: []
        };
    },
    methods: {
        fetchTurmas() {
            axios.get('/turmas')
                .then(response => {
                    this.turmas = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchMatriculados() {
            if (this.selectedTurmaId) {
                axios.get(`/matriculas/turma/${this.selectedTurmaId}`)
                    .then(response => {
                        this.matriculados = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                this.matriculados = [];
            }
        }
    },
    mounted() {
        this.fetchTurmas();
    }
};
</script>
