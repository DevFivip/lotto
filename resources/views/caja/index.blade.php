@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cajas</div>
                <div class="card-body">
                    <a href="{{$resource}}/create" class="btn btn-primary">Aperturar Caja</a>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Usuario</td>
                                <td>Apertura</td>
                                <td>Cierre</td>
                                <td>Entrada</td>
                                <td></td>
                            </tr>
                            @foreach($cajas as $caja)
                            <tr x-data="converter('{{$caja->fecha_apertura}}','{{$caja->fecha_cierre}}')">
                            <td>
                                {{$caja->id}}
                            </td>
                                <td>
                                    @if($caja->status == 1)
                                    <span class="badge bg-warning text-dark">Abierto</span>
                                    @else
                                    <span class="badge bg-danger">Cerrado</span>
                                    @endif
                                </td>
                                <td>
                                    {{$caja->usuario->name}} <br>
                                    <span class="fw-bold">
                                        {{$caja->usuario->taquilla_name}}
                                    </span>
                                </td>

                                <td x-text="fecha_inicial"></td>
                                <td x-text="fecha_cierre"></td>

                                <td>{{$caja->entrada}}</td>

                                <td>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="/balance-caja/{{$caja->id}}">Balance</a></li>
                                            @if($caja->status == 1)
                                            <li><a class="dropdown-item" href="/{{$resource}}/{{$caja->id}}/edit">Cerrar Caja</a></li>
                                            @endif
                                            <li><a class="dropdown-item" href="/report-caja/{{$caja->id}}">Reporte</a></li>
                                        </ul>
                                    </div>


                                    <div class="btn-group">

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