<template>
    <div>
        <h2>Matricular Aluno em Turma</h2>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="turma">Turma:</label>
                <select v-model="selectedTurma" id="turma" class="form-control" required>
                    <option v-for="turma in turmas" :key="turma.id" :value="turma.id">
                        {{ turma.nome }}
                    </option>
                </select>
                <span v-if="errors.turma" class="error-message">{{ errors.turma }}</span>
            </div>
            <div class="form-group">
                <label for="aluno">Aluno:</label>
                <select v-model="selectedAluno" id="aluno" class="form-control" required>
                    <option v-for="aluno in alunos" :key="aluno.id" :value="aluno.id">
                        {{ aluno.nome }}
                    </option>
                </select>
                <span v-if="errors.aluno" class="error-message">{{ errors.aluno }}</span>
            </div>
            <button type="submit" class="btn btn-primary">Matricular</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            turmas: [],
            alunos: [],
            selectedTurma: null,
            selectedAluno: null,
            errors: {}
        };
    },
    methods: {
        fetchTurmas() {
            axios.get('/turmas')
                .then(response => {
                    this.turmas = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchAlunos() {
            axios.get('/alunos')
                .then(response => {
                    this.alunos = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitForm() {
            this.errors = {}; // Limpa erros anteriores

            if (!this.selectedTurma) {
                this.errors.turma = 'Selecione uma turma.';
            }
            if (!this.selectedAluno) {
                this.errors.aluno = 'Selecione um aluno.';
            }
            
            if (Object.keys(this.errors).length > 0) {
                return; // Não envia o formulário se houver erros
            }

            // Verifica se a matrícula já existe
            axios.get(`/matriculas/check?turma_id=${this.selectedTurma}&aluno_id=${this.selectedAluno}`)
                .then(response => {
                    if (response.data.exists) {
                        alert('Este aluno já está matriculado nesta turma.');
                    } else {
                        // Se não existir, realiza a matrícula
                        this.matricularAluno();
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocorreu um erro ao verificar a matrícula.');
                });
        },
        matricularAluno() {
            axios.post(`/matriculas`, {
                turma_id: this.selectedTurma,
                aluno_id: this.selectedAluno
            })
            .then(response => {
                alert('Matrícula efetuada com sucesso!');
                this.selectedTurma = null;
                this.selectedAluno = null;
                this.$emit('matricula-updated'); // Emite evento quando uma matrícula é feita
            })
            .catch(error => {
                console.error(error);
                alert('Ocorreu um erro ao matricular o aluno.');
            });
        }
    },
    created() {
        this.fetchTurmas();
        this.fetchAlunos();
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
    background-color: #2c2f32;
    color: #e0e0e0;
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
