@extends('layouts.app')

@section('content')
<div class="container" x-data="mounted()">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard V2') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Hola, {{auth()->user()->name}}

                    <div class="d-grid gap-1 mt-1">
                        <a href="/tickets/create" class="btn btn-primary">Nuevo Ticket</a>
                    </div>

                    <form action="/home2" class="mt-2">
                        <div class="row">
                            <div class="col">
                                <label for="">Fecha Inicio</label>
                                <input name="fecha_inicio" type="date" class="form-control" placeholder="Fecha Inicio" aria-label="Fecha Inicio">
                            </div>
                            <div class="col">
                                <label for="">Fecha Fin</label>
                                <input name="fecha_fin" type="date" class="form-control" placeholder="Fecha Fin" aria-label="Fecha Fin">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="d-grid gap-1">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row mt-1">
                    <div class="col p-4">
                        <table class="table">
                            <tr>
                                <td>Usuarios</td>
                            </tr>
                            @foreach($gg as $admin => $monedas)
                            <tr>
                                <td>{{$admin}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="table">
                                        @foreach($monedas as $currency => $totales)
                                        @php
                                        $tt = $totales->toArray();
                                        $monto_totales = $tt[count($totales)-1];
                                        @endphp
                                        <tr>
                                            <td>{{$currency}}</td>
                                            @foreach($monto_totales as $value => $key)
                                            <td>{{$key}}</td>
                                            @endforeach
                                            <td></td>

                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endforeach


                        </table>
                    </div>
                </div>


                <div class="row mt-1">
                    <div class="col p-4">
                        <div class="card mt-3">
                            <div class="card-header">
                                Balance
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table" style="font-size:12px;">
                                    <tr>
                                        <td class="fw-bold text-center">Admin</td>
                                        <td class="fw-bold text-center">Taquilla</td>
                                        <td class="fw-bold text-center">Loteria</td>
                                        <td class="fw-bold text-center">Moneda</td>
                                        <td class="fw-bold text-end">Ventas</td>
                                        <td class="fw-bold text-end">Premios</td>
                                        <td class="fw-bold text-end">Comisión</td>
                                        <td class="fw-bold text-end">Balance</td>
                                        <td class="fw-bold text-end">Cant. Ven.</td>

                                    </tr>

                                    @foreach($results as $balance)
                                    @php
                                    $balance_total = ($balance->monto_total - $balance->premio_total) - $balance->comision_total;
                                    $balance_total_usd =($balance->usd_monto_total - $balance->usd_premio_total) - $balance->usd_comision_total;
                                    @endphp
                                    <tr>
                                        <td class="text-start">{{$balance->admin_name}}</td>
                                        <td class="text-start">{{$balance->name}}</td>
                                        <td class="text-start">{{$balance->loteria_name}}</td>
                                        <td class="text-center">{{$balance->currency}}</td>
                                        <td class="text-end">{{$balance->simbolo}} {{number_format($balance->monto_total,2,',','.')}}</td>
                                        <td class="text-end">{{$balance->simbolo}} {{number_format($balance->premio_total,2,',','.')}}</td>
                                        <td class="text-end">{{$balance->simbolo}} {{number_format($balance->comision_total,2,',','.')}}</td>
                                        <td class="text-end"><b class="@if($balance_total < 0) text-danger @endif"> {{$balance->simbolo}} {{number_format($balance_total,2,',','.')}} </b></td>
                                        <td class="text-end">{{$balance->animalitos_vendidos}}</td>

                                    </tr>
                                    @endforeach


                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<script>
    function mounted() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        const params = (new URL(location)).searchParams;
        console.log({
            params
        })
        return {
            showPlays: false,
            setShowPlays: function() {
                this.showPlays = !this.showPlays
            }
        }
    }
</script>




@endsection