@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Balance de Caja
                    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
                    <a href="/add-balance-caja/{{$caja->id}}" class="btn btn-primary">Cash Flow</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        @foreach($monedas as $moneda)
                        @php
                        $_total_monto_ingreso = 0;
                        $_total_monto_egreso = 0;
                        $simbolo = $moneda[0]['moneda']['simbolo'];
                        $currency = $moneda[0]['moneda']['currency'];
                        @endphp

                        <table class="table table-hover">
                            <thead>
                                <td>ITEM</td>
                                <td>CONCEPTO</td>
                                <td class="text-end">INGRESOS</td>
                                <td class="text-end">EGRESOS</td>
                                <td class="text-end">BALANCE</td>
                            </thead>
                            <tbody>
                                @foreach($moneda as $item)

                                <tr>
                                    @if(isset($item['code']))

                                    @php
                                    $_total_monto_ingreso += $item['total'];
                                    $_total_monto_egreso += $item['_total_pagado'];
                                    @endphp

                                    <td class="text-start" style="width:40px;">{{$item['id']}}</td>
                                    <td class="text-start" style="width:200px;">{{(isset($item['detalle'])) ? $item['detalle'] : 'Venta '.$item['code'] }}</td>
                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format($item['total'],'2',',','.')}} {{$item['moneda']['currency']}}</td>
                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format($item['_total_pagado'],'2',',','.')}} {{$item['moneda']['currency']}}</td>

                                    @else
                                    <td class="text-start" style="width:40px;">{{$item['id']}}</td>
                                    <td class="text-start" style="width:200px;">{{(isset($item['detalle'])) ? $item['detalle'] : 'Venta '.$item['code'] }}</td>
                                    @if($item['type'] == 1)

                                    @php
                                    $_total_monto_ingreso += $item['total'];
                                    @endphp

                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format($item['total'],'2',',','.')}} {{$item['moneda']['currency']}}</td>
                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format(0,'2',',','.')}} {{$item['moneda']['currency']}}</td>
                                    @else
                                    @php
                                    $_total_monto_egreso += $item['total'];
                                    @endphp
                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format(0,'2',',','.')}} {{$item['moneda']['currency']}}</td>
                                    <td class="text-end">{{$item['moneda']['simbolo']}} {{number_format($item['total'],'2',',','.')}} {{$item['moneda']['currency']}}</td>
                                    @endif


                                    @endif


                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="fw-bold">TOTAL</td>
                                    <td></td>
                                    <td class="fw-bold text-end">{{$simbolo}} {{number_format($_total_monto_ingreso,2,',','.')}}</td>
                                    <td class="fw-bold text-end">{{$simbolo}} {{number_format($_total_monto_egreso,2,',','.')}}</td>
                                    <td class="fw-bold text-end">{{$simbolo}} {{number_format($_total_monto_ingreso - $_total_monto_egreso,2,',','.')}} {{$currency}}</td>
                                </tr>
                            </tfoot>
                        </table>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
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