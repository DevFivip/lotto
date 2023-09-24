@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Carrera</div>

                <div class="card-body">

                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif

                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="/hipismo/races/{{$race->id}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Hipodromo</label>

                            <div class="col-md-6">

                                <select name="hipodromo_id" id="hipodromo_id" class="form-select @error('name') is-invalid @enderror" value="{{$race->hipodromo_id}}">
                                    @foreach($hipodromos as $hipodromo)
                                    <option value="{{$hipodromo->id}}">{{$hipodromo->name}}-{{$hipodromo->country}}</option>
                                    @endforeach
                                </select>

                                @error('hipodromo_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre / Numero de la Carrera</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$race->name}}" require autocomplete="none">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="race_day" class="col-md-4 col-form-label text-md-end">Fecha de la Carrera</label>
                            <div class="col-md-6">
                                <input id="race_day" type="date" class="form-control @error('race_day') is-invalid @enderror" name="race_day" value="{{$fecha }}" autocomplete="none">
                                @error('race_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Actualizar Carrera') }}
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