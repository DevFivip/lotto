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
                                                <td class="text-end">{{$total['simbolo']}} {{number_format($total['comision'],2,',','.')}}</td>
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


                            @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1 )
                            @foreach($usuarios as $index => $usuario)
                            <div x-show="handleResult" x-transition x-init="handleGetStarts('{{$usuario["id"]}}','{{$index}}')" style="display:none;">
                                <div class="card mt-2" style="display:none;" x-show="!!usuarios['{{$index}}']['total'].show">
                                    <div class="card-header">
                                        Totales de <span class="fw-bold">{{$usuario['name']}}</span> Comisión <span class="fw-bold">{{$usuario['comision']}}%<span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td class="fw-bold text-center">Moneda</td>
                                                    <td class="fw-bold text-end">Ventas </td>
                                                    <td class="fw-bold text-end">Premios</td>
                                                    <td class="fw-bold text-end">Comisión</td>
                                                    <td class="fw-bold text-end">Balance</td>
                                                    <td class="fw-bold text-end">Pagados</td>
                                                    @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Ventas (USDT)</td>@endif
                                                    @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Premios (USDT)</td>@endif
                                                    @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Balance (USDT)</td>@endif
                                                    @if(auth()->user()->role_id == 1)<td class="fw-bold text-end">Pagados (USDT)</td>@endif
                                                </tr>

                                                <template x-for="item in usuarios['{{$index}}']['total']">
                                                    <template x-if="!!item.total">
                                                        <tr>
                                                            <td class="text-center" x-text="item.nombre"></td>
                                                            <td class="text-end"><span x-text="item.simbolo"></span>&nbsp;<span x-text="formatMoney(item.total,'.',',')"></span></td>
                                                            <td class="text-end"><span x-text="item.simbolo"></span>&nbsp;<span x-text="formatMoney(item.total_rewards,'.',',')"></span></td>
                                                            <td class="text-end"><span x-text="item.simbolo"></span>&nbsp;<span x-text="formatMoney(item.comision,'.',',')"></span></td>
                                                            <td class="text-end"><span x-text="item.simbolo"></span>&nbsp;<span x-text="formatMoney(item.balance,'.',',')"></span></td>
                                                            <td class="text-end"><span x-text="item.simbolo"></span>&nbsp;<span x-text="formatMoney(item.total_pay,'.',',')"></span></td>
                                                            @if(auth()->user()->role_id == 1)<td class="text-end"><span x-text="'$'"></span>&nbsp;<span x-text="formatMoney(item.total_exchange_usd,'.',',')"></span></td>@endif
                                                            @if(auth()->user()->role_id == 1)<td class="text-end"><span x-text="'$'"></span>&nbsp;<span x-text="formatMoney(item.total_rewards_exchange_usd,'.',',')"></span></td>@endif
                                                            @if(auth()->user()->role_id == 1)<td class="text-end"><span x-text="'$'"></span>&nbsp;<span x-text="formatMoney(item.balance_exchange_usd,'.',',')"></span></td>@endif
                                                            @if(auth()->user()->role_id == 1)<td class="text-end"><span x-text="'$'"></span>&nbsp;<span x-text="formatMoney(item.total_pay_exchange_usd,'.',',')"></span></td>@endif
                                                        </tr>
                                                    </template>
                                                </template>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
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
        let usu = @json($usuarios);
        return {
            showPlays: false,
            setShowPlays: function() {
                this.showPlays = !this.showPlays
            },
            get_query: function() {
                var url = location.search;
                var qs = url.substring(url.indexOf('?') + 1).split('&');
                for (var i = 0, result = {}; i < qs.length; i++) {
                    qs[i] = qs[i].split('=');
                    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
                }
                return result;
            },
            handleResult: false,
            usuarios: usu,
            handleGetStarts: async function(userId, index) {
                return false
                // console.log(this.get_query())
                const res = await fetch('/reports/usuario?user_id=' + userId + '&' + new URLSearchParams(this.get_query()), {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": window.CSRF_TOKEN
                    },
                })
                const body = await res.json();
                const total = body.reduce((acumulator, object) => {
                    if (object.total) {
                        return acumulator + object.total;
                    } else {
                        return acumulator;
                    }
                }, 0);

                if (total >= 1) {
                    body.show = true;
                } else if (total <= 0) {
                    body.show = false;
                } else {
                    body.show = false;
                }

                this.usuarios[index]['total'] = body;
                this.handleResult = true;
                return body;
            },
            formatMoney(number, decPlaces, decSep, thouSep) {
                decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                    decSep = typeof decSep === "undefined" ? "." : decSep;
                thouSep = typeof thouSep === "undefined" ? "," : thouSep;
                var sign = number < 0 ? "-" : "";
                var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
                var j = (j = i.length) > 3 ? j % 3 : 0;

                return sign +
                    (j ? i.substr(0, j) + thouSep : "") +
                    i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                    (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
            }
        }
    }
</script>
@endsection