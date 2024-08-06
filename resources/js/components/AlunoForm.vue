<template>
    <form @submit.prevent="submitForm">
        <div>
            <label for="nome">Nome:</label>
            <input v-model="aluno.nome" type="text" id="nome" required />
        </div>
        <div>
            <label for="data_nascimento">Data de Nascimento:</label>
            <input v-model="aluno.data_nascimento" type="date" id="data_nascimento" required />
        </div>
        <div>
            <label for="usuario">Usuário:</label>
            <input v-model="aluno.usuario" type="text" id="usuario" required />
        </div>
        <button type="submit">Salvar</button>
    </form>
</template>
<script>
export default {
    data() {
        return {
            aluno: { nome: '', data_nascimento: '', usuario: '' },
            errors: {}
        };
    },
    methods: {
        submitForm() {
            this.errors = {}; // Limpa erros anteriores

            if (this.aluno.nome.length < 3) {
                this.errors.nome = 'O nome deve ter pelo menos 3 caracteres.';
            }
            if (!this.aluno.data_nascimento) {
                this.errors.data_nascimento = 'A data de nascimento é obrigatória.';
            }
            if (this.aluno.usuario.length < 3) {
                this.errors.usuario = 'O usuário deve ter pelo menos 3 caracteres.';
            }

            if (Object.keys(this.errors).length === 0) {
                axios.post('/alunos', this.aluno)
                    .then(response => {
                        alert('Aluno salvo com sucesso!');
                        this.$emit('aluno-saved', response.data);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao salvar o aluno.');
                    });
            }
        }
    }
};
</script>
