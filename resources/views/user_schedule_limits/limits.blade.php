@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>


        <div class="col-md-10">
            <form action="/schedules-admin/save" method="POST">
                @csrf
                @method('POST')

                <input type="hidden" name="schedule_id" value="{{$schedule->id}}">

                <h2 class="mt-2"> <a href="/schedules-admin"> Limites de las Jugadas</a> - <strong>Horario {{$schedule->schedule}}</strong></h2>

                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif

                @if (\Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
                @endif


                <div class="alert alert-warning">
                    <i class="fa-solid fa-circle-exclamation"></i> Para bloquear o cerrar un animalito coloque 0 en su Monto Total
                </div>
                <div class="card mt-2">
                    <div class="card-header text-end"> <button type="submit" class="btn btn-primary">Guardar</button> </div>
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
                                <td>Monto Limite ($ USD)</td>
                            </tr>
                            @foreach($animals as $animal)
                            <tr>
                                <td>{{$animal->number}}</td>
                                <td>{{$animal->nombre}}</td>
                                <td><input type="number" step=".01" value="{{$animal->limit}}" class="form-control" name="animal[{{$animal->id}}]" /></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="text-end mt-2"> <button type="submit" class=" btn btn-primary">Guardar</button> </div>
            </form>
        </div>
    </div>
</div>

@endsection