@php
$l = $_SERVER['REQUEST_URI']
@endphp


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
    <script src="{{ asset('js/util.js') }}" defer></script>

    <!-- <script src="/node_modules/chart.js/dist/chart.min.js" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .btn-style-1 {
            background-color: #FF9800;
            border-color: #FF9800;
            color: #fff;
        }

        .btn-style-2 {
            background-color: #EF5350;
            border-color: #EF5350;
            color: #fff;
        }

        .btn-style-3 {
            background-color: #43A047;
            border-color: #43A047;
            color: #fff;
        }

        .btn-style-4 {
            background-color: #757575;
            border-color: #757575;
            color: #fff;
        }

        .btn-style-5 {
            background-color: #607D8B;
            border-color: #607D8B;
            color: #fff;
        }

        .btn-style-6 {
            background-color: #3D5AFE;
            border-color: #3D5AFE;
            color: #fff;
        }

        .btn-style-7 {
            background-color: #F4511E;
            border-color: #F4511E;
            color: #fff;
        }
    </style>


    <!-- Alpine Plugins -->
    <script src="https://unpkg.com/@victoryoalli/alpinejs-moment@1.0.0/dist/moment.min.js" defer></script>
    <!-- Alpine Core -->
    <!-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" integrity="sha512-y22y4rJ9d7NGoRLII5LVwUv0BfQKf6MpATy5ebVu/fbHdtJCxBpZRHZMHJv8VYl8scWjuwZcMPzwYk4sEoyL4A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @yield('scripts')
</head>

<body>
    <div id="app">
        <nav class="mb-1 navbar navbar-expand-md navbar-light bg-white shadow-sm  @if($l =='/tickets/create') d-none d-sm-block @endif">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    @if(!!isset(auth()->user()->id))
                    <ul class="navbar-nav me-auto">
                        @if(auth()->user()->role_id == 3 || auth()->user()->role_id == 1)
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tickets/create">+ Ticket Animalitos</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tripletas/create">+ Ticket Tripletas</a>
                        </li>

                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tickets">Listado de Animalitos</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tripletas">Listado de Tripletas</a>
                        </li>

                        <li class="nav-item d-block d-sm-none">
                            <!-- <a class="nav-link" href="/tickets/create"> + Nuevo Ticket</a> -->
                            <a href="/tickets/create" class="nav-link disabled">Bingo 🎱</a>
                        </li>
                        @endif

                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)

                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tickets">Listado de Animalitos</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tripletas">Listado de Tripletas</a>
                        </li>

                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/usuarios">Usuarios</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/schedules-admin">Horarios</a>
                        </li>
                        @endif
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/cajas">Caja</a>
                        </li>
                        @if(auth()->user()->role_id == 2)
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/cash-admins/{{auth()->user()->id}}">Caja Administrativa</a>
                        </li>
                        @endif

                        @if(auth()->user()->id == 16)
                        <!-- <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/animals">Animales</a>
                        </li> -->
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/hipismo/">Hipisimo Reporte</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/hipismo/taquilla">Hipisimo Taquilla</a>
                        </li>
                        @endif

                        @if(auth()->user()->role_id == 1)
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/cash-admins">Cajas Administrativas</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/customers">Clientes</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/animals">Animales</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/payments">Metodos de Pagos</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/schedules">Horarios</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/lottoloko">⭐Lotto Plus</a>
                        </li>
                        @endif
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/resultados">Resultados</a>
                        </li>
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/reports">Reportes</a>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        <!-- @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif -->
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="p-md-4">
            @yield('content')
        </main>
    </div>
</body>

</html>