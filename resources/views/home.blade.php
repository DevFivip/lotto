@extends('layouts.app')

@section('content')
<div class="container" x-data="mounted()">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
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

                    <form action="/home" class="mt-2">
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

                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header" @click="setShowPlays()">
                                    Jugadas
                                </div>
                                <div class="card-body" x-show="showPlays" style="display: none;">
                                    @foreach($list_plays as $plays)
                                    <div class="table-responsive">
                                        <table class="table">
                                            @foreach($plays[0] as $play)
                                            @if($play[0] != null)
                                            <tr>
                                                <td class="text-center">
                                                    {{$plays['schedule']}}
                                                </td>
                                                <td class="text-end">
                                                    {{$play[0]}}
                                                    {{$play[1]}}
                                                </td>
                                                <td class="text-end">
                                                    {{$play[2]}}
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col">

                            <div class="card">
                                <div class="card-header">
                                    Balance General
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td class="fw-bold text-center">Moneda</td>
                                                <td class="fw-bold text-end">Ventas</td>
                                                <td class="fw-bold text-end">Premios</td>
                                                <td class="fw-bold text-end">Comisión</td>
                                                <td class="fw-bold text-end">Balance</td>
                                                <td class="fw-bold text-end">Pagados</td>
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Ventas (USDT)</td>@endif
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Premios (USDT)</td>@endif
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Balance (USDT)</td>@endif
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Pagados (USDT)</td>@endif
                                            </tr>

                                            @foreach($totalMonedas as $total)
                                            @if(isset($total['total']))

                                            <tr>
                                                <td class="text-center">{{$total['nombre']}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['total'],2,',','.')}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['total_rewards'],2,',','.')}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['_comision'],2,',','.')}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['balance'],2,',','.')}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['total_pay'],2,',','.')}}</td>
                                                @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($total['total_exchange_usd'],2,',','.')}}</td>@endif
                                                @if(auth()->user()->role_id == 1) <td class="text-end">$ {{number_format($total['total_rewards_exchange_usd'],2,',','.')}}</td>@endif
                                                @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($total['balance_exchange_usd'],2,',','.')}}</td>@endif
                                                @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($total['total_pay_exchange_usd'],2,',','.')}}</td>@endif
                                            </tr>
                                            @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @foreach($_start as $admin)
                            <div class="card mt-3">
                                <div class="card-header">
                                    {{$admin['usuario']['name']}}
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <td class="fw-bold text-center">Moneda</td>
                                            <td class="fw-bold text-end">Ventas</td>
                                            <td class="fw-bold text-end">Premios</td>
                                            <td class="fw-bold text-end">Comisión</td>
                                            <td class="fw-bold text-end">Balance</td>
                                            <td class="fw-bold text-end">Pagados</td>
                                            @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Ventas (USDT)</td>@endif
                                            @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Premios (USDT)</td>@endif
                                            @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Balance (USDT)</td>@endif
                                            @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Pagados (USDT)</td>@endif
                                        </tr>

                                        @foreach($admin as $key => $moneda)
                                        @if(isset($moneda['total']))

                                        <tr>
                                            <td class="text-center">{{$moneda['nombre']}}</td>
                                            <td class="text-end">{{$moneda['simbolo']}} {{number_format($moneda['total'],2,',','.')}}</td>
                                            <td class="text-end">{{$moneda['simbolo']}} {{number_format($moneda['total_rewards'],2,',','.')}}</td>
                                            <td class="text-end">{{$moneda['simbolo']}} {{number_format($moneda['_comision'],2,',','.')}}</td>
                                            <td class="text-end">{{$moneda['simbolo']}} {{number_format($moneda['balance'],2,',','.')}}</td>
                                            <td class="text-end">{{$moneda['simbolo']}} {{number_format($moneda['total_pay'],2,',','.')}}</td>
                                            @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($moneda['total_exchange_usd'],2,',','.')}}</td>@endif
                                            @if(auth()->user()->role_id == 1) <td class="text-end">$ {{number_format($moneda['total_rewards_exchange_usd'],2,',','.')}}</td>@endif
                                            @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($moneda['balance_exchange_usd'],2,',','.')}}</td>@endif
                                            @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($moneda['total_pay_exchange_usd'],2,',','.')}}</td>@endif
                                        </tr>
                                        @endif
                                        @endforeach

                                    </table>

                                </div>
                            </div>
                            @endforeach



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