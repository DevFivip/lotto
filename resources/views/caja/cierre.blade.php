@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Apertura de Caja</div>
                <div class="card-body">
                    <form x-data="converter('{{$fecha_apertura}}','{{$fecha_cierre}}')" method="POST" action="/{{ $resource }}/{{$caja->id}}">
                        @method('PUT')
                        @csrf

                        <input type="hidden" name="close_user_id" value="{{auth()->user()->id}}">
                        <input type="hidden" name="status" value="0">

                        <input readonly id="fecha_cierre" type="hidden" class="form-control @error('fecha_cierre') is-invalid @enderror" value="{{$_fecha_cierre}}" name="fecha_cierre" required autocomplete="fecha_cierre" />

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Usuario de Cierre</label>

                            <div class="col-md-6">
                                <input id="name" readonly type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="_fecha_apertura" class="col-md-4 col-form-label text-md-end">Fecha de Apertura</label>
                            <div class="col-md-6">
                                <input readonly id="_fecha_apertura" type="text" class="form-control @error('_fecha_apertura') is-invalid @enderror" x-model="fecha_inicial" name="_fecha_apertura" required autocomplete="_fecha_apertura" autofocus />
                                @error('_fecha_apertura')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="_fecha_cierre" class="col-md-4 col-form-label text-md-end">Fecha de Cierre</label>
                            <div class="col-md-6">
                                <input readonly id="_fecha_cierre" type="text" class="form-control @error('_fecha_cierre') is-invalid @enderror" x-model="fecha_cierre" name="_fecha_cierre" required autocomplete="_fecha_cierre" autofocus />
                                @error('_fecha_cierre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="referencia" class="col-md-4 col-form-label text-md-end">Numero de Referencia</label>
                            <div class="col-md-6">
                                <input readonly id="referencia" type="number" class="form-control @error('referencia') is-invalid @enderror" value="{{$caja->referencia}}" name="referencia" required autocomplete="referencia" autofocus />
                                @error('referencia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cerrar Caja') }}
                                </button>
                            </div>
                        </div>
                    </form>
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