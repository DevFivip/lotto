@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Selecciona una Loteria y fecha para filtrar</div>
                <div class="card-body">

                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    
                    <form action="/chart">

                        <div class="row mb-3">
                            <label for="loteria" class="col-md-4 col-form-label text-md-end">Loteria</label>

                            <div class="col-md-6">
                                <select name="loteria_id" class="form-select" aria-label="Default select example">
                                    @foreach($loterias as $loteria)
                                    <option value="{{$loteria->id}}">{{$loteria->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="created_at" class="col-md-4 col-form-label text-md-end">Fecha</label>
                            <div class="col-md-6">
                                <input name="created_at" type="date" class="form-control" placeholder="Fecha">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="d-grid gap-1">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection