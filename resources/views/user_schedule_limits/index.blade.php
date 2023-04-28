@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Horarios</div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Loteria</td>
                            <td>Horario Nombre</td>
                            <td></td>
                        </tr>
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>
                                @if($schedule->status == 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Cerrado</span>
                                @endif
                            </td>
                            <td>{{!$schedule->type ? 'null': $schedule->type->name}}</td>
                            <td>{{$schedule->schedule}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="chart/detail?loteria_id={{$schedule->sorteo_type_id}}&created_at={{$fecha}}&schedule={{$schedule->schedule}}" class="btn btn-info">📈</a>
                                    <a href="/{{$resource}}/{{$schedule->id}}/limits" class="btn btn-primary">Limites</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection