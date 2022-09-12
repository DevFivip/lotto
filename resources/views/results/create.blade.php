@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registrar resultado</div>

                <div class="card-body">
                    <form method="POST" action="/resultados">
                        @csrf
                        <div class="row mb-3">
                            <label for="animal_id" class="col-md-4 col-form-label text-md-end">Animalito Ganador</label>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="animal_id" class="col-md-4 col-form-label text-md-end"></label>
                                    <div class="col-md-6">
                                        <select name="animal_id" class="form-select" aria-label="Default select example">
                                            @foreach($animalitos as $animal)
                                            <option value="{{$animal->number}}">{{$animal->number}} {{$animal->nombre}} {{$animal->type->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('animal_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Horario de Juego</label>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end"></label>
                                    <div class="col-md-6">
                                        <select name="schedule_id" class="form-select" aria-label="Default select example">
                                            @foreach($schedules as $schedule)
                                            <option value="{{$schedule->id}}"> {{$schedule->schedule}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Sorteo Tipo</label>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end"></label>
                                    <div class="col-md-6">
                                        <select name="sorteo_type_id" class="form-select" aria-label="Default select example">
                                            @foreach($sorteo_types as $sorteo_type)
                                            <option value="{{$sorteo_type->id}}"> {{$sorteo_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
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