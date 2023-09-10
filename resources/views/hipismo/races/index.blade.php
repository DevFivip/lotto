@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-end"> <a href="/hipismo/races/create" class="btn btn-primary">Nueva Carrera</a></div>
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

                    <div class="table_responsive">
                        <table class="table">
                            <tr>
                                <td>Carrera Nombre</td>
                                <td>Hipodromo</td>
                                <td>Pais</td>
                                <td>Fecha</td>
                                <td></td>
                            </tr>
                            @foreach($races as $race)
                            <tr>
                                <td>
                                    {{$race->name}}
                                </td>
                                <td>
                                    <a href="/hipismo/hipodromos/{{$race->hipodromo->id}}/edit"> {{$race->hipodromo->name}}</a>
                                </td>
                                <td>
                                    {{$race->hipodromo->country}}
                                </td>
                                <td> {{$race->race_day}}</td>
                                <td>
                                    <div x-data="listener()" class="btn-group">
                                        <a href="/hipismo/races/{{$race->id}}/setting" class="btn btn-primary">Ajustar</a>
                                        <a href="/hipismo/races/{{$race->id}}/edit" class="btn btn-primary">Editar</a>
                                        @if($race->status == 1)
                                        <button @click="handleLock" id="{{$race->id}}" class="btn btn-danger">Desactivar</button>
                                        @else
                                        <button @click="handleLock" id="{{$race->id}}" class="btn btn-warning">Activar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex">
                        {!! $races->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function listener() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        return {
            handleLock: async function(e) {
                id = e.target.id
                if (confirm("¿Seguro deseas desactivar?") == true) {
                    const res = await fetch('/hipismo/races/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })
                    location.reload()
                }
            }
        }
    }
</script>

@endsection