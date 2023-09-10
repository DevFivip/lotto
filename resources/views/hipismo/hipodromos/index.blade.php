@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-end"> <a href="/hipismo/hipodromos/create" class="btn btn-primary">Nuevo</a></div>
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
                                <td>Nombre</td>
                                <td>Pais</td>
                                <!-- <td>Numero</td>
                            <td>Nombre</td>
                            <td>Cantidad Limite</td>
                            <td>Monto Limite [$]</td> -->
                                <td></td>
                            </tr>
                            @foreach($hipodromos as $hipodromo)
                            <tr>
                                <td>
                                    {{$hipodromo->name}}
                                </td>
                                <td> {{$hipodromo->country}}</td>
                                <td>
                                    <div x-data="listener()" class="btn-group">
                                        <a href="/hipismo/hipodromos/{{$hipodromo->id}}/edit" class="btn btn-primary">Editar</a>
                                        @if($hipodromo->status == 1)
                                        <button @click="handleLock" id="{{$hipodromo->id}}" class="btn btn-danger">Desactivar</button>
                                        @else
                                        <button @click="handleLock" id="{{$hipodromo->id}}" class="btn btn-warning">Activar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex">
                        {!! $hipodromos->links() !!}
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
                    const res = await fetch('/hipismo/hipodromos/' + id, {
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