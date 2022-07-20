@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
 </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Animales</div>
                <div class="card-body">
                    <p class="text-small form-text ml-3">&nbsp;&nbsp;<i class="fa-solid fa-circle-exclamation"></i>&nbsp;Agregar ó Eliminar Animales directamente desde la base de datos</p>
                    <!-- @if($errors->any())
                        <div class="alert alert-danger mt-2" role="alert">
                            <span class="strong">{{$errors->first()}}</span>
                        </div>
                    @endif -->
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Numero</td>
                            <td>Nombre</td>
                            <td>Cantidad Limite</td>
                            <td>Monto Limite [$]</td>
                            <td></td>
                        </tr>
                        @foreach($animals as $animal)
                        <tr>
                            <td>
                                @if($animal->status == 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Bloqueado</span>
                                @endif
                            </td>
                            <td>{{$animal->number}}</td>
                            <td>{{$animal->nombre}}</td>
                            <td>{{$animal->limit_cant}}</td>
                            <td>{{$animal->limit_price_usd}}$</td>

                            <td>
                                <div x-data="listener()" class="btn-group">
                                    <a href="/{{$resource}}/{{$animal->id}}/edit" class="btn btn-primary">Editar</a>
                                    @if($animal->status == 1)
                                    <button @click="handleLock" id="{{$animal->id}}" class="btn btn-danger">Bloquear</button>
                                    @else
                                    <button @click='eliminar("{{$animal->id}}")' class="btn btn-warning">Desbloquear</button>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </table>
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
                if (confirm("¿Seguro deseas Bloquear?") == true) {
                    const res = await fetch('/animals/' + id, {
                        method: 'DELETE',
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": window.CSRF_TOKEN
                        },
                    })

                    alert()
                    location.reload()
                }
            }
        }
    }


    // window.CSRF_TOKEN = '{{ csrf_token() }}';
    // async function eliminar(id) {
    //     if (confirm("¿Seguro deseas Bloquear?") == true) {
    //         const res = await fetch('/animals/' + id, {
    //             method: 'DELETE',
    //             headers: {
    //                 "Content-Type": "application/json",
    //                 "Accept": "application/json",
    //                 "X-Requested-With": "XMLHttpRequest",
    //                 "X-CSRF-Token": window.CSRF_TOKEN
    //             },
    //         })

    //         location.reload()
    //     }
    // }
</script>

@endsection