@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Usuarios</div>
                <div class="card-body">
                    <form method="POST" action="/lottoloko/setSetting">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="porcent_comision" class="col-md-4 col-form-label text-md-end">Porcentaje de comision para los Vendedores</label>

                            <div class="col-md-6">
                                <input id="porcent_comision" type="number" step="0.01" class="form-control @error('porcent_comision') is-invalid @enderror" name="porcent_comision" value="{{ $setting->porcent_comision }}" required autocomplete="porcent_comision" autofocus>

                                @error('porcent_comision')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="porcent_cash" class="col-md-4 col-form-label text-md-end">Porcentaje para las Cajas</label>

                            <div class="col-md-6">
                                <input id="porcent_cash" type="number" step="0.01" class="form-control @error('porcent_cash') is-invalid @enderror" name="porcent_cash" value="{{ $setting->porcent_cash }}" required autocomplete="porcent_cash" autofocus>

                                @error('porcent_cash')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="porcent_limit" class="col-md-4 col-form-label text-md-end">Porcentaje límite</label>

                            <div class="col-md-6">
                                <input id="porcent_limit" type="number" step="0.01" class="form-control @error('porcent_limit') is-invalid @enderror" name="porcent_limit" value="{{ $setting->porcent_limit }}" required autocomplete="porcent_limit" autofocus>

                                @error('porcent_limit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

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
@endsection