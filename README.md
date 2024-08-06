# Alumni Manager Challenge

## Descrição

Este projeto é uma aplicação web desenvolvida com Laravel (PHP 7.4) e Vue.js. O sistema permite o gerenciamento de alunos, turmas e matrículas com funcionalidades administrativas e uma interface de usuário interativa.

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados:

- PHP 7.4 ou superior
- Composer
- Node.js e npm
- MySQL ou outro banco de dados compatível

## Configuração do Projeto

### 1. Clone o Repositório

Clone o repositório para sua máquina local:

```bash
git clone https://github.com/usuario/alumni-manager-challenge.git
cd alumni-manager-challenge
```

### 2. Configuração do Ambiente

Copie o arquivo `.env.example` para um novo arquivo chamado `.env`:

```bash
cp .env.example .env
```

### 3. Instale as Dependências do Backend

Instale as dependências PHP usando o Composer:

```bash
composer install
```

### 4. Gere a Chave da Aplicação

Gere a chave da aplicação Laravel:

```bash
php artisan key:generate
```

### 5. Configure o Banco de Dados

Edite o arquivo `.env` e configure as variáveis de ambiente para o seu banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

### 6. Importe o Dump do Banco de Dados

Se você possui um dump do banco de dados, importe-o para o seu banco de dados MySQL:

```bash
mysql -u usuario -p nome_do_banco < caminho/para/seu_dump.sql
```

Substitua `usuario`, `nome_do_banco`, e `caminho/para/seu_dump.sql` pelos valores apropriados para seu ambiente.

### 7. Instale as Dependências do Frontend

Instale as dependências do Node.js usando o npm:

```bash
npm install
```

### 8. Compile os Assets

Compile os assets para o frontend:

```bash
npm run dev
```

### 9. Inicie o Servidor

Inicie o servidor de desenvolvimento Laravel:

```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`.

## Uso

- **Administração de Alunos**: Acesse `http://localhost:8000/alunos` para gerenciar alunos.
- **Administração de Turmas**: Acesse `http://localhost:8000/turmas` para gerenciar turmas.
- **Matrículas**: Acesse `http://localhost:8000/matriculas` para gerenciar matrículas.

## Autenticação

Somente usuários administradores têm acesso às funcionalidades de administração. Você pode criar um usuário administrador através do seeder ou diretamente no banco de dados e fazer login com essas credenciais para acessar as áreas administrativas.

## Contribuição

Se você deseja contribuir para o projeto, por favor siga estas etapas:

1. Faça um fork do repositório.
2. Crie uma branch para sua feature ou correção (`git checkout -b feature/nome-da-feature`).
3. Commit suas alterações (`git commit -am 'Adiciona nova feature'`).
4. Faça um push para a branch (`git push origin feature/nome-da-feature`).
5. Abra um pull request.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

## Contato

Se você tiver alguma dúvida ou sugestão, entre em contato:

- **E-mail:** seuemail@example.com
- **GitHub:** [github.com/usuario](https://github.com/usuario)

### Explicações das Novas Seções

- **Importe o Dump do Banco de Dados**: Inclui instruções para importar um dump SQL para configurar o banco de dados.

Ajuste os detalhes conforme necessário para corresponder ao seu ambiente e ao seu projeto específico. Isso garantirá que outras pessoas possam configurar o projeto corretamente com base no dump do banco de dados que você forneceu.