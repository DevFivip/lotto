@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Tickets</div>
                <div class="card-body" x-data="mounted()">
                    <a href="/tickets/create" class="btn btn-primary">Nuevo Ticket</a>
                    <button @click="openFilter = !openFilter" class="btn btn-primary">Filtros</button>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <templete x-show="openFilter" x-transition style="display: none;">
                        <div class="card mt-3">
                            <div class="card-header">Filtros</div>
                            <div class="card-body">
                                <form class="row g-3" action="/tickets">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="_perPage" class="form-label">Resultados Cantidad</label>
                                            <select id="_perPage" name="_perPage" class="form-select">
                                                @if(isset($filter['_perPage']))
                                                <option value="{{$filter['_perPage']}}">{{$filter['_perPage']}} por pagina</option>
                                                @endif
                                                <option value="10">10 por pagina</option>
                                                <option value="20">20 por pagina</option>
                                                <option value="50">50 por pagina</option>
                                                <option value="100">100 por pagina</option>
                                                <option value="500">500 por pagina</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="status" class="form-label">Ticket Estado</label>
                                            <select name="has_winner" id="status" class="form-select">
                                                @if(isset($filter['has_winner']))

                                                @if($filter['has_winner'] == 1)
                                                <option selected value="1">Ganador</option>

                                                @endif

                                                @if($filter['has_winner'] == 0)
                                                <option selected value="0">Pendientes y Perdedores</option>

                                                @endif

                                                @endif
                                                <option></option>
                                                <option value="1">Ganador</option>
                                                <option value="0">Pendientes y Perdedores</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="moneda_id" class="form-label">Moneda</label>
                                            <select id="moneda_id" name="moneda_id" class="form-select">
                                                <option></option>
                                                @foreach($monedas as $moneda)


                                                @if(isset($filter['moneda_id']))
                                                @if($filter['moneda_id'] == $moneda->id)
                                                <option selected value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                                @else

                                                @endif
                                                @endif

                                                <option value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)

                                        <div class="col-md-4">
                                            <label for="user_id" class="form-label">Usuarios</label>
                                            <select id="user_id" name="user_id" class="form-select">
                                                <option></option>

                                                @foreach($usuarios as $usuario)
                                                @if(isset($filter['user_id']))
                                                @if($filter['user_id'] == $usuario->id)
                                                <option selected value="{{$usuario->id}}">{{$usuario->name}}-{{$usuario->taquilla_name}}</option>
                                                @else
                                                @endif
                                                @endif

                                                <option value="{{$usuario->id}}">{{$usuario->name}}-{{$usuario->taquilla_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label for="created_at_inicio" class="form-label">Fecha Inicio</label>
                                            <input name="created_at_inicio" type="date" class="form-control" placeholder="Fecha inicio">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="created_at_final" class="form-label">Fecha Final</label>
                                            <input name="created_at_final" type="date" class="form-control" placeholder="Fecha fin">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary fw-bold">Buscar</button>
                                        <a href="/tickets" class="btn btn-warning fw-bold">Reiniciar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </templete>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td></td>
                                <td>Fecha y Hora</td>
                                <td>Codigo</td>
                                <td>Vendedor</td>
                                <td>Total</td>
                                <td>Premios</td>
                                <td>Pagado</td>
                                <td>Pendiente</td>
                            </tr>
                            @foreach($tickets as $ticket)
                            <tr x-data="converter('{{$ticket->created_at}}')">
                                <td>
                                    @if($ticket->status == 1)
                                    <span class="badge bg-warning text-dark">Correcto</span>
                                    @elseif($ticket->status == 0)
                                    <span class="badge bg-danger">Cancelado</span>
                                    @else($ticket->status == 2)
                                    <span class="badge bg-success">Pagado</span>
                                    @endif
                                    @if($ticket->has_winner == 1)
                                    <span class="badge bg-primary">Ganador</span>
                                    @endif
                                </td>
                                <td x-text="fecha_inicial"></td>
                                <td>{{$ticket->code}}</td>
                                <td> <span class="fw-bold">{{$ticket->user->taquilla_name}}</span> <br> {{$ticket->user->name}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total,'2',',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios,2,',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios_pagados,2,',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios_pendientes,2,',','.')}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" x-bind:href="'/print/{{$ticket->code}}?timezone='+timezone">Ver Ticket</a></li>
                                            <li><button class="dropdown-item" @click="handleDelete('{{$ticket->code}}')">Eliminar</button></li>
                                            @if($ticket->has_winner == 1 && $ticket->total_premios_pendientes > 0)
                                            <li><a class="dropdown-item" href="/tickets/pay/{{$ticket->code}}">Pagar</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex">
                        {!! $tickets->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mounted() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            openFilter: false,
            handleDelete: async function(code) {
                if (confirm("¿Seguro deseas eliminar este tickets?") == true) {
                    const res = await fetch('/register/' + code, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })

                    body = await res.json();
                    console.log(body)
                    if (body.valid) {
                        location.reload()
                    } else {
                        this.toast(body.message, 1000);
                    }
                    // alert()
                }
            },
            toast: function(msg = 'Error al eliminar', duration = 800) {
                Toastify({
                    text: msg,
                    duration: duration,
                    className: "info",
                    close: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
            },
        }
    }

    function converter(q, k) {
        date = new Date(q);
        w = date.getTimezoneOffset()
        yourDate = new Date(date.getTime() - (w * 60 * 1000))
        f1 = yourDate.toLocaleDateString();
        f2 = yourDate.toLocaleTimeString();

        if (!!k) {
            date = new Date(k);
            r = date.getTimezoneOffset()
            yourDate = new Date(date.getTime() - (r * 60 * 1000))
            f3 = yourDate.toLocaleDateString();
            f4 = yourDate.toLocaleTimeString();

        } else {
            f3 = '';
            f4 = '';
        }


        return {
            fecha_inicial: f1 + ' ' + f2,
            fecha_cierre: f3 + ' ' + f4,
        }
    }

    function listener() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            handleLock: async function(e) {
                id = e.target.id
                if (confirm("¿Seguro deseas Bloquear?") == true) {
                    const res = await fetch('/tickets/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })
                    location.reload()
                }
            }
        }
    }
</script>

@endsection