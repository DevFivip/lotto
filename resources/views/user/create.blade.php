@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Usuarios</div>

                <div class="card-body">
                    <form method="POST" action="/{{ $resource }}">
                        @csrf

                        @if(auth()->user()->role_id == 2)
                        <input type="hidden" value="{{auth()->user()->id}}" name="parent_id">
                        @endif

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre Y Apellido</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="taquilla_name" class="col-md-4 col-form-label text-md-end">Nombre de Taquilla</label>
                            <div class="col-md-6">
                                <input id="taquilla_name" type="text" class="form-control @error('taquilla_name') is-invalid @enderror" name="taquilla_name" value="{{ old('taquilla_name') }}" required autocomplete="taquilla_name" autofocus>

                                @error('taquilla_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        @if(auth()->user()->role_id == 1)
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Categoria de Usuario</label>

                            <div class="col-md-6">
                                <select name="role_id" class="form-select" aria-label="Default select example">
                                    <option value="1">Super Admin</option>
                                    <option selected value="2">Administrador</option>
                                    <option value="3">Tanquilla</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->role_id == 2)
                        <div class="row mb-3">
                            <label for="___categoria" class="col-md-4 col-form-label text-md-end">{{ __('Categoria de Usuario') }}</label>

                            <div class="col-md-6">
                                <input type="hidden" name="role_id" value="3">
                                <input id="___categoria" readonly type="text" class="form-control" value="Taquilla">
                            </div>
                        </div>
                        @endif

                        <div class="row mb-3">
                            <label for="monedas" class="col-md-4 col-form-label text-md-end">Monedas Usadas</label>

                            <div class="col-md-6">
                                <select name="monedas[]" class="form-select" multiple aria-label="multiple select example">
                                    @foreach($monedas as $moneda)
                                    <option value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label for="sorteos" class="col-md-4 col-form-label text-md-end">Sorteos Disponibles</label>

                            <div class="col-md-6">
                                <select name="sorteos[]" class="form-select" multiple aria-label="multiple select example">
                                    @foreach($sorteos as $sorteo)
                                    <option value="{{$sorteo->id}}">{{$sorteo->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        @error('sorteos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="row mb-3">
                            <label for="comision" class="col-md-4 col-form-label text-md-end">Comisión de Venta</label>
                            <div class="col-md-6">
                                <input id="comision" type="number" class="form-control @error('comision') is-invalid @enderror" name="comision" value="{{ old('comision') }}" required autocomplete="comision" autofocus>
                                @error('comision')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="limit" class="col-md-4 col-form-label text-md-end">Limite de Venta por Animalito ($)</label>
                            <div class="col-md-6">
                                <input id="limit" type="number" step=".01" class="form-control @error('limit') is-invalid @enderror" name="limit" value="{{ old('limit') }}" required autocomplete="limit" autofocus>
                                <p class="form-text text-muted">Dejar en 0 para aplicar los limites del Sistema / Administrador</p>
                                <p class="form-text text-muted">Para Administradores aplicara para la sumatoria total de sus taquillas</p>
                                <p class="form-text text-muted">Para Taquillas aplicara para la sumatoria total de su propias ventas</p>
                                @error('limit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if(auth()->user()->role_id == 1)
                        <div class="row mb-3">
                            <label for="is_socio" class="col-md-4 col-form-label text-md-end">Socio</label>
                            <div class="col-md-6">
                                <select name="is_socio" class="form-select" aria-label="Es Socio">
                                    <option selected value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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