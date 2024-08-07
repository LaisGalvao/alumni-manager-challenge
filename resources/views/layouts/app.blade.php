<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet">

    <style>
        /* Estilos para o menu lateral */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
           /*  background-color: #f8f9fa; */
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #f8f9fa;
            display: block;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .main-content {
            padding: 20px;
        }
       /* resources/css/dark-theme.css */

/* Fundo principal */
body {
    background-color: #202427; /* Fundo escuro */
    color: #e0e0e0; /* Texto claro */
    font-family: 'Nunito', sans-serif;
}

/* Cabeçalho */
.navbar {
    background-color: #202427; /* Fundo escuro no cabeçalho */
    color: #e0e0e0; /* Texto claro no cabeçalho */
}

/* Links */
a {
    color: #ed145b; /* Cor dos links */
}

a:hover {
    color: #ff5b77; /* Cor dos links ao passar o mouse */
}

/* Botões */
.btn-primary {
    background-color: #ed145b; /* Cor de fundo dos botões primários */
    border-color: #ed145b; /* Cor da borda dos botões primários */
    color: #fff; /* Texto branco nos botões primários */
}

.btn-primary:hover {
    background-color: #d11a51; /* Cor de fundo dos botões primários ao passar o mouse */
    border-color: #d11a51; /* Cor da borda dos botões primários ao passar o mouse */
}

/* Botões Secundários */
.btn-secondary {
    background-color: #333; /* Cor de fundo dos botões secundários */
    border-color: #444; /* Cor da borda dos botões secundários */
    color: #e0e0e0; /* Texto claro nos botões secundários */
}

.btn-secondary:hover {
    background-color: #444; /* Cor de fundo dos botões secundários ao passar o mouse */
    border-color: #555; /* Cor da borda dos botões secundários ao passar o mouse */
}

/* Cards e Painéis */
.card, .panel {
    background-color: #2c2f32; /* Fundo dos cards e painéis */
    color: #e0e0e0; /* Texto claro dentro dos cards e painéis */
    border: 1px solid #333; /* Borda dos cards e painéis */
}

.card-header {
    background-color: #202427; /* Fundo do cabeçalho dos cards */
    color: #e0e0e0; /* Texto claro no cabeçalho dos cards */
}

/* Tabelas */
.table {
    background-color: #2c2f32; /* Fundo da tabela */
    color: #e0e0e0; /* Texto claro na tabela */
}

.table thead {
    background-color: #202427; /* Fundo da cabeça da tabela */
}

.table tbody tr:hover {
    background-color: #333; /* Fundo da linha ao passar o mouse */
}

/* Rodapé */
footer {
    background-color: #202427; /* Fundo do rodapé */
    color: #e0e0e0; /* Texto claro no rodapé */
}

/* Formularios */
.form-control {
    background-color: #2c2f32; /* Fundo dos campos de formulário */
    color: #e0e0e0; /* Texto claro nos campos de formulário */
    border: 1px solid #333; /* Borda dos campos de formulário */
}

.form-control:focus {
    border-color: #ed145b; /* Cor da borda ao focar no campo de formulário */
    box-shadow: 0 0 0 0.2rem rgba(237, 20, 91, 0.25); /* Sombra ao focar no campo de formulário */
}
    </style>
</head>
<body>
    <div id="app">
        @auth
            @if(Auth::user()->role === 'admin')
                <div class="sidebar">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('alunos.index') }}">Gerenciar Alunos</a>
                    <a href="{{ route('turmas.index') }}">Gerenciar Turmas</a>
                    <a href="{{ route('matriculas.index') }}">Matrícula de Alunos</a>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endif
        @endauth

        <div class="content">
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
