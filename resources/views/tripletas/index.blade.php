@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Tripletas</div>
                <div class="card-body" x-data="mounted()">
                    <a href="/tripletas/create" class="btn btn-primary">Nuevo Ticket</a>
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
                                <form class="row g-3" action="/tripletas">
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
                                        <a href="/tripletas" class="btn btn-warning fw-bold">Reiniciar</a>
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
                            @foreach($tripletas as $tripleta)
                            <tr x-data="converter('{{$tripleta->created_at}}')">
                                <td>
                                    @if($tripleta->status == 1)
                                    <span class="badge bg-warning text-dark">Correcto</span>
                                    @elseif($tripleta->status == 0)
                                    <span class="badge bg-danger">Eliminado</span>
                                    @else($tripleta->status == 2)
                                    <span class="badge bg-success">Pagado</span>
                                    @endif
                                    @if($tripleta->has_winner == 1)
                                    <span class="badge bg-primary">Ganador</span>
                                    @endif
                                </td>
                                <td>{{$tripleta->created_at}} @if($tripleta->status == 0) <br> <small class="text-danger">{{$tripleta->updated_at}} </small> @endif </td>
                                <td>{{$tripleta->code}}</td>
                                <td> <span class="fw-bold">{{$tripleta->user->taquilla_name}}</span> <br> {{$tripleta->user->name}}</td>
                                <td>{{$tripleta->moneda->currency}} {{$tripleta->moneda->simbolo}} {{number_format($tripleta->total,'2',',','.')}}</td>
                                <td>{{$tripleta->moneda->currency}} {{$tripleta->moneda->simbolo}} {{number_format($tripleta->total_premios,2,',','.')}}</td>
                                <td>{{$tripleta->moneda->currency}} {{$tripleta->moneda->simbolo}} {{number_format($tripleta->total_premios_pagados,2,',','.')}}</td>
                                <td>{{$tripleta->moneda->currency}} {{$tripleta->moneda->simbolo}} {{number_format($tripleta->total_premios_pendientes,2,',','.')}}</td>
                                <td>
                                    @if($tripleta->status != 0)
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" x-bind:href="'/tripletas/print/{{$tripleta->code}}?timezone='+timezone">Ver Ticket</a></li>
                                            <li><button class="dropdown-item" @click="handleDelete('{{$tripleta->code}}')">Eliminar</button></li>
                                        </ul>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex">
                        {!! $tripletas->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mounted() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        const user = @json($user);
        return {
            user: user,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            openFilter: false,
            handleDeleteVerification: async function(code) {
                const codigo_eliminacion = prompt('Ingrese codigo de verificación');
                const res = await fetch('/tripletas/delete/' + code + '/' + codigo_eliminacion, {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": window.CSRF_TOKEN
                    },
                })
                body = await res.json();
                if (body.valid) {
                    location.reload()
                } else {
                    this.toast(body.message, 1000);
                }
            },
            handleDelete: async function(code) {
                if (confirm("¿Seguro deseas eliminar este tripletas?") == true) {
                    const res = await fetch('/tripletas/' + code, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })

                    body = await res.json();

                    if (body.valid) {
                        location.reload()
                    } else {
                        this.toast(body.message, 1000);
                        if (this.user.role_id == 2 || this.user.role_id == 1) {
                            this.handleDeleteVerification(code);
                        }

                    }
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
</script>

@endsection