<template>
    <form @submit.prevent="submitForm">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input v-model="aluno.nome" type="text" id="nome" class="form-control" required />
            <div v-if="errors.nome" class="text-danger">{{ errors.nome }}</div>
        </div>
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input v-model="aluno.data_nascimento" type="date" id="data_nascimento" class="form-control" required />
            <div v-if="errors.data_nascimento" class="text-danger">{{ errors.data_nascimento }}</div>
        </div>
        <div class="form-group">
            <label for="usuario">Usuário:</label>
            <input v-model="aluno.usuario" type="text" id="usuario" class="form-control" required />
            <div v-if="errors.usuario" class="text-danger">{{ errors.usuario }}</div>
        </div>
        <button type="submit" class="btn btn-primary">{{ editing ? 'Atualizar' : 'Salvar' }}</button>
        <button type="button" class="btn btn-secondary" @click="cancelEdit" v-if="editing">Cancelar</button>
    </form>
</template>

<script>
export default {
    props: {
        aluno: {
            type: Object,
            default: () => ({ nome: '', data_nascimento: '', usuario: '' })
        }
    },
    data() {
        return {
            editing: false,
            errors: {}
        };
    },
    watch: {
        aluno: {
            handler(newVal) {
                this.editing = !!newVal.id;
            },
            deep: true,
            immediate: true
        }
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
            
            if (Object.keys(this.errors).length > 0) {
                return; // Não envia o formulário se houver erros
            }

            const method = this.editing ? 'put' : 'post';
            const url = this.editing ? `/alunos/${this.aluno.id}` : '/alunos';
            
            axios[method](url, this.aluno)
                .then(response => {
                    alert(`Aluno ${this.editing ? 'editado' : 'cadastrado' } com sucesso!`);
                    this.$emit('aluno-saved');
                    this.editing = false;
                    this.$emit('cancel-edit');
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao salvar o aluno.');
                });
        },
        cancelEdit() {
            this.$emit('cancel-edit');
        }
    }
};
</script>

<style scoped>
.form-group {
    margin-bottom: 1rem;
}
.form-control {
    width: 100%;
    padding: 0.5rem;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
.btn {
    color: #fff;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
    background-color: #ed145b;
    border-color: #ed145b;
}
.btn:hover {
    color: #fff;
    background-color: #d11a51;
    border-color: #d11a51;
}

.btn-secondary {
    background-color: #6c757d; /* Cor de fundo do botão secundário */
    border: none;
    color: #fff; /* Texto branco no botão */
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
}

</style>
