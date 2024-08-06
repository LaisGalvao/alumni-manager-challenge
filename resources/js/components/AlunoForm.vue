<template>
    <div class="form-container">
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input v-model="aluno.nome" type="text" id="nome" class="form-control" required />
                <span class="error-message" v-if="errors.nome">{{ errors.nome }}</span>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input v-model="aluno.data_nascimento" type="date" id="data_nascimento" class="form-control" required />
                <span class="error-message" v-if="errors.data_nascimento">{{ errors.data_nascimento }}</span>
            </div>
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input v-model="aluno.usuario" type="text" id="usuario" class="form-control" required />
                <span class="error-message" v-if="errors.usuario">{{ errors.usuario }}</span>
            </div>
            <button class="btn-primary" type="submit">Salvar</button>
        </form>
    </div>
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
    background-color: #2c2f32;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: #e0e0e0;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #ed145b;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #333;
    border-radius: 4px;
    background-color: #e0e0e0;
    color: #2c2f32;
}

.form-control:focus {
    border-color: #ed145b;
    box-shadow: 0 0 0 0.2rem rgba(237, 20, 91, 0.25);
}

.error-message {
    color: #ff5b77;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #ed145b;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #d11a51;
}
</style>
