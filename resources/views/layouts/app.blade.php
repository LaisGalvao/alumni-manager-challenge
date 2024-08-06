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

    <style>
        /* Estilos para o menu lateral */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
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
