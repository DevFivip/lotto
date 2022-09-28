@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Usuarios</div>
                <div class="card-body">
                    <form method="POST" action="/{{ $resource }}/{{$user->id}}">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

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
                                <input id="taquilla_name" type="text" class="form-control @error('taquilla_name') is-invalid @enderror" name="taquilla_name" value="{{ $user->taquilla_name }}" required autocomplete="taquilla_name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                <span class="form-text text-muted">Rellenar para cambiar la contraseña</span>

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        @if(auth()->user()->role_id == 1)
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Categoria de Usuario</label>
                            <div class="col-md-6">
                                <select name="role_id" class="form-select" aria-label="Default select example">

                                    @if($user->role_id == 1)
                                    <option selected value="1">Super Admin</option>
                                    @else
                                    <option value="1">Super Admin</option>
                                    @endif

                                    @if($user->role_id == 2)
                                    <option selected value="2">Administrador</option>
                                    @else
                                    <option value="2">Administrador</option>
                                    @endif

                                    @if($user->role_id == 3)
                                    <option selected value="3">Taquilla</option>
                                    @else
                                    <option value="3">Taquilla</option>
                                    @endif

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
                                    @if(in_array($moneda->id,$user->monedas))
                                    <option selected value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @else
                                    <option value="{{$moneda->id}}">{{$moneda->simbolo}} {{$moneda->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="comision" class="col-md-4 col-form-label text-md-end">Comisión de Ventas</label>
                            <div class="col-md-6">
                                <input id="comision" type="number" class="form-control @error('comision') is-invalid @enderror" name="comision" value="{{ $user->comision }}" required autocomplete="comision">
                                @error('comision')
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
                                    @if($user->is_socio == 0)
                                    <option selected value="0">No</option>
                                    @else
                                    <option value="0">No</option>
                                    @endif

                                    @if($user->is_socio == 1)
                                    <option selected value="1">Si</option>
                                    @else
                                    <option value="1">Si</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Socio</label>
                            <div class="col-md-6">
                                <select name="status" class="form-select" aria-label="Es Socio">
                                    @if($user->status == 0)
                                    <option selected value="0">Bloqueado</option>
                                    @else
                                    <option value="0">Bloqueado</option>
                                    @endif

                                    @if($user->status == 1)
                                    <option selected value="1">Activo</option>
                                    @else
                                    <option value="1">Activo</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endif

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