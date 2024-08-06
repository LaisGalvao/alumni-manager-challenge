<template>
    <form @submit.prevent="submitForm">
        <div>
            <label for="nome">Nome:</label>
            <input v-model="turma.nome" type="text" id="nome" required />
        </div>
        <div>
            <label for="descricao">Descrição:</label>
            <textarea v-model="turma.descricao" id="descricao"></textarea>
        </div>
        <div>
            <label for="tipo">Tipo:</label>
            <input v-model="turma.tipo" type="text" id="tipo" required />
        </div>
        <button type="submit">Salvar</button>
    </form>
</template>
<script>
export default {
    data() {
        return {
            turma: { nome: '', descricao: '', tipo: '' },
            errors: {}
        };
    },
    methods: {
        submitForm() {
            this.errors = {};

            if (this.turma.nome.length < 3) {
                this.errors.nome = 'O nome deve ter pelo menos 3 caracteres.';
            }
            if (this.turma.tipo.length < 3) {
                this.errors.tipo = 'O tipo deve ter pelo menos 3 caracteres.';
            }

            if (Object.keys(this.errors).length === 0) {
                const method = this.turma.id ? 'put' : 'post';
                const url = this.turma.id ? `/turmas/${this.turma.id}` : '/turmas';
                
                axios[method](url, this.turma)
                    .then(response => {
                        alert('Turma salva com sucesso!');
                        this.$emit('turma-saved', response.data);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao salvar a turma.');
                    });
            }
        }
    }
};
</script>
