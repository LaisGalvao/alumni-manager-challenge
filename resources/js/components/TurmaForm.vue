<template>
    <form @submit.prevent="submitForm">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input v-model="turma.nome" type="text" id="nome" required />
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea v-model="turma.descricao" id="descricao"></textarea>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <input v-model="turma.tipo" type="text" id="tipo" required />
        </div>
        <button class="btn-primary" type="submit">Salvar</button>
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