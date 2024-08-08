<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Alumni Manager Challenge') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            display: flex;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #202427;
            padding-top: 20px;
            transition: transform 0.3s ease;
        }
        .sidebar.closed {
            transform: translateX(-100%);
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
            flex-grow: 1;
        }
        .menu-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #202427;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        @media (max-width: 920px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                z-index: 999;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        @auth
            @if(Auth::user()->role === 'admin')
                <button class="menu-toggle" id="menu-toggle">☰ Menu</button>
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
