@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <a class="btn btn-primary" href="/lottoloko/animalitos">Animalitos</a>
            <a class="btn btn-primary" href="/lottoloko/horarios">Horarios</a>
            <form action="/lottoloko/save" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="schedule" value="{{$horario->schedule}}" />
                <h2 class="mt-2">Preview de las Jugadas - <strong>Horario {{$horario->schedule}}</strong></h2>
                <div class="card mt-2">
                    <div class="card-header text-end"> <button type="submit" class="btn btn-primary">Guardar</button> </div>
                    <div class="card-body">

                        <div class="row gap-1">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Total Jugadas</p>
                                        <h3 class="text-left">{{ number_format($totales['total_jugadas'],2,'.',',')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Ventas USDT</p>
                                        <h3 class="text-left">{{number_format($totales['total_venta_usd'],2,'.',',')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Comisiones USDT %12</p>
                                        <h3 class="text-left">{{number_format($totales['total_comision_usd'],2,'.',',')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Caja USDT 8%</p>
                                        <h3 class="text-left">{{number_format($totales['total_caja_usd'],2,'.',',')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Limite 80%</p>
                                        <h3 class="text-left">{{number_format($totales['balance_80'],2,'.',',')}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            @if($next)
                            <div class="col">
                                <div class="alert alert-primary" role="alert">
                                    Proximo Resultado: <strong>{{$next->animal->nombre}} {{$next->animal->number}}</strong>
                                </div>
                            </div>
                            @endif
                        </div>

                        <br>
                        <h3>Default 80%</h3>
                        @if($default)
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Animalito</td>
                                    <td>Numero</td>
                                    <td>Total Jugadas</td>
                                    <td>Total Venta USD</td>
                                    <td>Total Premios USD</td>
                                    <td>Seleccionar</td>
                                </tr>
                                <tr>
                                    <td>{{$default['animal']}}</td>
                                    <td>{{$default['animal_numero']}}</td>
                                    <td>{{number_format($default['total_jugadas'],2,'.',',')}}</td>
                                    <td>{{number_format($default['total_monto_usd'],2,'.',',')}}</td>
                                    <td>{{number_format($default['total_recompensa_usd'],2,'.',',')}}</td>
                                    <td><input type="radio" name="animalito" value="{{$default['animal_id']}}" /></td>
                                </tr>
                            </table>
                        </div>
                        @else
                        <span>No hay registros</span>
                        @endif


                        <br>
                        <h3>Premiar</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Animalito</td>
                                    <td>Numero</td>
                                    <td>Total Jugadas</td>
                                    <td>Total Venta USD</td>
                                    <td>Total Premios USD</td>
                                    <td>Seleccionar</td>
                                </tr>
                                @foreach($premiar as $win)
                                <tr>
                                    <td>{{$win['animal']}}</td>
                                    <td>{{$win['animal_numero']}}</td>
                                    <td>{{number_format($win['total_jugadas'],2,'.',',')}}</td>
                                    <td>{{number_format($win['total_monto_usd'],2,'.',',')}}</td>
                                    <td>{{number_format($win['total_recompensa_usd'],2,'.',',')}}</td>
                                    <td><input type="radio" name="animalito" value="{{$win['animal_id']}}" /></td>
                                </tr>
                                @endforeach

                            </table>
                        </div>

                        <br>
                        <h3>Recoger</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Animalito</td>
                                    <td>Numero</td>
                                    <td>Total Jugadas</td>
                                    <td>Total Venta USD</td>
                                    <td>Total Premios USD</td>
                                    <td>Seleccionar</td>
                                </tr>
                                @foreach($recoger as $los)
                                <tr>
                                    <td>{{$los['animal']}}</td>
                                    <td>{{$los['animal_numero']}}</td>
                                    <td>{{number_format($los['total_jugadas'],2,'.',',')}}</td>
                                    <td>{{number_format($los['total_monto_usd'],2,'.',',')}}</td>
                                    <td>{{number_format($los['total_recompensa_usd'],2,'.',',')}}</td>
                                    <td><input type="radio" name="animalito" value="{{$los['animal_id']}}" /></td>
                                </tr>

                                @endforeach

                            </table>
                        </div>

                        <br>
                        <h3>Vista Completa</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Animalito</td>
                                    <td>Numero</td>
                                    <td>Total Jugadas</td>
                                    <td>Total Venta USD</td>
                                    <td>Total Premios USD</td>
                                    <td>Seleccionar</td>
                                </tr>

                                @foreach($hh as $animalito)
                                <tr>
                                    <td>{{$animalito['animal']}}</td>
                                    <td>{{$animalito['animal_numero']}}</td>


                                    <td>{{number_format($animalito['total_jugadas'],2,'.',',')}}</td>
                                    <td>{{number_format($animalito['total_monto_usd'],2,'.',',')}}</td>
                                    <td>{{number_format($animalito['total_recompensa_usd'],2,'.',',')}}</td>

                        
                                    <td><input type="radio" name="animalito" value="{{$animalito['animal_id']}}" /></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>
                </div>


                <div class="text-end mt-2"> <button type="submit" class=" btn btn-primary">Guardar</button> </div>

            </form>

        </div>
    </div>
</div>



<script>

</script>
@endsection