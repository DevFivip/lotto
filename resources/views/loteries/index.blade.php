@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Sorteos | Loterias</div>
                <div class="card-body">
                    <p class="text-small form-text ml-3">&nbsp;&nbsp;<i class="fa-solid fa-circle-exclamation"></i>&nbsp;Agregar ó Eliminar Sorteos directamente desde la base de datos</p>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Loteria</td>
                            <td>Reward</td>
                            <td>Limite Maximo</td>
                            <td>Limite Reduccion </td>
                            <td></td>
                        </tr>
                        @foreach($sorteos as $sorteo)
                        <tr>
                            <td>
                                @if($sorteo->status == 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Desactivado</span>
                                @endif
                            </td>

                            <td> {{$sorteo->name}}</td>
                            <td> X{{$sorteo->premio_multiplication}}</td>
                            <td>$ {{$sorteo->limit_max}}</td>
                            <td>$ {{$sorteo->limit_reduce}}</td>
                            <td>

                                <div x-data="listener()" class="btn-group">
                                    <a href="/sorteos/{{$sorteo->id}}/edit" class="btn btn-primary">Editar</a>
                                    @if($sorteo->status == 1)
                                    <button @click="handleLock" id="{{$sorteo->id}}" class="btn btn-danger">Desactivar</button>
                                    @else
                                    <button @click='handleLock' id="{{$sorteo->id}}" class="btn btn-warning">Activar</button>
                                    @endif

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