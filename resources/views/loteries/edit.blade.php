@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>


        <div class="col-md-10">
            <form action="/sorteos/{{$sorteo->id}}" method="POST">
                @csrf
                @method('PUT')

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



                <div class="card mt-2">
                    <div class="card-header text-start"> Editar Sorteo</div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre de la Loteria') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$sorteo->name}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="premio_multiplication" class="col-md-4 col-form-label text-md-end">{{ __('Multiplicación Rewards') }}</label>

                            <div class="col-md-6">
                                <input id="premio_multiplication" type="text" class="form-control" name="premio_multiplication" value="{{$sorteo->premio_multiplication}}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="limit_max" class="col-md-4 col-form-label text-md-end">{{ __('Limite Maximo') }}</label>

                            <div class="col-md-6">
                                <input id="limit_max" type="text" class="form-control" name="limit_max" value="{{$sorteo->limit_max}}">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="limit_reduce" class="col-md-4 col-form-label text-md-end">{{ __('Limite Reduce') }}</label>

                            <div class="col-md-6">
                                <input id="limit_reduce" type="text" class="form-control" name="limit_reduce" value="{{$sorteo->limit_reduce}}">
                            </div>
                        </div>

                        <div class="row mb-3" x-data="listener()">
                            <label for="limit_reduce" class="col-md-4 col-form-label text-md-end">{{ __('Auto ajustar limites por horarios') }}</label>
                            <div class="col-md-6">
                                <button class="btn btn-primary" @click="handleSetSchedules" id="{{$sorteo->id}}">⚠ Ajustar </button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-end mt-2"> <button type="submit" class=" btn btn-primary">Guardar</button> </div>
            </form>
        </div>
    </div>
</div>

<script>
    function listener(e) {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            handleSetSchedules: async function(e) {
                e.preventDefault();
                id = e.target.id
                if (confirm("¿Seguro deseas ejecutar esta acción?") == true) {
                    const res = await fetch('/sorteos/' + id + "/crear-limites", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })
                    // location.reload()
                }
            }
        }
    }
</script>

@endsection