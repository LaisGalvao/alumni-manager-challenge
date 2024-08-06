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
