<template>
  <div>
    <h2>Matricular Aluno</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="aluno_id">Aluno:</label>
        <select v-model="matricula.aluno_id" required>
          <option v-for="aluno in alunos" :key="aluno.id" :value="aluno.id">
            {{ aluno.nome }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="turma_id">Turma:</label>
        <select v-model="matricula.turma_id" required>
          <option v-for="turma in turmas" :key="turma.id" :value="turma.id">
            {{ turma.nome }}
          </option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Matricular</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      matricula: {
        aluno_id: '',
        turma_id: '',
      },
      alunos: [],
      turmas: [],
    };
  },
  mounted() {
    // Fetching the students and classes data
    axios.get('/api/alunos').then(response => {
      this.alunos = response.data;
    });

    axios.get('/api/turmas').then(response => {
      this.turmas = response.data;
    });
  },
  methods: {
    submitForm() {
      axios.post('/matriculas', this.matricula)
        .then(response => {
          alert('Aluno matriculado com sucesso!');
          this.matricula = { aluno_id: '', turma_id: '' };
        })
        .catch(error => {
          alert('Erro ao matricular aluno.');
        });
    },
  },
};
</script>

<style scoped>
/* Estilos opcionais para o componente */
</style>

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