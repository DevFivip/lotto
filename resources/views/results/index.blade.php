@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Resultados</div>
                <div class="card-body">

                    <a href="/resultados/create" class="btn btn-primary">Agrager Nuevo Resultado</a>

                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Sorteo</td>
                            <td>Fecha y Hora</td>
                            <td>Numero</td>
                            <td>Animalito</td>
                        </tr>
                        @foreach($results as $result)
                        <tr x-data="converter('{{$result->created_at}}')">

                            <td>{{$result->schedule->schedule}}</td>
                            <td x-text="fecha_inicial"></td>
                            <td>{{$result->animal->number}}</td>
                            <td>{{$result->animal->nombre}}</td>

                        </tr>
                        @endforeach

                    </table>
                    <div class="d-flex">
                        {!! $results->links() !!}
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