@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cash Flow</div>
                <div class="card-body">
                    <form method="POST" action="/cash-flow/{{$id}}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Tipo de Flow</label>

                            <div class="col-md-6">

                                <select name="type" id="type" class="form-select">
                                    <option value="1">Ingreso</option>
                                    <option value="-1">Egreso</option>
                                </select>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Moneda</label>

                            <div class="col-md-6">

                                <select name="moneda_id" id="moneda_id" class="form-select">
                                    @foreach($monedas as $moneda)
                                    <option value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @endforeach
                                </select>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Total</label>

                            <div class="col-md-6">
                                <input id="total" type="number" step=".01" class="form-control @error('total') is-invalid @enderror" name="total" value="" required autocomplete="total" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="_fecha_apertura" class="col-md-4 col-form-label text-md-end">Detalle</label>
                            <div class="col-md-6">
                                <textarea name="detalle" class="form-control"></textarea>
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Agregar Cash') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection