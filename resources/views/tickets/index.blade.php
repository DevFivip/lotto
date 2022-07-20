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
                <div class="card-body">
                    <a href="/tickets/create" class="btn btn-primary">Nuevo Ticket</a>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table" x-data="mounted()">
                            <tr>
                                <td></td>
                                <td>Fecha y Hora</td>
                                <td>Codigo</td>
                                <td>Vendedor</td>
                                <td>Total</td>
                                <td></td>
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

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" x-bind:href="'/print/{{$ticket->code}}?timezone='+timezone">Ver Ticket</a></li>
                                            <li><a class="dropdown-item" href="#">Eliminar</a></li>
                                            @if($ticket->has_winner == 1)
                                            <li><a class="dropdown-item" href="#">Pagar</a></li>
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
        return {
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
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