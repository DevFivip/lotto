@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Reportes
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif

                    <form action="/reports/general">
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
                        <div class="row mt-1">
                            <div class="col">
                                <div class="d-grid gap-1">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-1">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">Total</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">Total</h4>
                                    <h4 class="text-center">Total</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">Total</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td class="text-center fw-bold">Sorteo Horario</td>
                                <td class="text-center fw-bold">Balance</td>
                            </tr>
                            @foreach($datas as $k => $data)
                            <tr>
                                <td class="text-center fw-bold">{{$data['sorteo']}}</td>
                                <td class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>ISO</td>
                                            <td class="text-end">Monto Total Jugado</td>
                                            <td class="text-end">Total Jugadas</td>
                                            <td class="text-end">Comisión</td>
                                            <td class="text-end">Premios</td>
                                        </tr>
                                        @foreach($data as $q => $amounts)
                                        @if(is_numeric($q))
                                        <tr>
                                            <td class="text-start">{{$amounts[0]}}</td>
                                            <td class="text-end">{{$amounts[1]}} {{number_format($amounts[2],2,',','.')}}</td>
                                            <td class="text-end">{{$amounts[3]}}</td>
                                            <td class="text-end">{{$amounts[1]}} {{number_format($amounts[4],2,',','.')}}</td>
                                            <td class="text-end">{{$amounts[1]}} {{number_format($amounts[5],2,',','.')}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
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



@endsection