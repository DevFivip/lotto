@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <a href="{{$resource}}/create" class="btn btn-primary">Crear Nuevo</a>

                    <br>
                    <br>
                    <br>
                    <br>
                    asdasd




                    <table class="table">

                        <tr>
                            <td>Nombre</td>
                            <td>Email</td>
                            <td>Rol ID</td>
                            <td>Action</td>
                        </tr>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->email}}</td>
                            <td>

                                {{$usuario->role_id}}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="javascript:;" class="btn btn-danger">Eliminar</a>
                                    <a href="javascript:;" class="btn btn-danger">Bloquear</a>
                                    <a href="{{$resource}}/{{$usuario->id}}/edit" class="btn btn-primary">Editar</a>
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