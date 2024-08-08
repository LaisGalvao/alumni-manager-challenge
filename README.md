# Alumni Manager Challenge
---

# Sumário

1. [Descrição](#descrição)
2. [Pré-requisitos](#pré-requisitos)
3. [Configuração do Projeto](#configuração-do-projeto)
   - [Clone o Repositório](#clone-o-repositório)
   - [Configuração do Ambiente](#configuração-do-ambiente)
   - [Instale as Dependências do Backend](#instale-as-dependências-do-backend)
   - [Gere a Chave da Aplicação](#gere-a-chave-da-aplicação)
   - [Configure o Banco de Dados](#configure-o-banco-de-dados)
   - [Execute as Migrations](#execute-as-migrations)
   - [Popule o Banco de Dados com Dados de Teste](#popule-o-banco-de-dados-com-dados-de-teste)
   - [Atualize o Autoload](#atualize-o-autoload)
   - [Importe o Dump do Banco de Dados](#importe-o-dump-do-banco-de-dados)
   - [Instale as Dependências do Frontend](#instale-as-dependências-do-frontend)
   - [Compile os Assets](#compile-os-assets)
   - [Inicie o Servidor](#inicie-o-servidor)
4. [Uso](#uso)
   - [Administração de Alunos](#administração-de-alunos)
   - [Administração de Turmas](#administração-de-turmas)
   - [Matrículas](#matrículas)
   - [Tela de Login](#tela-de-login)
   - [Dashboard](#dashboard)
5. [Autenticação](#autenticação)
6. [Documentação do Projeto](#documentação-do-projeto)
   - [Controllers](#controllers)
     - [TurmaController](#turmacontroller)
     - [MatriculaController](#matriculacontroller)
   - [Testes](#testes)
     - [TurmaControllerTest](#turmacontrollertest)
     - [MatriculaControllerTest](#matriculacontrollertest)

---

Você pode ajustar ou adicionar mais seções conforme necessário. O sumário ajuda a estruturar o README e permite que os usuários acessem rapidamente as partes mais importantes do documento.

## Descrição

Este projeto é uma aplicação web desenvolvida com Laravel (PHP 7.4) e Vue.js. O sistema permite o gerenciamento de alunos, turmas e matrículas com funcionalidades administrativas e uma interface de usuário interativa.

## Pré-requisitos

Antes de começar, certifique-se de que atende os seguintes pré-requisitos:

- PHP 7.4 ou superior
- Composer
- Node.js e npm
- MySQL ou outro banco de dados compatível

## Configuração do Projeto

### Clone o Repositório

Clone o repositório para sua máquina local:

```bash
git clone https://github.com/usuario/alumni-manager-challenge.git
cd alumni-manager-challenge
```

### Configuração do Ambiente

Copie o arquivo `.env.example` para um novo arquivo chamado `.env`:

```bash
cp .env.example .env
```

### Instale as Dependências do Backend

Instale as dependências PHP usando o Composer:

```bash
composer install
```

### Gere a Chave da Aplicação

Gere a chave da aplicação Laravel:

```bash
php artisan key:generate
```

### Configure o Banco de Dados

Edite o arquivo `.env` e configure as variáveis de ambiente para o seu banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_alumni_challenge
DB_USERNAME=usuario
DB_PASSWORD=senha
```

### Execute as Migrations

Execute as migrations para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

### Popule o Banco de Dados com Dados de Teste

Se desejar adicionar dados de teste ao banco de dados, execute o seeder:

```bash
php artisan db:seed
```

### Atualize o Autoload

Atualize o autoload para garantir que todas as classes e arquivos sejam carregados corretamente:

```bash
composer dump-autoload
```

### Importe o Dump do Banco de Dados

Se você possui um dump do banco de dados, importe-o para o seu banco de dados MySQL:

```bash
mysql -u usuario -p db_alumni_challenge < caminho/para/alumni_dump.sql
```

Substitua `usuario`, `db_alumni_challenge`, e `caminho/para/alumni_dump.sql` pelos valores apropriados para seu ambiente.

### Instale as Dependências do Frontend

Instale as dependências do Node.js usando o npm:

```bash
npm install
```

### Compile os Assets

Compile os assets para o frontend:

```bash
npm run dev
```

### Inicie o Servidor

Inicie o servidor de desenvolvimento Laravel:

```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`.

## Uso

A aplicação possui diferentes telas para gerenciar as funcionalidades principais do sistema. Abaixo estão descritas as principais telas disponíveis:

### Administração de Alunos

- **Descrição**: Nesta tela, você pode visualizar, criar, editar e excluir registros de alunos.
- **URL**: `http://localhost:8000/alunos`
- **Funcionalidades**:
  - **Lista de Alunos**: Visualize uma lista paginada de alunos registrados no sistema.
  - **Criar Novo Aluno**: Formulário para adicionar um novo aluno ao sistema.
  - **Editar Aluno**: Formulário para editar as informações de um aluno existente.
  - **Excluir Aluno**: Remova um aluno do sistema.

### Administração de Turmas

- **Descrição**: Nesta tela, você pode visualizar, criar, editar e excluir turmas.
- **URL**: `http://localhost:8000/turmas`
- **Funcionalidades**:
  - **Lista de Turmas**: Visualize uma lista paginada de turmas disponíveis no sistema.
  - **Criar Nova Turma**: Formulário para adicionar uma nova turma ao sistema.
  - **Editar Turma**: Formulário para editar as informações de uma turma existente.
  - **Excluir Turma**: Remova uma turma do sistema.

### Matrículas

- **Descrição**: Nesta tela, você pode gerenciar as matrículas dos alunos nas turmas.
- **URL**: `http://localhost:8000/matriculas`
- **Funcionalidades**:
  - **Lista de Matrículas**: Visualize uma lista de todas as matrículas existentes.
  - **Criar Nova Matrícula**: Formulário para matricular um aluno em uma turma.
  - **Remover Matrícula**: Permite a remoção de uma matrícula existente.

### Tela de Login

- **Descrição**: Tela onde os usuários podem se autenticar para acessar áreas administrativas do sistema.
- **URL**: `http://localhost:8000/login`
- **Funcionalidades**:
  - **Login de Usuário**: Formulário para autenticação de usuários administradores e comuns.
  - **Recuperar Senha**: Link para recuperação de senha caso o usuário a tenha esquecido.

### Dashboard

- **Descrição**: Tela principal após o login, fornecendo uma visão geral das principais funcionalidades e métricas do sistema.
- **URL**: `http://localhost:8000/dashboard`
- **Funcionalidades**:
  - **Visão Geral**: Resumo das atividades recentes e métricas importantes.
  - **Acesso Rápido**: Links rápidos para acessar áreas de administração, como alunos, turmas e matrículas.

## Autenticação

Somente usuários administradores têm acesso às funcionalidades de administração. Você pode criar um usuário administrador através do seeder ou diretamente no banco de dados e fazer login com essas credenciais para acessar as áreas administrativas.

## Documentação do Projeto

### Controllers

#### `TurmaController`

O `TurmaController` gerencia as operações relacionadas a `Turma`. Ele possui os seguintes métodos:

- **`index()`**  
  Retorna uma lista paginada de turmas. Se a requisição for AJAX, retorna a lista no formato JSON. Caso contrário, retorna a view com a lista de turmas.

- **`create()`**  
  Retorna a view com o formulário para criação de uma nova turma.

- **`store(Request $request)`**  
  Valida os dados da requisição e cria uma nova turma. Redireciona para a lista de turmas com uma mensagem de sucesso.

- **`edit(Turma $turma)`**  
  Retorna a view com o formulário para edição da turma especificada.

- **`update(Request $request, $id)`**  
  Atualiza os dados da turma especificada e retorna uma resposta JSON com a mensagem de sucesso e os dados atualizados.

- **`destroy($id)`**  
  Remove a turma especificada e retorna uma resposta JSON com a mensagem de sucesso.

#### `MatriculaController`

O `MatriculaController` gerencia as operações relacionadas a `Matricula`. Ele possui os seguintes métodos:

- **`index()`**  
  Retorna uma lista de todas as matrículas. Se a requisição for AJAX, retorna a lista no formato JSON. Caso contrário, retorna a view com a lista de matrículas.

- **`show($turma_id)`**  
  Retorna a view com a turma especificada e a lista de matrículas associadas a essa turma.

- **`store(Request $request)`**  
  Valida os dados da requisição e cria uma nova matrícula, se o aluno ainda não estiver matriculado na turma. Redireciona com uma mensagem de sucesso ou erro.

- **`check(Request $request)`**  
  Verifica se existe uma matrícula para o aluno e turma especificados e retorna um JSON com o resultado da verificação.

- **`destroy($id)`**  
  Remove a matrícula especificada e retorna uma resposta JSON com a mensagem de sucesso ou erro se a matrícula não for encontrada.

### Testes

#### `TurmaControllerTest`

Os testes para o `TurmaController` garantem que as operações relacionadas a turmas estejam funcionando corretamente:

- **Testa o acesso ao endpoint sem autenticação:**  
  Verifica se uma requisição não autenticada é redirecionada para a página de login.

- **Testa o acesso ao endpoint para usuários autenticados:**  
  Verifica se um usuário autenticado consegue acessar a lista de turmas e se os dados retornados são exibidos corretamente.

#### `MatriculaControllerTest`

Os testes para o `MatriculaController` garantem que as operações relacionadas a matrículas estejam funcionando corretamente:

- **Testa o acesso ao endpoint sem autenticação:**  
  Verifica se uma requisição não autenticada para a lista de matrículas é redirecionada para a página de login.

- **Testa o acesso ao endpoint para usuários autenticados:**  
  Verifica se um usuário autenticado consegue acessar a lista de matrículas e se os dados retornados são exibidos corretamente.

---
