<template>
    <div>
        <input v-model="query" @input="search" type="text" placeholder="Buscar aluno por nome" />
        <ul v-if="results.length">
            <li v-for="aluno in results" :key="aluno.id">{{ aluno.nome }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: '',
            results: []
        };
    },
    methods: {
        search() {
            if (this.query.length > 2) {
                axios.get('/alunos/search', { params: { search: this.query } })
                    .then(response => {
                        this.results = response.data;
                    });
            } else {
                this.results = [];
            }
        }
    }
};
</script>
