@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            @include('components.sidemenu')
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Clientes</div>
                <div class="card-body">
                    <a href="/{{$resource}}/create" class="btn btn-primary">Nuevo Cliente</a>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Nombre Completo</td>
                            <td>Documento</td>
                            <td>Teléfono</td>
                            <td>Email</td>
                            <td></td>
                        </tr>
                        @foreach($customers as $customer)
                        <tr>
                            <td>
                                @if($customer->status === 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Bloqueado</span>
                                @endif
                            </td>

                            <td>{{$customer->nombre}}</td>
                            <td>{{$customer->document}}</td>
                            <td>{{$customer->phone}}</td>
                            <td>{{$customer->email}}</td>

                            <td>
                                <div x-data="listener()" class="btn-group">
                                    <a href="/{{$resource}}/{{$customer->id}}/edit" class="btn btn-primary">Editar</a>
                                    @if($customer->status === 1)
                                    <button @click="handleLock" id="{{$customer->id}}" class="btn btn-danger">Bloquear</button>
                                    @else
                                    <button @click='eliminar("{{$customer->id}}")' class="btn btn-warning">Desbloquear</button>
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
                    const res = await fetch('/customers/' + id, {
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
    //         const res = await fetch('/customers/' + id, {
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