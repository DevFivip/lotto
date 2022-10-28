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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Alpine Plugins -->
    <script src="https://unpkg.com/@victoryoalli/alpinejs-moment@1.0.0/dist/moment.min.js" defer></script>
    <!-- Alpine Core -->
    <!-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" integrity="sha512-y22y4rJ9d7NGoRLII5LVwUv0BfQKf6MpATy5ebVu/fbHdtJCxBpZRHZMHJv8VYl8scWjuwZcMPzwYk4sEoyL4A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
                            <a class="nav-link" href="/tickets/create"> + Nuevo Ticket</a>
                        </li>
                        @endif
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/tickets">Listado de Tickets</a>
                        </li>
                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        <li class="nav-item d-block d-sm-none">
                            <a class="nav-link" href="/usuarios">Usuarios</a>
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