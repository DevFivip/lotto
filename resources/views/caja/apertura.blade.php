@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Apertura de Caja</div>

                <div class="card-body">
                    <form method="POST" action="/{{ $resource }}">
                        @csrf

                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="status" value="1">

                        <input readonly id="fecha_apertura" type="hidden" class="hidden form-control @error('fecha_apertura') is-invalid @enderror" value="" name="fecha_apertura" required autocomplete="fecha_apertura" />

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Usuario Encargado</label>
                            <div class="col-md-6">
                                <input id="name" readonly type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nfecha_apertura" class="col-md-4 col-form-label text-md-end">Fecha de Apertura</label>
                            <div class="col-md-6">
                                <input id="Nfecha_apertura" type="datetime-local" class="form-control @error('Nfecha_apertura') is-invalid @enderror" value="" name="Nfecha_apertura" required autocomplete="Nfecha_apertura" />
                                @error('Nfecha_apertura')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="referencia" class="col-md-4 col-form-label text-md-end">Numero de Referencia</label>
                            <div class="col-md-6">
                                <input id="referencia" type="number" class="form-control @error('referencia') is-invalid @enderror" value="" name="referencia" autofocus />
                                @error('referencia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @error('monedas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Aperturar Caja') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    (() => {

        const fill = (number, len) => "0".repeat(len - number.toString().length) + number.toString();
        el = document.getElementById('Nfecha_apertura');
        fecha = new Date('{{$fecha_apertura}}');
        date = fecha.toLocaleString()
        fechas = date.split(',');
        f = fechas[0].split('/');
        f2 = fechas[1];
        mes = fill(f[1], 2);
        b = f[2] + '-' + mes + '-' + f[0] + 'T' + f2.slice(1);
        el.value = b;


        el2 = document.getElementById('fecha_apertura');
        fecha = new Date('{{$fecha_apertura}}');
        arr = fecha.toISOString().split('T')
        fec_def = arr[0] + 'T' + arr[1];
        fec_def = fec_def.slice(0, -1);
        console.log(arr, fec_def);
        el2.value = fec_def

    })()
</script>

@endsection