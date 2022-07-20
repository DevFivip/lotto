@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
 </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <a href="{{$resource}}/create" class="btn btn-primary">Crear Nuevo</a>
                    <table class="table">
                        <tr>
                            <td>Taquilla</td>
                            <td>Nombre</td>
                            <td>Email</td>
                            <td>Rol ID</td>
                            <td>Action</td>
                        </tr>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->taquilla_name}}</td>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->email}}</td>
                            <td>
                                @if($usuario->role_id === 1)
                                <span class="badge rounded-pill bg-primary "><i class="fa-solid fa-crown"></i></span>
                                @endif

                                @if($usuario->role_id === 2)
                                <span class="badge rounded-pill bg-warning text-dark">Admin</span>
                                @endif

                                @if($usuario->role_id === 3)
                                <span class="badge rounded-pill bg-success">Taquilla</span>
                                @endif
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