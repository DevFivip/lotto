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
                                        <div class="col-md-2">
                                            <label for="status" class="form-label">Estado</label>
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
                                        @if(auth()->user()->role_id != 3)
                                        <div class="col-md-2">
                                            <label for="status" class="form-label">Validez</label>
                                            <select name="status" id="status" class="form-select">
                                                @if(isset($filter['status']))

                                                @if($filter['status'] == 1)
                                                <option selected value="1">Correcto</option>

                                                @endif

                                                @if($filter['status'] == 0)
                                                <option selected value="0">Eliminado</option>

                                                @endif

                                                @endif
                                                <option></option>
                                                <option value="1">Correcto</option>
                                                <option value="0">Eliminado</option>
                                            </select>
                                        </div>
                                        @endif
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
                                                <option selected value="{{$usuario->id}}">{{$usuario->taquilla_name}}-{{$usuario->name}}</option>
                                                @else
                                                @endif
                                                @endif

                                                <option value="{{$usuario->id}}">{{$usuario->taquilla_name}}-{{$usuario->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="animal_id" class="form-label">Animalito</label>
                                            <select multiple id="animal_id" name="animal_id[]" class="form-select">
                                                <option></option>
                                                @foreach($animalitos as $animal)
                                                @if(isset($filter['animal_id']))
                                                @if($filter['animal_id'] == $animal->id)
                                                <option selected value="{{$animal->id}}">{{$animal->type->name}} {{$animal->number}} {{$animal->nombre}}</option>
                                                @else
                                                @endif
                                                @endif
                                                @if(isset($animal->type))
                                                <option value="{{$animal->id}}">{{$animal->type->name}} {{$animal->number}} {{$animal->nombre}}</option>
                                                @endif
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
                                    <span class="badge bg-danger">Eliminado</span>
                                    @else($ticket->status == 2)
                                    <span class="badge bg-success">Pagado</span>
                                    @endif
                                    @if($ticket->has_winner == 1)
                                    <span class="badge bg-primary">Ganador</span>
                                    @endif
                                </td>
                                <td>{{$ticket->created_at}} @if($ticket->status == 0) <br> <small class="text-danger">{{$ticket->updated_at}} </small> @endif </td>
                                <td>{{$ticket->code}}</td>
                                <td> <span class="fw-bold">{{$ticket->user->taquilla_name}}</span> <br> {{$ticket->user->name}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total,'2',',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios,2,',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios_pagados,2,',','.')}}</td>
                                <td>{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total_premios_pendientes,2,',','.')}}</td>
                                <td>
                                    @if($ticket->status != 0)
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" x-bind:href="'/print/{{$ticket->code}}?timezone='+timezone">Ver Ticket</a></li>
                                            <li><a class="dropdown-item" x-bind:href="'/tickets-repeat?code={{$ticket->code}}'">Repetir Ticket</a></li>
                                            <li><button class="dropdown-item" @click="handlePrintDirect('{{$ticket->code}}')">Direct Print</button></li>
                                            <li><button class="dropdown-item" @click="handleDelete('{{$ticket->code}}')">Eliminar</button></li>
                                            @if($ticket->has_winner == 1 && $ticket->total_premios_pendientes > 0)
                                            <li><a class="dropdown-item" href="/tickets/pay/{{$ticket->code}}">Pagar</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endif
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
            handlePrintDirect: async function(code) {

                let body = await fetch('/print-direct/' + code, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    },
                })
                res = await body.json()

                if (res.valid) {
                    if (localStorage.getItem('printer') && localStorage.getItem('printer_url')) {

                        const ticket = this.checkTypesDetalle(res.ticket);
                        // console.log(res.ticket_detalles)
                        const k = Object.keys(res.ticket_detalles)
                        // console.log(k)

                        const td = []

                        for (let i = 0; i < k.length; i++) {
                            const grupo = res.ticket_detalles[k[i]];
                            td[i] = []
                            const grupo_keys = Object.keys(grupo)
                            for (let g = 0; g < grupo_keys.length; g++) {
                                td[i][g] = grupo[grupo_keys[g]]
                                const horario = grupo[grupo_keys[g]];
                                const horario_keys = Object.keys(horario)

                                for (let h = 0; h < horario_keys.length; h++) {
                                    const animalito = horario[horario_keys[h]];
                                    td[i][g][h] = this.checkTypesAnimalito(animalito);
                                    // debugger
                                }
                            }
                        }

                        const st = await this.printDirect(localStorage.getItem('printer'), localStorage.getItem('printer_url'), ticket, td, localStorage.getItem('paper_width'))

                        this.toast('Imprimiendo...', 5000)

                    } else {
                        window.open(
                            `/print/${res.code}?timezone=${timezone}`, "_blank");
                        location.reload();
                    }

                }
            },
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
            printDirect: async function(printer, url, detalles, ticket, paper_width) {
                let res;
                axios(`${url}/print`, {
                    method: 'POST',
                    mode: 'no-cors',
                    data: {
                        printer,
                        detalles,
                        ticket,
                        paper_width
                    }
                }).then(({
                    data
                }) => {
                    this.toast('✌', 3000)
                    res = data;
                    // console.log(data);
                }).catch((e) => {
                    this.toast('Verifica el la url del pluggin', 3000)
                    this.toast('Asegurate que tengas instalado el pluggin de impresion en tu computadora local', 3000)
                    res = false;
                    // console.log(e);
                });
                return res;

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
            checkTypesDetalle: function(detalle) {
                // debugger
                const fecha = converter2(detalle.created_at);
                _detalle = {};
                _detalle.id = parseInt(detalle.id)
                _detalle.code = (detalle.code).toString()
                _detalle.caja_id = parseInt(detalle.caja_id)
                _detalle.user_id = parseInt(detalle.user_id)
                _detalle.admin_id = parseInt(detalle.admin_id)
                _detalle.total = parseFloat(detalle.total)
                _detalle.has_winner = parseInt(detalle.has_winner)
                _detalle.status = parseInt(detalle.status)
                _detalle.created_at = (fecha.fecha_inicial).toString()
                _detalle.updated_at = (detalle.updated_at).toString()
                _detalle.user = this.checkTypesUser(detalle.user)
                _detalle.moneda = detalle.moneda
                _detalle.moneda_id = parseInt(detalle.moneda_id)
                _detalle.caja = this.checkTypesCaja(detalle.caja)
                return _detalle
            },
            checkTypesUser: function(user) {
                _user = {};
                _user.id = parseInt(user.id);
                _user.taquilla_name = user.taquilla_name;
                _user.name = user.name;
                _user.email = user.email;
                _user.email_verified_at = user.email_verified_at;
                _user.parent_id = parseInt(user.parent_id);
                _user.monedas = user.monedas;
                _user.created_at = user.created_at;
                _user.updated_at = user.updated_at;
                _user.role_id = parseInt(user.role_id);
                _user.status = parseInt(user.status);
                _user.comision = parseInt(user.comision);
                return _user;
            },
            checkTypesCaja: function(caja) {
                _caja = {};
                _caja.id = parseInt(caja.id);
                _caja.user_id = parseInt(caja.user_id);
                _caja.close_user_id = parseInt(caja.close_user_id);
                _caja.fecha_apertura = caja.fecha_apertura;
                _caja.fecha_cierre = caja.fecha_cierre;
                _caja.balance_inicial = caja.balance_inicial;
                _caja.balance_final = caja.balance_final;
                _caja.entrada = caja.entrada;
                _caja.status = caja.status;
                _caja.referencia = caja.referencia;
                _caja.created_at = caja.created_at;
                _caja.updated_at = caja.updated_at;
                _caja.admin_id = parseInt(caja.admin_id);
                return _caja;
            },
            checkTypesAnimalito: function(animalito) {
                _animalito = {};
                _animalito.id = parseInt(animalito.id);
                _animalito.register_id = parseInt(animalito.register_id);
                _animalito.animal_id = parseInt(animalito.animal_id);
                _animalito.schedule = this.checkTypeSchedule(animalito.schedule);
                _animalito.schedule_id = parseInt(animalito.schedule_id);
                _animalito.admin_id = parseInt(animalito.admin_id);
                _animalito.winner = parseInt(animalito.winner);
                _animalito.monto = parseFloat(animalito.monto);
                _animalito.moneda_id = parseInt(animalito.moneda_id);
                _animalito.created_at = animalito.created_at;
                _animalito.updated_at = animalito.updated_at;
                _animalito.user_id = parseInt(animalito.user_id);
                _animalito.caja_id = parseInt(animalito.caja_id);
                _animalito.status = parseInt(animalito.status);
                _animalito.sorteo_type_id = parseInt(animalito.sorteo_type_id);
                _animalito.type = animalito.type;
                _animalito.animal = this.checkTypeAnimal(animalito.animal);

                return _animalito;
            },
            checkTypeSchedule: function(schedule) {
                _schedule = {};
                _schedule.id = parseInt(schedule.id);
                _schedule.schedule = schedule.schedule;
                _schedule.interval_start_utc = schedule.interval_start_utc;
                _schedule.interval_end_utc = schedule.interval_end_utc;
                _schedule.status = parseInt(schedule.status);
                _schedule.created_at = schedule.created_at;
                _schedule.updated_at = schedule.updated_at;
                _schedule.sorteo_type_id = parseInt(schedule.sorteo_type_id);
                return _schedule;
            },
            checkTypeAnimal: function(animal) {
                _animal = {};
                _animal.id = parseInt(animal.id)
                _animal.number = (animal.number).toString()
                _animal.nombre = (animal.nombre).toString()
                _animal.limit_cant = animal.limit_cant
                _animal.limit_price_usd = animal.limit_price_usd
                _animal.status = animal.status
                _animal.created_at = animal.created_at
                _animal.updated_at = animal.updated_at
                _animal.sorteo_type_id = animal.sorteo_type_id
                return _animal
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

    function converter2(q, k) {
        date = new Date(q);
        w = date.getTimezoneOffset()
        yourDate = new Date(date.getTime())
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