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
        <button class="btn-primary" type="submit">Salvar</button>
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

<style scoped>
/* Estilos para o formulário */
.form-container {
    background-color: #2c2f32; /* Fundo escuro para o formulário */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: #e0e0e0; /* Texto claro no formulário */
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #ed145b; /* Cor dos rótulos */
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #333; /* Borda escura para campos de entrada */
    border-radius: 4px;
    background-color: #2c2f32; /* Fundo escuro para campos de entrada */
    color: #e0e0e0; /* Texto claro nos campos de entrada */
}

.form-control:focus {
    border-color: #ed145b; /* Cor da borda ao focar */
    box-shadow: 0 0 0 0.2rem rgba(237, 20, 91, 0.25); /* Sombra ao focar */
}

.error-message {
    color: #ff5b77; /* Cor das mensagens de erro */
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #ed145b; /* Cor de fundo do botão */
    border: none;
    color: #fff; /* Texto branco no botão */
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #d11a51; /* Cor de fundo ao passar o mouse */
}
</style>