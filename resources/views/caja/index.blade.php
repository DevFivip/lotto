@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
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
                    <table class="table">
                        <tr>
                            <td>Usuario</td>
                            <td>Apertura</td>
                            <td>Cierre</td>
                            <td>Entrada</td>
                            <td></td>
                        </tr>
                        @foreach($cajas as $caja)
                        <tr x-data="converter('{{$caja->fecha_apertura}}','{{$caja->fecha_cierre}}')">
                            <td>
                                @if($caja->status === 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Cerrada</span>
                                @endif
                                {{$caja->usuario->name}}
                            </td>

                            <td x-text="fecha_inicial"></td>
                            <td x-text="fecha_cierre"></td>

                            <td>{{$caja->entrada}}</td>

                            <td>
                                <div class="btn-group">
                                    @if($caja->status === 1)
                                    <a href="/{{$resource}}/{{$caja->id}}/edit" class="btn btn-danger">Cerrar Caja</a>
                                    @endif
                                    <a href="javascript:;" class="btn btn-primary">Reporte</a>
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