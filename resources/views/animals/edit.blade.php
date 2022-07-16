@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Animal Create</div>

                <div class="card-body">
                    <form method="POST" action="/{{ $resource }}/{{$animal->id}}">
                        @csrf
                        @method('PUT')

                        <input id="status" type="hidden" class="form-control @error('status') is-invalid @enderror" name="status" value="{{$animal->status}}" required autocomplete="status">

                        <div class="row mb-3">
                            <label for="id" class="col-md-4 col-form-label text-md-end">Numero</label>
                            <div class="col-md-6">
                                <input id="number" readonly type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ $animal->number }}" required autocomplete="number">
                                @error('number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">Nombre</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{$animal->nombre}}" name="nombre" required autocomplete="nombre" />
                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="limit_cant" class="col-md-4 col-form-label text-md-end">Cantidad Limite</label>
                            <div class="col-md-6">
                                <input id="limit_cant" type="number" class="form-control @error('limit_cant') is-invalid @enderror" value="{{$animal->limit_cant}}" name="limit_cant" autofocus />
                                <p class="text-small form-text ml-3">Cantidad Limite de Unidades que se pueden vender por Sorteo</p>
                                @error('limit_cant')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="limit_price_usd" class="col-md-4 col-form-label text-md-end">Monto Limite</label>
                            <div class="col-md-6">
                                <input id="limit_price_usd" type="number" class="form-control @error('limit_price_usd') is-invalid @enderror" value="{{$animal->limit_price_usd}}" name="limit_price_usd" autofocus />
                                <p class="text-small form-text ml-3">Cantidad Limite de Monto Total por Sorteo monto expresado en $ </p>
                                @error('limit_price_usd')
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

@endsection