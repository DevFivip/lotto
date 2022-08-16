@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Manejo de Caja Administrativa</div>
                <div class="card-body">
                    <form method="POST" action="/{{$resource}}/{{$cash->id}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="admin_id" value="{{$cash->admin_id}}">
                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">Tipo de Manejo</label>

                            <div class="col-md-6">

                                <select name="type" id="type" class="form-select">

                                    @if($cash->type == 1)
                                    <option selected value="1">Ingreso (+)</option>
                                    @else
                                    <option value="1">Ingreso (+)</option>
                                    @endif

                                    @if($cash->type == -1)
                                    <option selected value="-1">Egreso (+)</option>
                                    @else
                                    <option value="-1">Egreso (+)</option>
                                    @endif

                                </select>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Moneda</label>

                            <div class="col-md-6">

                                <select name="moneda_id" class="form-select" aria-label="">
                                    @foreach($monedas as $moneda)
                                    @if($cash->moneda_id == $moneda->id))
                                    <option selected value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @else
                                    <option value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>

                                @error('moneda_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="total" class="col-md-4 col-form-label text-md-end">Total</label>

                            <div class="col-md-6">
                                <input id="total" type="number" step=".01" class="form-control @error('total') is-invalid @enderror" name="total" value="{{$cash->total}}" required autocomplete="total" autofocus>
                                @error('total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Fecha</label>

                            <div x-data="converter('{{$cash->created_at}}')" class="col-md-6">
                                <input id="created_at" x-model="fecha_inicial" type="date" class="form-control @error('created_at') is-invalid @enderror" name="created_at" required autocomplete="created_at" autofocus>

                                @error('created_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="_fecha_apertura" class="col-md-4 col-form-label text-md-end">Detalle</label>
                            <div class="col-md-6">
                                <textarea name="detalle" required class="form-control">{{$cash->detalle}}</textarea>
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Cambios') }}
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
    function converter(q, k) {
        date = new Date(q);

        w = date.getTimezoneOffset()
        yourDate = new Date(date.getTime() - (w * 60 * 1000))
        f1 = yourDate.toLocaleDateString();
        f2 = yourDate.toLocaleTimeString();

        f5 = yourDate.toISOString().split('T')[0]

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
            fecha_inicial: f5,
            fecha_cierre: f3 + ' ' + f4,
        }
    }
</script>


@endsection