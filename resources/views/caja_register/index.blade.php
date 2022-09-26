@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Registro de Caja Taquillas</div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($taquillas as $taquilla)
                            <div class="card" style="max-width:20vh;">
                                <h5 class="card-header">{{$taquilla->taquilla_name}}-{{$taquilla->name}}</h5>
                                <div class="card-body">
                                    <span class="card-text">Bs. 9,000.00</span><br>
                                    <span class="card-text">Bs. 9,000.00</span><br>
                                    <a href="/caja-register/{{$taquilla->id}}" class="btn btn-primary">Ver Detalles</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
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