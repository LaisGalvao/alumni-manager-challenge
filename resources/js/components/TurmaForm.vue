<template>
    <div class="form-container">
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input 
                    v-model="turma.nome" 
                    type="text" 
                    id="nome" 
                    class="form-control" 
                    required 
                />
                <div v-if="errors.nome" class="error-message">{{ errors.nome }}</div>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea 
                    v-model="turma.descricao" 
                    id="descricao" 
                    class="form-control"
                ></textarea>
                <div v-if="errors.descricao" class="error-message">{{ errors.descricao }}</div>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input 
                    v-model="turma.tipo" 
                    type="text" 
                    id="tipo" 
                    class="form-control" 
                    required 
                />
                <div v-if="errors.tipo" class="error-message">{{ errors.tipo }}</div>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ editing ? 'Atualizar' : 'Salvar' }}
            </button>
            <button 
                type="button" 
                class="btn btn-secondary" 
                @click="cancelEdit" 
                v-if="editing"
            >
                Cancelar
            </button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        turma: {
            type: Object,
            default: () => ({ nome: '', descricao: '', tipo: '' })
        }
    },
    data() {
        return {
            editing: false,
            errors: {}
        };
    },
    watch: {
        turma: {
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

            // Validação
            if (this.turma.nome.length < 3) {
                this.errors.nome = 'O nome deve ter pelo menos 3 caracteres.';
            }
            if (!this.turma.descricao) {
                this.errors.descricao = 'A descrição é obrigatória.';
            }
            if (this.turma.tipo.length < 3) {
                this.errors.tipo = 'O tipo deve ter pelo menos 3 caracteres.';
            }
            
            if (Object.keys(this.errors).length > 0) {
                return; // Não envia o formulário se houver erros
            }

            // Enviar dados
            const method = this.editing ? 'put' : 'post';
            const url = this.editing ? `/turmas/${this.turma.id}` : '/turmas';
            
            axios[method](url, this.turma)
                .then(response => {
                    this.$emit('turma-saved');
                    this.editing = false;
                    this.$emit('cancel-edit'); // Emite o evento de cancelamento de edição após salvar
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao salvar a turma.');
                });
        },
        cancelEdit() {
            this.$emit('cancel-edit');
        }
    }
};
</script>

<style scoped>
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
    border: 1px solid #ccc;
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

.btn-secondary {
    background-color: #6c757d; /* Cor de fundo do botão secundário */
    border: none;
    color: #fff; /* Texto branco no botão */
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #5a6268; /* Cor de fundo ao passar o mouse */
}
</style>
