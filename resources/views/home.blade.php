@extends('layouts.app')

@section('content')
<div class="container">
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

                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td class="fw-bold">Moneda</td>
                                                <td class="fw-bold">Ventas </td>
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold">Ventas (USDT)</td>@endif
                                                <td class="fw-bold">Premios</td>
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold">Premios (USDT)</td>@endif
                                                <td class="fw-bold">Comisión</td>
                                                <td class="fw-bold">Balance</td>
                                                @if(auth()->user()->role_id == 1)<td class="fw-bold">Balance (USDT)</td>@endif
                                            </tr>
                                            @foreach($totalMonedas as $total)
                                            @if(isset($total['total']))
                                            <tr>
                                                <td>{{$total['nombre']}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['total'],2,',','.')}}</td>
                                                @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($total['total_exchange_usd'],2,',','.')}}</td>@endif
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['total_rewards'],2,',','.')}}</td>
                                                @if(auth()->user()->role_id == 1) <td class="text-end">$ {{number_format($total['total_rewards_exchange_usd'],2,',','.')}}</td>@endif
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['comision'],2,',','.')}}</td>
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['balance'],2,',','.')}}</td>
                                                @if(auth()->user()->role_id == 1)<td class="text-end">$ {{number_format($total['balance_exchange_usd'],2,',','.')}}</td>@endif
                                            </tr>
                                            @endif
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
@endsection