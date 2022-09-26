@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Pagar Ticket</div>
                <div class="card-body">
                    <div class="row row-cols-2">
                        <ul class="list-group list-group-flush" x-data="converter('{{$ticket->created_at}}')">
                            <li class="list-group-item fw-bold">Ticket: <span class="font-monospace">{{$ticket->code}}</span>
                            </li>
                            <li class="list-group-item fw-bold">Fecha y Hora: <span class="font-monospace" x-text="fecha_inicial"></span></li>
                            <li class="list-group-item fw-bold">Monto: <span class="font-monospace">{{$ticket->moneda->currency}} {{$ticket->moneda->simbolo}} {{number_format($ticket->total,2,',','.')}}</span></li>
                            <li class="list-group-item fw-bold">Anulado : <span class="font-monospace">{{($ticket->status == -1 ) ? 'Si' : 'No'}}</span></li>
                        </ul>
                    </div>

                    <div class="row">
                        <table class="table">
                            <tr>
                                <td class="text-center fw-bold">#</td>
                                <td class="text-center fw-bold">Sorteo Hora</td>
                                <td class="text-center fw-bold">Monto</td>
                                <td class="text-center fw-bold">Premio</td>
                                <td class="text-center fw-bold">Pago</td>
                            </tr>
                            @foreach($detalles as $item)
                            <tr x-data="listener()">
                                <td class="font-monospace text-center">{{$item->animal->number}}</td>
                                <td class="font-monospace text-center">{{$item->animal->number}} {{$item->animal->nombre}} {{$item->schedule}}</td>
                                <td class="font-monospace text-end">{{$ticket->moneda->simbolo}} {{number_format($item->monto,2,',','.') }}</td>
                                @if($item->sorteo_type_id == 4)
                                <td class="font-monospace text-end">{{$ticket->moneda->simbolo}} {{ $item->winner == 1 ? number_format($item->monto * 32,2,',','.') : 0.00 }}</td>
                                @else
                                <td class="font-monospace text-end">{{$ticket->moneda->simbolo}} {{ $item->winner == 1 ? number_format($item->monto * 30,2,',','.') : 0.00 }}</td>
                                @endif
                                <td class="text-end">
                                    @if($item->winner == 1)
                                    @if($item->status == 0)
                                    <button class="btn btn-primary" @click="handlePay('{{$item->id}}')">Pagar</button>
                                    @else
                                    <button class="btn btn-success" disabled>Pagado</button>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function listener() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            handlePay: async function(id) {
                if (confirm("Confirma que realizaras este Pago") == true) {
                    const res = await fetch('/tickets/makepay/' + id, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })
                    const body = await res.json();
                    console.log(body)
                    if (body.valid) {
                        location.reload()
                    }

                }
            }
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