<template>
    <div>
        <ul>
            <li v-for="turma in turmas" :key="turma.id">
                <strong>{{ turma.nome }}</strong> - {{ turma.descricao }} ({{ turma.tipo }})
                <button @click="editTurma(turma)">Editar</button>
                <button @click="deleteTurma(turma.id)">Excluir</button>
            </li>
        </ul>
        <div v-if="pagination.total > pagination.per_page">
            <button @click="fetchTurmas(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">Anterior</button>
            <button @click="fetchTurmas(pagination.next_page_url)" :disabled="!pagination.next_page_url">Próximo</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            turmas: [],
            pagination: {}
        };
    },
    methods: {
        fetchTurmas(url = '/turmas') {
            axios.get(url)
                .then(response => {
                    this.turmas = response.data.data;
                    this.pagination = response.data.meta;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        editTurma(turma) {
            this.$emit('edit-turma', turma);
        },
        deleteTurma(id) {
            if (confirm('Você tem certeza que deseja excluir esta turma?')) {
                axios.delete(`/turmas/${id}`)
                    .then(() => {
                        alert('Turma excluída com sucesso.');
                        this.fetchTurmas();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao excluir a turma.');
                    });
            }
        }
    },
    mounted() {
        this.fetchTurmas();
    }
};
</script>
