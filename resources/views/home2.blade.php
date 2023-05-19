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

                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Lotto Activo</strong> se encuentra desactivado temporalmente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- <div class="alert alert-info alert-dismissible fade show" role="alert" >
                        <span class="glyphicon glyphicon-info-sign"></span>🚨 Según las loterías de Venezuela que han confirmado: <br>El <strong>jueves 06 de abril:</strong> <br><strong>- No</strong> realizarán sorteos: Lotto Rey, La Granjita<br> <strong>- Sí</strong> realizarán: Lotto Activo, Lotto Activo RD, Lotto Plus, Selva Paraiso <br>El <strong>viernes 07 de abril:</strong> NO hay sorteos. <br>Vuelven los sorteos el <strong>sábado 08 de abril</strong> con horario habitual.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> -->

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
                </div>
                <div class="row mt-1">
                    <div class="col p-4">
                        <div class="card mb-2">
                            <h5 class="card-header d-flex justify-content-between align-items-center">
                                Balance General

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_balancegeneral">Detalles</button>
                                <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                            </h5>
                            </h5>
                            <div class="card-body table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Moneda</td>
                                        <td>Ventas</td>
                                        <td>Comisión</td>
                                        <td>Premios</td>
                                        <td>Balance</td>
                                    </tr>

                                    @foreach($balance_general as $balance_moneda => $balance_total)
                                    @php
                                    $total = $balance_total[count($balance_total) -1];
                                    $sbalance = ($total['total_monto'] - $total['comision_total']) - $total['premio_total'];
                                    @endphp
                                    <tr>
                                        <td>{{$balance_moneda}}</td>
                                        <td>{{number_format($total['total_monto'],2,',','.')}}</td>
                                        <td>{{number_format($total['comision_total'],2,',','.')}}</td>
                                        <td>{{number_format($total['premio_total'],2,',','.')}}</td>
                                        <td>{{number_format($sbalance,2,',','.')}}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>




                    <!-- MODAL DEL BALANCE GENRAL -->




                    <div class="modal fade" id="modal_balancegeneral" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Balance General</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Loteria</td>
                                            <td>Moneda</td>
                                            <td>Venta</td>
                                            <td>Premios</td>
                                            <td>Comisión</td>
                                            <td>Balance</td>
                                        </tr>
                                        @foreach($loteria_balance as $name => $totales)
                                        @php
                                        $res = $totales->toArray();
                                        @endphp
                                        @foreach($res as $moneda => $to)
                                        @foreach($to as $identify => $row)

                                        @if($identify == count($to) -1 )
                                        @php
                                        $balance_total = ($row['total_monto'] - $row['premio_total']) - $row['comision_total'];
                                        @endphp
                                        <tr>
                                            <td>{{$name}}</td>
                                            <td>{{$moneda}}</td>
                                            <td></td>
                                            <td>{{number_format($row['total_monto'],2,',','.')}}</td>
                                            <td>{{number_format($row['premio_total'],2,',','.')}}</td>
                                            <td>{{number_format($row['comision_total'],2,',','.')}}</td>
                                            <td><b class="@if($balance_total < 0) text-danger @endif">{{number_format($balance_total,2,',','.')}}</b></td>

                                        </tr>
                                        @endif

                                        @endforeach
                                        @endforeach

                                        @endforeach
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL DEL BALANCE GENRAL -->



                </div>

                <div class="row mt-1">
                    <div class="col p-4">
                        @php
                        $indexModal = 0;
                        @endphp

                        @foreach($gg as $admin => $monedas)
                        @php
                        $indexModal +=1;
                        @endphp
                        <div class="card mb-2">
                            <h5 class="card-header d-flex justify-content-between align-items-center">
                                {{$admin}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_{{$indexModal}}">Detalles</button>
                                <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                            </h5>
                            <div class="card-body table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Moneda</td>
                                        <td>Ventas</td>
                                        <td>Comisión</td>
                                        <td>Premios</td>
                                        <td>Balance</td>
                                    </tr>

                                    @foreach($monedas as $currency => $totales)
                                    @php
                                    $tt = $totales->toArray();
                                    $monto_totales = $tt[count($totales)-1];
                                    $balance_tt = ($monto_totales['total_monto'] - $monto_totales['comision_total']) - $monto_totales['premio_total'];
                                    @endphp
                                    <tr>
                                        <td>{{$currency}}</td>
                                        @foreach($monto_totales as $value => $key)
                                        <td>{{number_format($key,2,',','.')}}</td>
                                        @endforeach
                                        <td> <b class="@if($balance_tt < 0) text-danger @endif"> {{number_format($balance_tt,2,',','.') }}</b></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="modal_{{$indexModal}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$admin}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body table-responsive">

                                        <table class="table">
                                            <tr>
                                                <td>Taquilla</td>
                                                <td>Loteria</td>
                                                <td>Moneda</td>
                                                <td>Venta</td>
                                                <td>Premios</td>
                                                <td>Comisión</td>
                                                <td>Balance</td>
                                            </tr>
                                            @foreach($monedas as $currency => $totales)
                                            @php
                                            $res = $totales->toArray();
                                            @endphp

                                            @foreach($res as $kk => $to)
                                            @if($kk != count($res)-1)
                                            @php
                                            $balance_total = ($to->monto_total - $to->premio_total) - $to->comision_total;
                                            @endphp
                                            <tr>
                                                <td>{{$to->taquilla_name}} {{$to->name}}</td>
                                                <td>{{$to->loteria_name}}</td>
                                                <td>{{$to->currency}}</td>

                                                <td>{{$to->simbolo}} {{number_format($to->monto_total,2,',','.')}}</td>
                                                <td>{{$to->simbolo}} {{number_format($to->premio_total,2,',','.')}}</td>
                                                <td>{{$to->simbolo}} {{number_format($to->comision_total,2,',','.')}}</td>
                                                <td><b class="@if($balance_total < 0) text-danger @endif">{{$to->simbolo}} {{number_format($balance_total,2,',','.')}}</b></td>

                                            </tr>
                                            @endif

                                            @endforeach

                                            @endforeach
                                        </table>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
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