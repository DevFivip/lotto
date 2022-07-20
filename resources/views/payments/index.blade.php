@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 d-none d-sm-block">
            @include('components.sidemenu')
 </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Metodos de Pago</div>
                <div class="card-body">
                    <a href="{{$resource}}/create" class="btn btn-primary">Nuevo Metodo de Pago</a>
                    @if($errors->any())
                    <div class="alert alert-danger mt-2" role="alert">
                        <span class="strong">{{$errors->first()}}</span>
                    </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td>Estado</td>
                            <td>Nombre</td>
                            <td></td>
                        </tr>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                @if($payment->status === 1)
                                <span class="badge bg-warning text-dark">Activo</span>
                                @else
                                <span class="badge bg-danger">Desactivado</span>
                                @endif
                            </td>
                            <td>{{$payment->name}}</td>
                            <td>
                                <div x-data="listener()" class="btn-group">
                                    <a href="/{{$resource}}/{{$payment->id}}/edit" class="btn btn-primary">Editar</a>
                                    @if($payment->status === 1)
                                    <button @click="handleLock" id="{{$payment->id}}" class="btn btn-danger">Desactivar</button>
                                    @else
                                    <button @click='handleLock' id="{{$payment->id}}" class="btn btn-warning">Activar</button>
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
                if (confirm("¿Seguro deseas desactivar este metodo de pago?") == true) {
                    const res = await fetch('/payments/' + id, {
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