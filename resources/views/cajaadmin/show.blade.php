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
                    Caja Administrativa
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif

                    <form action="/{{$resource}}/{{$id}}">
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
                    <div class="row mt-1">
                        <div class="col">
                            <div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Detalle</th>
                                            <th>Ingreso</th>
                                            <th>Egreso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cash as $flow)

                                        <tr x-data="converter('{{$flow->created_at}}')">
                                            <td>{{$flow->id}}</td>
                                            <td x-text="fecha_inicial"></td>
                                            <td>{{$flow->detalle}}</td>

                                            @if($flow->type == 1)

                                            <td>{{$flow->total}}</td>
                                            <td>0</td>

                                            @elseif($flow->type == -1)
                                            <td>0</td>
                                            <td>{{$flow->total}}</td>


                                            @endif


                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function converter(q, k) {
        date = new Date(q);
        console.log({
            date
        })
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